@extends('layouts.plain')

@section('content')
<div class="w-full h-screen bg-gray-100">
    <nav class="bg-white/95 backdrop-blur-sm shadow-md">
        <img class="h-16 p-3" src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
    </nav>
    
    <div class="flex bg-gradient-to-r from-[#528CAC]/90 to-[#2C5282]/90 p-10 relative h-[calc(100%-8rem)]">
        <div class="flex-1 flex bg-white/50 rounded-xl shadow-2xl backdrop-blur-sm p-6">
            <div class="flex-[2] p-8 flex flex-col justify-evenly place-items-center min-w-[400px] border-r border-gray-200/80">
                <div class="aspect-square w-full max-w-96 min-w-80 rounded-2xl shadow-xl overflow-hidden">
                    <img class="object-cover w-full h-full bg-gray-50" src="{{ asset('assets/placeholder.png') }}" id="profile" alt="Student Profile">
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mt-6 flex items-center gap-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    <span id="student_id">(NONE)</span>
                </h1>
            </div>
            
            <div class="flex-[3] flex flex-col p-8 justify-between">
                <div class="space-y-6">
                    <div class="flex flex-col">
                        <label class="font-semibold text-lg mb-2 text-gray-700 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Name
                        </label>
                        <input class="bg-gray-50/70 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" id="name" readonly>
                    </div>

                    <div class="flex flex-col">
                        <label class="font-semibold text-lg mb-2 text-gray-700 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Department
                        </label>
                        <input class="bg-gray-50/70 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" id="department" readonly>
                    </div>

                    <div class="flex flex-col">
                        <label class="font-semibold text-lg mb-2 text-gray-700 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Year & Section
                        </label>
                        <input class="bg-gray-50/70 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" id="sect" readonly>
                    </div>

                    <div class="flex gap-6">
                        <div class="flex-1">
                            <label class="font-semibold text-lg mb-2 text-gray-700 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Date
                            </label>
                            <input class="w-full bg-gray-50/70 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" value="{{ date_create()->format('F j, Y') }}" id="date" readonly>
                        </div>
                        <div class="flex-1">
                            <label class="font-semibold text-lg mb-2 text-gray-700 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Time
                            </label>
                            <input class="w-full bg-gray-50/70 border border-gray-300 rounded-lg text-lg p-3 font-medium text-gray-800" type="text" value="{{ date_create()->format('h:i A') }}" id="time" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="h-16 flex items-center justify-center bg-white/95 backdrop-blur-sm shadow-inner">
        <h1 class="text-2xl font-semibold text-center flex items-center gap-2" id="status">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </h1>
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

        switch (state) {
            case 'IN':
            status.innerText = `Student ${rfid} - Entry Recorded: ${new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}`;
            status.style.color = '#22C55E'; // Tailwind green-500
            break;
            case 'OUT':
            status.innerText = `Student ${rfid} - Exit Recorded: ${new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}`;
            status.style.color = '#EF4444'; // Tailwind red-500
            break;
        }

        studentId.innerHTML = student.student_number;
        profile.src = student.image;
        name.value = `${student.first_name}${student.middle_name ? ` ${student.middle_name[0]}.` : ' '} ${student.last_name}`;
        department.value = student.department.name;
        sect.value = student.year_sec
    });
</script>
@endsection