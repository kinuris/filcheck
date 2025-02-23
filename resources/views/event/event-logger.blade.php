@extends('layouts.plain')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400">
    <!-- @include('includes.receiver-notifier') -->
    <!-- Header Section -->
    <div class="bg-white/90 backdrop-blur-sm shadow-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
            <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ $event->name }}
        </h1>
        <div class="mt-4 text-gray-600">
            <p class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $event->address }}
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Event Details -->
            <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-gray-100 transition-all duration-300 hover:shadow-blue-100">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-7 h-7 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Event Details
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-base font-semibold text-gray-600 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            Description
                        </h3>
                        <p class="mt-2 text-gray-700 leading-relaxed">{{ $event->description }}</p>
                    </div>
                    <div class="border-t border-gray-100 pt-6">
                        <div class="grid gap-4">
                            <p class="text-sm font-medium flex items-center">
                                <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                                <span class="text-gray-500">Event ID:</span>
                                <span class="text-gray-800 ml-2">{{ $event->event_id }}</span>
                            </p>
                            <p class="text-sm font-medium flex items-center">
                                <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-500">From:</span>
                                <span class="text-gray-800 ml-2">{{ $event->start }}</span>
                            </p>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-500">To:</span>
                                <span class="text-sm font-medium text-gray-800 ml-2">{{ $event->end }}</span>
                                @if($event->hasEnded())
                                <span class="text-sm ml-3 text-red-500 font-medium">(Ended {{ $event->end->diffForHumans() }})</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($event->hasEnded())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mt-4">
                        <p class="text-red-600 font-semibold flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            This event has ended
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Profile Section -->
            <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-gray-100 transition-all duration-300 hover:shadow-blue-100">
                <div class="flex flex-col items-center">
                    <div class="relative w-96 h-96 rounded-2xl overflow-hidden border-4 border-blue-400/50 shadow-2xl transition-transform duration-300 hover:scale-[1.02]">
                        <img class="object-cover w-full h-full" src="{{ asset('assets/placeholder.png') }}" id="profile" alt="Student Profile">
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mt-8 flex items-center text-center space-x-4" id="student_id">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-gray-700">(NONE)</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@include('includes.receiver-script')
@include('includes.event-attendance-script')
<script>
</script>
@endsection