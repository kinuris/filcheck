@extends('layouts.plain')

@section('content')
<div class="w-full h-screen">
    <img class="h-12 p-2" src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
    <div class="flex bg-[#528CAC]/90 p-8 relative h-[calc(100%-7rem)]">
        <div class="flex-1 flex">
            <div class="flex-[2] p-8 flex flex-col justify-evenly place-items-center min-w-[400px]">
                <div class="aspect-square border border-black w-full max-w-96 min-w-80 rounded-2xl shadow-lg shadow-slate-600">
                    <img class="object-cover aspect-square rounded-2xl bg-white" src="{{ asset('assets/placeholder.png') }}" id="profile" alt="Student Profile">
                </div>
                <h1 class="text-3xl font-extrabold text-white" id="student_id">(NONE)</h1>
            </div>
            <div class="flex-[3] flex flex-col p-8 justify-between">
                <div class="flex flex-col">
                    <label class="font-extrabold text-xl mb-3 text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]" for="name">NAME</label>
                    <input class="border-black shadow-lg border rounded-lg text-xl bg-blue-100 p-2 font-bold" type="text" id="name" readonly>
                </div>

                <div class="flex flex-col">
                    <label class="font-extrabold text-xl mb-3 text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]" for="department">DEPARTMENT</label>
                    <input class="border-black shadow-lg border rounded-lg text-xl bg-blue-100 p-2 font-bold" type="text" id="department" readonly>
                </div>

                <div class="flex flex-col">
                    <label class="font-extrabold text-xl mb-3 text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]" for="sect">YEAR & SECTION</label>
                    <input class="border-black shadow-lg border rounded-lg text-xl bg-blue-100 p-2 font-bold" type="text" id="sect" readonly>
                </div>

                <div class="flex justify-between">
                    <div class="flex flex-col flex-1">
                        <label class="font-extrabold text-xl mb-3 text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]" for="date">DATE</label>
                        <input class="border-black shadow-lg border rounded-lg text-xl bg-blue-100 p-2 font-bold" type="text" value="{{ date_create()->format('F j, Y') }}" id="date" readonly>
                    </div>

                    <div class="mx-5"></div>

                    <div class="flex flex-col flex-1">
                        <label class="font-extrabold text-xl mb-3 text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]" for="time">TIME</label>
                        <input class="border-black shadow-lg border rounded-lg text-xl bg-blue-100 p-2 font-bold" type="text" value="{{ date_create()->format('h:i A') }}" id="time" readonly>
                    </div>
                </div>
            </div>
        </div>
        <img class="absolute top-0 left-0 -z-[1] h-full" src="{{ asset('assets/bg.png') }}" alt="Background">
    </div>
    <div class="h-16 flex flex-col justify-center">
        <h1 class="text-3xl font-extrabold text-center" id="status"></h1>
    </div>
</div>
@endsection

@section('script')
<script>
    const stream = new EventSource('http://localhost:8081/stream/current?stream=current');

    const profile = document.getElementById('profile');
    const studentId = document.getElementById('student_id');
    const name = document.getElementById('name');
    const department = document.getElementById('department');
    const sect = document.getElementById('sect');
    const date = document.getElementById('date');
    const status = document.getElementById('status');

    stream.addEventListener('message', async function(e) {
        const rfid = e.data;

        const [response, logResponse] = await Promise.all([
            fetch('/student/get/' + rfid),
            fetch('/student/log/' + rfid, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            }),
        ]);

        if (response.status !== 200) {
            status.innerText = `RFID: ${rfid} - Student NOT FOUND`;
            status.style.color = 'red'

            profile.src = "{{ asset('assets/placeholder.png') }}";
            name.value = "";
            department.value = "";
            sect.value = "";
            studentId.innerHTML = "(NONE)"

            return;
        }

        const {
            state
        } = await logResponse.json();

        const {
            student
        } = await response.json();

        // fetch('/student/guardian/notify/' + student.id, { 
        //     method: 'POST',
        //     headers: {
        //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //     },
        // });

        if (state === 'IN') {
            status.innerText = `RFID: ${rfid} - Entered Campus at ${new Date().toLocaleString()}`;
            status.style.color = 'green';
        } else {
            status.innerText = `RFID: ${rfid} - Leaving Campus at ${new Date().toLocaleString()}`;
            status.style.color = 'red';
        }

        studentId.innerHTML = student.student_number;
        profile.src = student.image;
        name.value = `${student.first_name}${student.middle_name ? ` ${student.middle_name[0]}.` : ' '} ${student.last_name}`;
        department.value = student.department.name;
        sect.value = student.year_sec
    });
</script>
@endsection