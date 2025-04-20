@extends('layouts.plain')

@section('content')
{{-- Main container using flex column to push footer down --}}
{{-- Use vh/vw units for dimensions and text sizes for proportional scaling --}}
<div class="flex flex-col w-screen h-screen bg-gray-100">
    {{-- Notification --}}
    {{-- Use vw for padding, min-width, text size, gap, icon size --}}
    {{-- Use vh for vertical positioning --}}
    <h1 id="notification" class="fixed top-[-100px] left-1/2 -translate-x-1/2 z-50 transition-transform duration-500 bg-white/95 backdrop-blur-sm py-[2vh] px-[4vw] rounded-[1.5vw] shadow-xl font-semibold flex flex-col items-center justify-center gap-[0.8vh] border-l-[0.5vw] border-blue-500 min-w-[35vw] max-w-[85%]">
        <div class="flex items-center gap-[1.5vw]">
            {{-- Increased icon size --}}
            <svg class="w-[3.5vw] h-[3.5vw]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{-- Increased title text size --}}
            <span class="text-[3vw]" id="notification-title">Status Update</span>
        </div>
        {{-- Increased subtitle text size --}}
        <p id="notification-subtitle" class="text-[1.5vw] font-normal text-gray-600"></p>
    </h1>

    {{-- Navbar - Use vh for height, vw for padding and logo height --}}
    <nav class="bg-white/95 backdrop-blur-sm shadow-md flex items-center flex-shrink-0 h-[8vh]">
        <img class="h-[6vh] px-[2vw]" src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
    </nav>

    {{-- Main Content Area - Grows to fill available space. Use vw for padding --}}
    <div class="flex-grow flex bg-gradient-to-br from-blue-100 via-white to-blue-100 p-[2vw] md:p-[3vw] overflow-hidden">
        {{-- Inner Content Box - Use vw for rounded corners --}}
        <div class="flex-1 flex flex-col md:flex-row bg-white/70 rounded-[1.5vw] shadow-2xl backdrop-blur-md overflow-hidden">
            {{-- Left Panel (Profile) - Use vw for padding, text size, gap, icon size, min/max width, rounded corners. Use vh for margin --}}
            <div class="flex-[1] md:flex-[2] p-[2vw] lg:p-[3vw] flex flex-col justify-center items-center border-b md:border-b-0 md:border-r border-gray-200/80">
                {{-- Student ID --}}
                <h2 class="text-[1.8vw] lg:text-[2.2vw] font-bold text-gray-800 flex items-center gap-[1vw] text-center break-all mb-[3vh]">
                    <svg class="w-[2.2vw] h-[2.2vw] lg:w-[2.5vw] lg:h-[2.5vw] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    <span id="student_id">(NONE)</span>
                </h2>
                {{-- Profile Image --}}
                <div class="aspect-square w-full max-w-[30vw] min-w-[20vw] rounded-[2vw] shadow-xl overflow-hidden">
                    <img class="object-cover w-full h-full bg-gray-200" src="{{ asset('assets/placeholder.png') }}" id="profile" alt="Student Profile">
                </div>
            </div>

            {{-- Right Panel (Details) - Scrollable. Use vw for padding, text size, gap, icon size, rounded corners. Use vh for vertical spacing --}}
            <div class="flex-[2] md:flex-[3] flex flex-col p-[2vw] lg:p-[3vw] justify-between overflow-y-auto">
                <div class="space-y-[2vh]">
                    {{-- Name --}}
                    <div class="flex flex-col">
                        <label class="font-semibold text-[1.2vw] lg:text-[1.4vw] mb-[0.5vh] text-gray-700 flex items-center gap-[0.8vw]">
                            <svg class="w-[1.5vw] h-[1.5vw]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Name
                        </label>
                        <input class="bg-gray-100 border border-gray-300 rounded-[1vw] text-[1.2vw] lg:text-[1.4vw] p-[1vw] font-medium text-gray-800 cursor-default focus:outline-none focus:ring-0" type="text" id="name" readonly>
                    </div>

                    {{-- Department --}}
                    <div class="flex flex-col">
                        <label class="font-semibold text-[1.2vw] lg:text-[1.4vw] mb-[0.5vh] text-gray-700 flex items-center gap-[0.8vw]">
                            <svg class="w-[1.5vw] h-[1.5vw]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Department
                        </label>
                        <input class="bg-gray-100 border border-gray-300 rounded-[1vw] text-[1.2vw] lg:text-[1.4vw] p-[1vw] font-medium text-gray-800 cursor-default focus:outline-none focus:ring-0" type="text" id="department" readonly>
                    </div>

                    {{-- Year & Section --}}
                    <div class="flex flex-col">
                        <label class="font-semibold text-[1.2vw] lg:text-[1.4vw] mb-[0.5vh] text-gray-700 flex items-center gap-[0.8vw]">
                            <svg class="w-[1.5vw] h-[1.5vw]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Year & Section
                        </label>
                        <input class="bg-gray-100 border border-gray-300 rounded-[1vw] text-[1.2vw] lg:text-[1.4vw] p-[1vw] font-medium text-gray-800 cursor-default focus:outline-none focus:ring-0" type="text" id="sect" readonly>
                    </div>

                    {{-- Date & Time --}}
                    <div class="flex flex-col sm:flex-row gap-[1.5vw]">
                        <div class="flex-1">
                            <label class="font-semibold text-[1.2vw] lg:text-[1.4vw] mb-[0.5vh] text-gray-700 flex items-center gap-[0.8vw]">
                                <svg class="w-[1.5vw] h-[1.5vw]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Date
                            </label>
                            <input class="w-full bg-gray-100 border border-gray-300 rounded-[1vw] text-[1.2vw] lg:text-[1.4vw] p-[1vw] font-medium text-gray-800 cursor-default focus:outline-none focus:ring-0" type="text" value="{{ date_create()->format('F j, Y') }}" id="date" readonly>
                        </div>
                        <div class="flex-1">
                            <label class="font-semibold text-[1.2vw] lg:text-[1.4vw] mb-[0.5vh] text-gray-700 flex items-center gap-[0.8vw]">
                                <svg class="w-[1.5vw] h-[1.5vw]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Time
                            </label>
                            <input class="w-full bg-gray-100 border border-gray-300 rounded-[1vw] text-[1.2vw] lg:text-[1.4vw] p-[1vw] font-medium text-gray-800 cursor-default focus:outline-none focus:ring-0" type="text" value="{{ date_create()->format('h:i A') }}" id="time" readonly>
                        </div>
                    </div>
                </div>
                {{-- Spacer div to push content up if not enough content to fill --}}
                <div class="flex-grow"></div>
            </div>
        </div>
    </div>

    {{-- Footer / Status Bar - Use vh for height, vw for padding, text size, gap, icon size --}}
    <div class="h-[8vh] flex items-center justify-center bg-white/95 backdrop-blur-sm shadow-[0_-2px_5px_-1px_rgba(0,0,0,0.1)] flex-shrink-0 px-[2vw]">
        <h2 class="text-[1.8vw] md:text-[2vw] font-semibold text-center flex items-center gap-[1vw] text-gray-700" id="status">
            <svg class="w-[2vw] h-[2vw]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Waiting for Scan...</span>
        </h2>
    </div>
</div>
@endsection

@section('script')

<script>
    let notificationTimeout = null;

    function animateNotification(message, subtitle, type) {
        const notification = document.getElementById('notification');
        const notificationTitle = document.getElementById('notification-title');
        const notificationSubtitle = document.getElementById('notification-subtitle');
        const icon = notification.querySelector('svg');

        // Clear any pending timeouts
        if (notificationTimeout) {
            clearTimeout(notificationTimeout);
            notificationTimeout = null;
        }

        notificationTitle.textContent = message;
        notificationSubtitle.textContent = subtitle || '';

        // Reset classes
        notification.classList.remove('border-green-500', 'border-red-500', 'border-blue-500', 'border-yellow-500');
        notificationTitle.parentElement.classList.remove('text-green-600', 'text-red-600', 'text-blue-600', 'text-yellow-600');
        icon.classList.remove('text-green-600', 'text-red-600', 'text-blue-600', 'text-yellow-600');

        // Apply new classes based on type
        let borderColor = 'border-blue-500';
        let textColor = 'text-blue-600';
        let iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'; // Default Info

        switch (type) {
            case 'success':
                borderColor = 'border-green-500';
                textColor = 'text-green-600';
                iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'; // Check
                break;
            case 'error':
                borderColor = 'border-red-500';
                textColor = 'text-red-600';
                iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'; // Exclamation
                break;
            case 'warning':
                 borderColor = 'border-yellow-500';
                 textColor = 'text-yellow-600';
                 iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>'; // Warning Triangle
                 break;
        }

        notification.classList.add(borderColor);
        notificationTitle.parentElement.classList.add(textColor);
        icon.classList.add(textColor); // Color the icon itself
        icon.innerHTML = iconPath; // Update icon shape

        // Animate down (adjust translateY based on navbar height (8vh) and desired spacing (e.g., 2vh))
        notification.style.transform = 'translateX(-50%) translateY(calc(8vh + 5vh))'; // 8vh navbar + 2vh spacing

        // Animate back up after 3 seconds
        notificationTimeout = setTimeout(() => {
            // Use top-[-100px] again or a vh equivalent if preferred for the hidden state
            notification.style.transform = 'translateX(-50%) translateY(-100px)'; // Or back to initial off-screen position
            notificationTimeout = null;
        }, 3000); // Keep visible for 3 seconds
    }
</script>

{{-- Keep the rest of the script section as it was, it handles logic not layout --}}
<script>
    const stream = new EventSource('http://localhost:8081/stream/current?stream=current');

    const profile = document.getElementById('profile');
    const studentId = document.getElementById('student_id');
    const name = document.getElementById('name');
    const department = document.getElementById('department');
    const sect = document.getElementById('sect');
    const date = document.getElementById('date');
    const time = document.getElementById('time'); // Get time element
    const status = document.getElementById('status');
    const statusIcon = status.querySelector('svg');
    const statusText = status.querySelector('span');

    function updateStatus(text, type) {
        statusText.textContent = text;

        // Reset colors and icons
        status.classList.remove('text-green-600', 'text-red-600', 'text-gray-700', 'text-yellow-600');
        statusIcon.classList.remove('text-green-600', 'text-red-600', 'text-gray-700', 'text-yellow-600');
        let iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'; // Default Info

        switch (type) {
            case 'success':
                status.classList.add('text-green-600');
                statusIcon.classList.add('text-green-600');
                iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'; // Check
                break;
            case 'error':
                status.classList.add('text-red-600');
                statusIcon.classList.add('text-red-600');
                iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'; // Exclamation
                break;
             case 'warning':
                 status.classList.add('text-yellow-600');
                 statusIcon.classList.add('text-yellow-600');
                 iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>'; // Warning Triangle
                 break;
            default: // Info or waiting
                status.classList.add('text-gray-700');
                statusIcon.classList.add('text-gray-700');
                break;
        }
         statusIcon.innerHTML = iconPath;
    }

    function resetStudentInfo() {
        profile.src = "{{ asset('assets/placeholder.png') }}";
        name.value = "";
        department.value = "";
        sect.value = "";
        studentId.textContent = "(NONE)"; // Use textContent for span
        date.value = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        time.value = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    }

    stream.addEventListener('message', async function(e) {
        const rfid = e.data;
        const currentTime = new Date();
        const formattedTime = currentTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        const formattedDate = currentTime.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

        // Update time immediately
        time.value = formattedTime;
        date.value = formattedDate;

        try {
            const [response, logResponse] = await Promise.all([
                fetch('/student/get/' + rfid),
                fetch('/student/log/' + rfid, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json', // Ensure we expect JSON
                    }
                }),
            ]);

            // --- Handle Student Not Found ---
            if (!response.ok) {
                 if (response.status === 404) {
                    updateStatus(`RFID ${rfid} - Student Not Found`, 'error');
                    animateNotification('Student Not Found', `RFID Tag: ${rfid}`, 'error');
                } else {
                    // Handle other potential fetch errors (e.g., 500)
                    updateStatus(`Error fetching student data (${response.status})`, 'error');
                    animateNotification('Fetch Error', `Could not retrieve student data for RFID: ${rfid}`, 'error');
                }
                resetStudentInfo(); // Clear previous student info
                return; // Stop processing if student not found or error
            }

            // --- Handle Logging Error ---
             if (!logResponse.ok) {
                let errorMsg = `Error logging student (${logResponse.status})`;
                try {
                    const errorData = await logResponse.json();
                    errorMsg = errorData.message || errorMsg; // Use server message if available
                } catch (jsonError) { /* Ignore if response is not JSON */ }

                updateStatus(errorMsg, 'error');
                animateNotification('Logging Error', errorMsg, 'error');
                // Optionally, still display student info even if logging failed
                // If you want to stop entirely on log error, add resetStudentInfo() and return here.
            }

            // --- Process Successful Responses ---
            const { student } = await response.json();
            // Check if logResponse was ok before trying to parse JSON
            let state = 'UNKNOWN'; // Default state if logging failed but we proceed
            if (logResponse.ok) {
                 const logData = await logResponse.json();
                 state = logData.state;
            }


            // Update student details
            studentId.textContent = student.student_number; // Use textContent for span
            profile.src = student.image || "{{ asset('assets/placeholder.png') }}"; // Fallback image
            name.value = `${student.first_name}${student.middle_name ? ` ${student.middle_name[0]}.` : ''} ${student.last_name}`;
            department.value = student.department ? student.department.name : 'N/A'; // Handle missing department
            sect.value = student.year_sec || 'N/A'; // Handle missing year/section

            // Update status and notification based on log state
            const studentName = `${student.first_name} ${student.last_name}`;
            switch (state) {
                case 'IN':
                    updateStatus(`Entry Recorded: ${formattedTime}`, 'success');
                    animateNotification('Entry Recorded', studentName, 'success');
                    break;
                case 'OUT':
                    updateStatus(`Exit Recorded: ${formattedTime}`, 'warning'); // Use warning for exit
                    animateNotification('Exit Recorded', studentName, 'warning'); // Changed to warning type
                    break;
                default:
                     // Handle cases where logging failed or state is unexpected
                     if (!logResponse.ok) {
                         // Status/Notification already handled in the logging error block
                         // Only display student info here
                     } else {
                         updateStatus(`Unknown Log State: ${state}`, 'warning');
                         animateNotification('Unknown Status', `Received state: ${state} for ${studentName}`, 'warning');
                     }
            }

        } catch (error) {
            console.error("Error processing RFID:", error);
            updateStatus('Processing Error', 'error');
            animateNotification('System Error', 'An error occurred while processing the scan.', 'error');
            resetStudentInfo(); // Reset on unexpected errors
        }
    });

    // Handle connection errors for EventSource
    stream.addEventListener('error', function(e) {
        console.error("EventSource failed:", e);
        updateStatus('Connection Error', 'error');
        animateNotification('Connection Lost', 'Unable to connect to the scanning service.', 'error');
        // Optionally try to reconnect or inform the user more permanently
    });

    // Initial state
    resetStudentInfo();
    updateStatus('Waiting for Scan...', 'info');
</script>
@endsection