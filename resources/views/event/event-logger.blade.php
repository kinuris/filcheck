@extends('layouts.plain')

@section('content')
{{-- Notification Banner (Initially hidden off-screen using transform) --}}
<div id="notification-banner" class="fixed transition-transform duration-300 ease-in-out top-0 left-0 right-0 z-50 p-4 transform -translate-y-full">
    {{-- Centered container with refined styling and structure --}}
    {{-- The JS will need to add border-l-4 and border-color (e.g., border-green-400) to this div based on status --}}
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 flex items-center space-x-4 p-4">
        {{-- Status Icon Area (JS should populate this with an appropriate SVG icon and color) --}}
        <div id="notification-status-icon" class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
            {{-- Placeholder: JS will insert SVG like check, cross, or warning icon here --}}
            {{-- Example for JS: element.innerHTML = '<svg class="h-6 w-6 text-green-500" ...>...</svg>'; --}}
        </div>

        {{-- Attendee Image --}}
        <div class="flex-shrink-0">
            <img id="notification-image" class="h-12 w-12 rounded-full object-cover border border-gray-100" src="{{ asset('assets/placeholder.png') }}" alt="Attendee">
        </div>

        {{-- Text Content (Takes remaining space and allows wrapping) --}}
        <div class="flex-1 min-w-0">
            {{-- Main notification text (e.g., Attendee Name) --}}
            <p id="notification-text" class="text-base font-semibold text-gray-800 truncate">Notification Text</p>
            {{-- Subtext (e.g., Status and Time) --}}
            <p id="notification-subtext" class="text-sm text-gray-500">Subtext</p>
        </div>

        {{-- Optional: Close Button (If manual dismissal is desired) --}}
        {{-- <button onclick="document.getElementById('notification-banner').classList.add('-translate-y-full'); document.getElementById('notification-banner').classList.remove('translate-y-0');" class="text-gray-400 hover:text-gray-600 flex-shrink-0 ml-auto -mr-1 p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300">
            <span class="sr-only">Close</span>
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button> --}}
    </div>
    {{-- Note: Ensure the accompanying JavaScript is updated to:
        1. Add/remove border color classes (e.g., 'border-green-400') and 'border-l-4' on the div with 'max-w-md'.
        2. Populate the '#notification-status-icon' div with the correct SVG icon and text color (e.g., 'text-green-500').
        3. Update '#notification-image', '#notification-text', and '#notification-subtext' as before.
        4. Control the visibility using '-translate-y-full' and 'translate-y-0' on '#notification-banner'.
    --}}
</div>

{{-- Main container with max height and gradient background --}}
<div class="max-h-screen h-screen overflow-y-auto bg-gradient-to-br from-indigo-100 via-blue-100 to-sky-100 py-8 md:py-12"> {{-- Added max-h-screen, h-screen, overflow-y-auto --}}
    @include('includes.receiver-notifier')

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section: Event Title and Location --}}
        <header class="mb-4 md:mb-4 bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                {{-- Event Name --}}
                <div class="flex items-center">
                    {{-- Calendar Icon (Indigo) --}}
                    <svg class="w-8 h-8 mr-3 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 leading-tight">
                        {{ $event->name }}
                    </h1>
                </div>
                {{-- Event Address --}}
                <div class="text-gray-600 text-sm sm:text-base flex items-center">
                    {{-- Map Pin Icon (Indigo) --}}
                    <svg class="w-5 h-5 mr-2 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $event->address }}</span>
                </div>
            </div>
        </header>

        {{-- Main Content Grid --}}
        <main class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Event Details Column (Spans 2 columns on large screens) --}}
            <section class="lg:col-span-2 bg-white rounded-lg shadow-lg p-6 md:p-8 border border-gray-200">
                <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-6 flex items-center border-b pb-4 border-gray-100">
                    {{-- Information Circle Icon (Indigo) --}}
                    <svg class="w-6 h-6 mr-3 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Event Information
                </h2>

                <div class="space-y-6">
                    {{-- Description Section --}}
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                            {{-- Document Text Icon (Indigo) --}}
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Description
                        </h3>
                        <p class="text-gray-700 leading-relaxed prose max-w-none">{{ $event->description ?: 'No description provided.' }}</p>
                    </div>

                    {{-- Key Details Section (Using Definition List) --}}
                    <dl class="border-t border-gray-100 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        {{-- Event ID --}}
                        <div class="flex items-start sm:items-center">
                            <dt class="flex items-center text-sm font-medium text-gray-500 w-24 flex-shrink-0">
                                {{-- Ticket Icon (Indigo) --}}
                                <svg class="w-5 h-5 mr-2 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                Event ID
                            </dt>
                            <dd class="ml-3 text-sm text-gray-900 break-words">{{ $event->event_id }}</dd>
                        </div>
                        {{-- Start Time --}}
                        <div class="flex items-start sm:items-center">
                            <dt class="flex items-center text-sm font-medium text-gray-500 w-24 flex-shrink-0">
                                {{-- Clock Icon (Indigo) --}}
                                <svg class="w-5 h-5 mr-2 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Starts
                            </dt>
                            <dd class="ml-3 text-sm text-gray-900">{{ $event->start->format('M d, Y H:i A') }}</dd>
                        </div>
                        {{-- End Time --}}
                        <div class="flex items-start sm:items-center">
                            <dt class="flex items-center text-sm font-medium text-gray-500 w-24 flex-shrink-0">
                                {{-- Clock Icon (Indigo) --}}
                                <svg class="w-5 h-5 mr-2 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Ends
                            </dt>
                            <dd class="ml-3 text-sm text-gray-900 flex flex-wrap items-center gap-x-3 gap-y-1">
                                <span>{{ $event->end->format('M d, Y H:i A') }}</span>
                                @if($event->hasEnded())
                                {{-- Using blue for the ended badge --}}
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"> {{-- Changed from yellow --}}
                                    Ended {{ $event->end->diffForHumans() }}
                                </span>
                                @endif
                            </dd>
                        </div>
                    </dl>

                    {{-- Ended Event Notice (Changed to blue theme) --}}
                    @if ($event->hasEnded())
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-6 rounded-r-md"> {{-- Changed from yellow --}}
                        <div class="flex">
                            <div class="flex-shrink-0">
                                {{-- Using an information icon instead of warning --}}
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"> {{-- Changed from yellow --}}
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700"> {{-- Changed from yellow --}}
                                    This event concluded on {{ $event->end->format('M d, Y') }}. Attendance logging may no longer be active.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </section>

            {{-- Attendee Scan Column --}}
            <section class="lg:col-span-1 bg-white rounded-lg shadow-lg p-6 md:p-8 border border-gray-200 flex flex-col items-center justify-start">
                <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-6 flex items-center border-b pb-4 border-gray-100 w-full justify-center">
                    {{-- QR Code Icon (Indigo) --}}
                    <svg class="w-6 h-6 mr-3 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Attendee Scan
                </h2>
                {{-- Profile Image Area with aspect ratio maintained --}}
                <div class="w-full max-w-xs md:max-w-sm aspect-square rounded-lg overflow-hidden border-4 border-transparent p-1 bg-gradient-to-br from-indigo-300 to-blue-300 shadow-inner mb-6 flex items-center justify-center"> {{-- aspect-square ensures 1:1 ratio --}}
                    <div class="bg-gray-100 w-full h-full rounded-md flex items-center justify-center">
                        <img class="object-cover w-full h-full rounded-md" src="{{ asset('assets/placeholder.png') }}" id="profile" alt="Scanned Attendee Profile">
                    </div>
                </div>
                {{-- Scanned ID Display --}}
                <div class="text-center w-full bg-gray-50 p-3 rounded-md border border-gray-100">
                    <p class="text-lg font-medium text-gray-800 flex items-center justify-center space-x-2" id="student_id">
                        {{-- User Circle Icon (Indigo) --}}
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-600">(Scan Attendee ID)</span>
                    </p>
                </div>
            </section>

        </main>
    </div>
</div>
@endsection

@section('script')
@include('includes.receiver-script')
<script>
    const stream = new EventSource('http://localhost:8081/stream/current?stream=current');

    const profile = document.getElementById('profile');
    const studentIdDisplay = document.getElementById('student_id'); // Renamed for clarity

    // Notification Banner Elements
    const notificationBanner = document.getElementById('notification-banner');
    const notificationImage = document.getElementById('notification-image');
    const notificationText = document.getElementById('notification-text');
    const notificationSubtext = document.getElementById('notification-subtext');
    let notificationTimeout; // To manage the timeout for hiding the banner

    function showNotification(imageUrl, text, subtext, isSuccess) {
        // Clear any existing timeout
        if (notificationTimeout) {
            clearTimeout(notificationTimeout);
        }

        // Update banner content
        notificationImage.src = imageUrl;
        notificationText.textContent = text;
        notificationSubtext.textContent = subtext;

        // Update banner style (e.g., background color based on success/failure)
        const bannerContent = notificationBanner.querySelector('.bg-white'); // Find the inner div
        bannerContent.classList.remove('bg-green-50', 'bg-red-50', 'bg-yellow-50', 'border-green-400', 'border-red-400', 'border-yellow-400', 'border-l-4'); // Clear previous styles
        notificationText.classList.remove('text-green-800', 'text-red-800', 'text-yellow-800');
        notificationSubtext.classList.remove('text-green-700', 'text-red-700', 'text-yellow-700');

        if (isSuccess === true) { // Check-in
            bannerContent.classList.add('bg-green-50', 'border-green-400');
            notificationText.classList.add('text-green-800');
            notificationSubtext.classList.add('text-green-700');
        } else if (isSuccess === false) { // Check-out
            bannerContent.classList.add('bg-red-50', 'border-red-400');
            notificationText.classList.add('text-red-800');
            notificationSubtext.classList.add('text-red-700');
        } else { // Error / Not Found
            bannerContent.classList.add('bg-yellow-50', 'border-yellow-400');
            notificationText.classList.add('text-yellow-800');
            notificationSubtext.classList.add('text-yellow-700');
        }
        bannerContent.classList.add('border-l-4'); // Add the left border style


        // Animate down: Remove the class that hides it, add the class that shows it
        // The CSS transition handles the smooth movement
        notificationBanner.classList.remove('-translate-y-full');
        notificationBanner.classList.add('translate-y-0');

        // Set timeout to animate up after 1.5 seconds
        notificationTimeout = setTimeout(() => {
            // Animate up: Remove the class that shows it, add the class that hides it
            // The CSS transition handles the smooth movement
            notificationBanner.classList.remove('translate-y-0');
            notificationBanner.classList.add('-translate-y-full');
        }, 1500); // 1.5 seconds
    }

    stream.addEventListener('message', async function(e) {
        const rfid = e.data;

        // Reset main display immediately for visual feedback
        profile.src = "{{ asset('assets/placeholder.png') }}";
        studentIdDisplay.innerHTML = `
            <svg class="w-6 h-6 text-indigo-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span class="text-gray-500">Processing ${rfid}...</span>`;
        studentIdDisplay.classList.remove('text-green-500', 'text-red-500');

        try {
            const [studentResponse, logResponse] = await Promise.all([
                fetch('/student/get/' + rfid),
                fetch('/event/node/attendance/log', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json', // Added Content-Type
                        'Accept': 'application/json', // Added Accept
                    },
                    body: JSON.stringify({
                        rfid,
                        event_id: '{{ $event->id }}',
                    }),
                }),
            ]);

            // --- Handle Student Not Found ---
            if (studentResponse.status !== 200) {
                const errorText = `RFID ${rfid} Not Found`;
                studentIdDisplay.classList.remove('text-green-500');
                studentIdDisplay.classList.add('text-red-500');
                studentIdDisplay.innerHTML = `
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>${errorText}</span>`;
                profile.src = "{{ asset('assets/placeholder.png') }}";

                // Show error notification
                showNotification("{{ asset('assets/placeholder.png') }}", "Scan Error", errorText, null); // null for error state
                return;
            }

            const {
                student
            } = await studentResponse.json();

            const log = await logResponse.json();

            if (logResponse.status === 405) {
                try {
                    const errorText = `${student.first_name} ${student.last_name} is not registered for this event.`;
                    studentIdDisplay.classList.remove('text-green-500');
                    studentIdDisplay.classList.add('text-red-500');
                    studentIdDisplay.innerHTML = `
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg> {{-- Ban Icon --}}
                        <span>${errorText}</span>`;
                    // Use profile_picture field, provide full URL path if needed
                    profile.src = student.profile_picture ? `/storage/student/images/${student.profile_picture}` : "{{ asset('assets/placeholder.png') }}";
                    // Show specific error notification
                    showNotification(profile.src, "Registration Error", errorText, null);
                } catch (parseError) {
                    // Fallback if student data isn't in the 405 response
                    console.error("Could not parse student data from 405 response:", parseError);
                    const errorText = `Student with RFID ${rfid} not registered for this event.`;
                    studentIdDisplay.classList.remove('text-green-500');
                    studentIdDisplay.classList.add('text-red-500');
                    studentIdDisplay.innerHTML = `
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg> {{-- Ban Icon --}}
                        <span>${errorText}</span>`;
                    profile.src = "{{ asset('assets/placeholder.png') }}";
                    showNotification("{{ asset('assets/placeholder.png') }}", "Registration Error", errorText, null);
                }
                return; // Stop processing this scan
            }

            if (student?.role === 'Teacher' && studentResponse.status === 200) {
                const errorText = `RFID ${rfid} Not Found`;
                studentIdDisplay.classList.remove('text-green-500');
                studentIdDisplay.classList.add('text-red-500');
                studentIdDisplay.innerHTML = `
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>${errorText}</span>`;
                profile.src = "{{ asset('assets/placeholder.png') }}";

                // Show error notification
                showNotification("{{ asset('assets/placeholder.png') }}", "Scan Error", errorText, null); // null for error state
                return;
            }

            // --- Handle Log Error ---
            if (logResponse.status !== 200) {
                const studentData = await studentResponse.json(); // Still need student data for context
                const student = studentData.student;
                const errorText = `Log Error for ${student.first_name}`;
                console.error('Log Error:', logResponse.status, await logResponse.text()); // Log details

                studentIdDisplay.classList.remove('text-green-500');
                studentIdDisplay.classList.add('text-red-500');
                studentIdDisplay.innerHTML = `
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>${errorText} (Check Console)</span>`;
                profile.src = student.image || "{{ asset('assets/placeholder.png') }}"; // Show student image if available

                // Show error notification
                showNotification(profile.src, "Log Error", `Could not log attendance for ${student.first_name}.`, null);
                return;
            }

            // --- Process Successful Scan ---


            profile.src = student.image || "{{ asset('assets/placeholder.png') }}"; // Use placeholder if no image

            const logTime = new Date(log.time.date).toLocaleString('en-US', {
                // month: 'short', day: 'numeric', year: 'numeric', // Removed date parts for brevity
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });

            let statusText = '';
            let notificationMainText = '';
            let notificationSubText = '';
            let isCheckIn = false;

            studentIdDisplay.classList.remove('text-red-500', 'text-green-500'); // Clear previous colors

            if (log.type === 'ENTER') {
                studentIdDisplay.classList.add('text-green-500');
                statusText = `Checked In at ${logTime}`;
                notificationMainText = `${student.first_name} ${student.last_name}`;
                notificationSubText = `Checked In: ${logTime}`;
                isCheckIn = true; // Success (Check-in)
            } else { // EXIT
                studentIdDisplay.classList.add('text-red-500');
                statusText = `Checked Out at ${logTime}`;
                notificationMainText = `${student.first_name} ${student.last_name}`;
                notificationSubText = `Checked Out: ${logTime}`;
                isCheckIn = false; // Success (Check-out)
            }

            // Update main display
            studentIdDisplay.innerHTML = `
                <svg class="w-6 h-6 ${isCheckIn ? 'text-green-500' : 'text-red-500'}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    ${isCheckIn
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' // Check Circle
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' // X Circle
                    }
                </svg>
                <span>${student.first_name} ${student.last_name} - ${statusText}</span>`;

            // Show success notification
            showNotification(profile.src, notificationMainText, notificationSubText, isCheckIn);

        } catch (error) {
            console.error("Error processing scan:", error);
            const errorText = "Processing Error";
            studentIdDisplay.classList.remove('text-green-500');
            studentIdDisplay.classList.add('text-red-500');
            studentIdDisplay.innerHTML = `
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>${errorText} (Check Console)</span>`;
            profile.src = "{{ asset('assets/placeholder.png') }}";

            // Show error notification
            showNotification("{{ asset('assets/placeholder.png') }}", "Error", "An unexpected error occurred.", null);
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Event logger page initialized.');
        // The banner is initially hidden by the '-translate-y-full' class in the HTML.
        // The CSS transition defined in the <style> block ensures smooth animation
        // when the JavaScript adds/removes the 'translate-y-0' and '-translate-y-full' classes.
    });
</script>
@endsection