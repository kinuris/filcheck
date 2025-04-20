@extends('layouts.plain')

@section('content')
<div class="w-screen h-screen relative overflow-hidden">
    {{-- Background --}}
    <div class="absolute w-full h-full">
        <img class="object-cover h-full w-full absolute blur-[3px]" src="{{ asset('assets/bg.png') }}" alt="Background" >
        <div class="h-full w-full bg-gray-900/70 absolute z-10"></div>
    </div>

    {{-- Header Controls --}}
    <div class="absolute top-4 left-4 z-50 flex items-center space-x-4">
        <a href="/" class="text-white bg-gray-700/80 hover:bg-gray-600/80 px-4 py-2 rounded-md shadow backdrop-blur-sm transition-colors">
            Back
        </a>

        @php($subject = $room->scheduleAt(date_create('now')->format('H:i')))
        <div class="text-white bg-gray-700/80 px-4 py-2 rounded-md shadow backdrop-blur-sm">
            Current Subject: <span id="current-subject" class="font-semibold">{{ is_null($subject) ? '(None)' : $subject->subject->name }}</span>
        </div>

        <div class="text-white bg-gray-700/80 px-4 py-2 rounded-md shadow backdrop-blur-sm">
            Section: <span id="current-section" class="font-semibold">{{ is_null($subject) ? '(None)' : $subject->section }}</span>
        </div>

        <a href="javascript:location.reload()" class="text-white rounded-full p-1.5 hover:bg-gray-600/80 hover:rotate-180 transition-all duration-300 backdrop-blur-sm" title="Refresh Page">
            <span class="material-symbols-outlined text-2xl align-middle">
                refresh
            </span>
        </a>
    </div>

    {{-- Main Content Area --}}
    <div class="absolute inset-0 flex items-center justify-center z-20 p-5 md:p-10 mt-12">
        {{-- Content Box --}}
        <div class="bg-gray-800/60 backdrop-blur-md rounded-xl shadow-2xl flex flex-col md:flex-row w-full max-w-[85vw] h-auto md:h-[85vh] text-white overflow-hidden">

            {{-- Left Side: Image & Message --}}
            <div class="w-full md:w-2/5 flex flex-col items-center justify-center p-6 md:p-8 border-b md:border-b-0 md:border-r border-gray-600/50">
                 <div class="bg-white p-1.5 rounded-lg shadow-lg w-full max-w-xs sm:max-w-sm md:max-w-md aspect-square mb-4">
                    <img class="w-full h-full object-cover rounded" src="{{ asset('assets/placeholder.png') }}" alt="Student Profile Image" id="profile">
                </div>
                 {{-- Message Area --}}
                 <p class="p-3 mt-2 w-full text-center rounded text-sm min-h-[50px]" id="message"></p>
            </div>

            {{-- Right Side: Details --}}
            <div class="w-full md:w-3/5 flex flex-col justify-center p-6 md:p-12 space-y-5 md:space-y-6">
                <div>
                    <label for="name" class="block text-base md:text-lg font-medium text-gray-300 mb-1">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-3 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-base md:text-lg bg-gray-700/50 text-white placeholder-gray-400" readonly>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label for="section" class="block text-base md:text-lg font-medium text-gray-300 mb-1">Section</label>
                        <input type="text" name="section" id="section" class="mt-1 block w-full px-4 py-3 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-base md:text-lg bg-gray-700/50 text-white placeholder-gray-400" readonly>
                    </div>
                    <div>
                        <label for="year_level" class="block text-base md:text-lg font-medium text-gray-300 mb-1">Year Level</label>
                        <input type="text" name="year_level" id="year_level" class="mt-1 block w-full px-4 py-3 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-base md:text-lg bg-gray-700/50 text-white placeholder-gray-400" readonly>
                    </div>
                </div>

                 <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label for="date" class="block text-base md:text-lg font-medium text-gray-300 mb-1">Date</label>
                        <input type="text" name="date" id="date" class="mt-1 block w-full px-4 py-3 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-base md:text-lg bg-gray-700/50 text-white placeholder-gray-400" readonly>
                    </div>
                    <div>
                        <label for="time" class="block text-base md:text-lg font-medium text-gray-300 mb-1">Time</label>
                        <input type="text" name="time" id="time" class="mt-1 block w-full px-4 py-3 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-base md:text-lg bg-gray-700/50 text-white placeholder-gray-400" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.receiver-notifier')
@endsection

@section('script')
@include('includes.receiver-script')
<script>
    const stream = new EventSource('http://localhost:8081/stream/current?stream=current');
    const messageEl = document.getElementById('message');
    const profileImgEl = document.getElementById('profile');
    const nameInput = document.getElementById('name');
    const sectionInput = document.getElementById('section');
    const yearLevelInput = document.getElementById('year_level');
    const dateInput = document.getElementById('date');
    const timeInput = document.getElementById('time');
    const placeholderImgSrc = "{{ asset('assets/placeholder.png') }}";

    // Define CSS classes for messages
    const baseMessageClasses = ['px-4', 'py-2', 'rounded', 'shadow-md', 'font-medium'];
    const successMessageClasses = ['text-green-800', 'bg-green-100', 'border', 'border-green-400', ...baseMessageClasses];
    const errorMessageClasses = ['text-red-800', 'bg-red-100', 'border', 'border-red-400', ...baseMessageClasses];

    function clearStudentInfo() {
        nameInput.value = '';
        sectionInput.value = '';
        yearLevelInput.value = '';
        dateInput.value = '';
        timeInput.value = '';
        profileImgEl.src = placeholderImgSrc;
    }

    function displayMessage(text, type) {
        messageEl.textContent = text;
        // Reset classes first
        messageEl.className = 'p-3 mt-2 w-full text-center rounded text-sm min-h-[50px]'; // Base classes from HTML
        // Add specific type classes
        const classesToAdd = type === 'success' ? successMessageClasses : errorMessageClasses;
        messageEl.classList.add(...classesToAdd);
    }

    stream.addEventListener('message', async function(e) {
        // Clear previous message immediately
        messageEl.textContent = '';
        messageEl.className = 'p-3 mt-2 w-full text-center rounded text-sm min-h-[50px]'; // Reset classes

        const scheduleId = "{{ $subject->id ?? '-1' }}";
        if (scheduleId === '-1') {
            displayMessage('No active subject schedule found for this room.', 'error');
            clearStudentInfo();
            return;
        }

        try {
            const response = await fetch(`/attendance/record/${e.data}/${scheduleId}`);

            if (!response.ok) {
                console.error('Server error:', response.status, response.statusText);
                const errorText = await response.text(); // Try to get more error details
                displayMessage(`Error recording attendance: ${response.status} ${response.statusText}. ${errorText}`, 'error');
                clearStudentInfo();
                return;
            }

            const data = await response.json();

            if (data.status === 'ssnf' || data.status === 'error') { // Handle specific error statuses from backend
                displayMessage(data.message || 'An unknown error occurred.', 'error');
                clearStudentInfo();
                return;
            }

            if (data.status === 'success') {
                // Check if student data exists
                if (!data.student) {
                     displayMessage('Received success status but no student data.', 'error');
                     clearStudentInfo();
                     return;
                }

                let student;
                try {
                    // Student data might be a JSON string or already an object
                    student = typeof data.student === 'string' ? JSON.parse(data.student) : data.student;
                } catch (parseError) {
                    console.error('Error parsing student data:', parseError);
                    displayMessage('Error processing student data.', 'error');
                    clearStudentInfo();
                    return;
                }


                nameInput.value = student.fullname || '';
                sectionInput.value = student.section || '';
                yearLevelInput.value = student.year || '';
                dateInput.value = student.date || '';
                timeInput.value = student.time || '';
                profileImgEl.src = student.profile || placeholderImgSrc; // Fallback to placeholder

                displayMessage(data.message || 'Attendance recorded successfully.', 'success');
            } else {
                 displayMessage(data.message || 'Received unknown status from server.', 'error');
                 clearStudentInfo();
            }

        } catch (error) {
            console.error('Fetch or processing error:', error);
            displayMessage('Failed to connect or process the request.', 'error');
            clearStudentInfo();
        }
    });

    // Optional: Clear info on stream error
    stream.addEventListener('error', function(e) {
        console.error('EventSource failed:', e);
        displayMessage('Connection to update stream lost. Please refresh.', 'error');
        // clearStudentInfo(); // Decide if you want to clear info on connection loss
    });
</script>
@endsection