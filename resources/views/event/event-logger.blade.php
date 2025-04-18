@extends('layouts.plain')

@section('content')
{{-- Main container with a refined gradient background and padding --}}
<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-100 to-sky-100 py-8 md:py-12"> {{-- Adjusted gradient: more blue, less yellow --}}
    @include('includes.receiver-notifier')

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section: Event Title and Location --}}
        <header class="mb-8 md:mb-12 bg-white rounded-lg shadow-md p-6 border border-gray-200">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
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
                {{-- Profile Image Area with indigo-to-blue gradient border --}}
                <div class="w-full max-w-xs md:max-w-sm aspect-square rounded-lg overflow-hidden border-4 border-transparent p-1 bg-gradient-to-br from-indigo-300 to-blue-300 shadow-inner mb-6 flex items-center justify-center"> {{-- Changed gradient end to blue --}}
                    <div class="bg-gray-100 w-full h-full rounded-md flex items-center justify-center">
                        <img class="object-cover w-full h-full rounded-md" src="{{ asset('assets/placeholder.png') }}" id="profile" alt="Scanned Attendee Profile">
                        {{-- Optional: Placeholder text inside image area --}}
                        {{-- <span class="text-gray-400 italic text-center p-4">Scan an ID to display profile picture</span> --}}
                    </div>
                </div>
                {{-- Scanned ID Display with subtle background --}}
                <div class="text-center w-full bg-gray-50 p-3 rounded-md border border-gray-100">
                    <p class="text-lg font-medium text-gray-800 flex items-center justify-center space-x-2" id="student_id">
                         {{-- User Circle Icon (Indigo) --}}
                         <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-600">(Scan Attendee ID)</span>
                    </p>
                    {{-- Optional: Area for status messages related to scanning --}}
                    {{-- <p id="scan-status" class="text-sm text-gray-500 mt-2 h-4"></p> --}}
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
    const studentId = document.getElementById('student_id');

    stream.addEventListener('message', async function(e) {
        const rfid = e.data;

        const [studentResponse, logResponse] = await Promise.all([
            fetch('/student/get/' + rfid),
            fetch('/event/node/attendance/log', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    rfid,
                    event_id: '{{ $event->id }}',
                }),
            }),
        ]);

        if (studentResponse.status !== 200) {
            studentId.classList.remove('text-green-500');
            studentId.classList.remove('text-red-500');
            studentId.classList.add('text-red-500');
            studentId.innerHTML = "(RFID NOT FOUND)";
            profile.src = "{{ asset('assets/placeholder.png') }}";

            return;
        }

        const {
            student
        } = await studentResponse.json();
        const log = await logResponse.json();

        profile.src = student.image;

        studentId.classList.remove('text-red-500');

        if (log.type === 'ENTER') {
            studentId.classList.add('text-green-500');
            const logTime = new Date(log.time.date).toLocaleString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
            studentId.innerHTML = `${student.first_name} ${student.last_name} has checked in at ${logTime}`;
        } else {
            const logTime = new Date(log.time.date).toLocaleString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
            studentId.classList.add('text-red-500');
            studentId.innerHTML = `${student.first_name} ${student.last_name} has checked out at ${logTime}`;
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Example: Initialize components or add event listeners specific to this page
        console.log('Event logger page initialized.');
    });
</script>
@endsection