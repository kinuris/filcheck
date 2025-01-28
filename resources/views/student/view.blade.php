@extends('layouts.plain')

@section('content')
<div class="w-full h-screen bg-gray-100">
    <nav class="bg-white shadow-md">
        <img class="h-16 p-3" src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
    </nav>
    
    <div class="flex bg-gradient-to-r from-[#528CAC] to-[#2C5282] p-10 relative h-[calc(100%-8rem)]">
        <div class="flex-1 flex bg-white/90 rounded-xl shadow-2xl backdrop-blur-sm p-6">
            <div class="flex-[2] p-8 flex flex-col justify-evenly place-items-center min-w-[400px] border-r border-gray-200">
                <div class="aspect-square w-full max-w-96 min-w-80 rounded-2xl shadow-xl overflow-hidden">
                    <img class="object-cover w-full h-full bg-gray-50" src="{{ asset('assets/placeholder.png') }}" id="profile" alt="Student Profile">
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mt-6" id="student_id">(NONE)</h1>
            </div>
            
            <div class="flex-[3] flex flex-col p-8 justify-between">
                <div class="space-y-6">
                    <div class="flex flex-col">
                        <label class="font-semibold text-lg mb-2 text-gray-700" for="name">Name</label>
                        <input class="bg-gray-50 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" id="name" readonly>
                    </div>

                    <div class="flex flex-col">
                        <label class="font-semibold text-lg mb-2 text-gray-700" for="department">Department</label>
                        <input class="bg-gray-50 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" id="department" readonly>
                    </div>

                    <div class="flex flex-col">
                        <label class="font-semibold text-lg mb-2 text-gray-700" for="sect">Year & Section</label>
                        <input class="bg-gray-50 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" id="sect" readonly>
                    </div>

                    <div class="flex gap-6">
                        <div class="flex-1">
                            <label class="font-semibold text-lg mb-2 text-gray-700" for="date">Date</label>
                            <input class="w-full bg-gray-50 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" value="{{ date_create()->format('F j, Y') }}" id="date" readonly>
                        </div>
                        <div class="flex-1">
                            <label class="font-semibold text-lg mb-2 text-gray-700" for="time">Time</label>
                            <input class="w-full bg-gray-50 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" value="{{ date_create()->format('h:i A') }}" id="time" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="h-16 flex items-center justify-center bg-white shadow-inner">
        <h1 class="text-2xl font-semibold text-center" id="status"></h1>
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