@extends('layouts.admin')

@section('content')
<div class="max-h-screen overflow-auto bg-gradient-to-r from-blue-600 to-blue-400">
    <!-- Calendar Section -->
    <div class="bg-white/80 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-blue-600">Philippine Holidays {{ now()->year }}</h2>
            <div class="text-sm text-gray-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Official Calendar</span>
            </div>
        </div>
        <div id="calendar-container" class="relative">
            <div id="calendar-loading" class="absolute inset-0 flex items-center justify-center bg-white/50 z-10 rounded-lg hidden">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
            </div>
            <div id="calendar" class="calendar-professional"></div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <style>
        .calendar-professional .fc-button-primary {
            background-color: #2563eb;
            border-color: #1d4ed8;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 0.375rem;
        }

        .calendar-professional .fc-button-primary:hover {
            background-color: #1d4ed8;
            border-color: #1e40af;
        }

        .calendar-professional .fc-button-primary:not(:disabled).fc-button-active,
        .calendar-professional .fc-button-primary:not(:disabled):active {
            background-color: #1e40af;
            border-color: #1e3a8a;
        }

        .calendar-professional .fc-col-header-cell {
            background-color: rgba(59, 130, 246, 0.1);
            font-weight: 600;
        }

        .calendar-professional .fc-daygrid-day.fc-day-today {
            background-color: rgba(59, 130, 246, 0.15);
        }

        .calendar-professional .fc-event {
            border-radius: 0.375rem;
            font-size: 0.8rem;
            border: none;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .calendar-professional .fc-daygrid-day:hover {
            background-color: rgba(59, 130, 246, 0.05);
            cursor: pointer;
            transition: background-color 0.2s ease;
            box-shadow: inset 0 0 0 1px rgba(59, 130, 246, 0.1);
        }

        .calendar-professional .fc-event:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .calendar-professional .fc-toolbar-title {
            font-size: 1.5rem;
            color: #2563eb;
            font-weight: 600;
        }

        .calendar-professional .fc-header-toolbar {
            margin-bottom: 1rem !important;
        }

        .calendar-professional .fc-theme-standard td,
        .calendar-professional .fc-theme-standard th {
            border-color: #e5e7eb;
        }

        .calendar-professional .fc-scrollgrid {
            border-radius: 0.5rem;
            overflow: hidden;
            border-color: #e5e7eb;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var loadingEl = document.getElementById('calendar-loading');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                dateClick: function(info) {
                    // Check if clicked date is today or in the future
                    var clickedDate = new Date(info.dateStr);
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (clickedDate >= today) {
                        // Create modal if it doesn't exist
                        let modal = document.getElementById('holiday-modal');
                        if (!modal) {
                            modal = document.createElement('div');
                            modal.id = 'holiday-modal';
                            modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50';
                            let deleteButton = '';
                            let existingHoliday = calendar.getEvents().find(event => event.startStr === info.dateStr  && event.extendedProps.source === 'PHP');
                            if (existingHoliday) {
                                deleteButton = `
                                    <button id="delete-holiday" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                        Delete
                                    </button>
                                `;
                            }
                            modal.innerHTML = `
                                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4 transform transition-transform">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-xl font-semibold text-blue-600">Declare Holiday</h3>
                                        <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-gray-600 mb-4">Would you like to declare <span id="selected-date" class="font-semibold"></span> as a holiday?</p>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="holiday-name">
                                            Holiday Name
                                        </label>
                                        <input id="holiday-name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter holiday name">
                                    </div>
                                    <div class="flex justify-end space-x-3">
                                        <button id="cancel-holiday" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                                            Cancel
                                        </button>
                                        ${deleteButton}
                                        <button id="confirm-holiday" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors" ${existingHoliday ? 'style="display:none;"' : ''}>
                                            Confirm
                                        </button>
                                    </div>
                                </div>
                            `;

                            document.body.appendChild(modal);

                            // Add event listeners
                            document.getElementById('close-modal').addEventListener('click', function() {
                                modal.remove();
                            });

                            document.getElementById('cancel-holiday').addEventListener('click', function() {
                                modal.remove();
                            });

                            document.getElementById('confirm-holiday').addEventListener('click', function() {
                                const holidayName = document.getElementById('holiday-name').value;

                                if (holidayName.trim() === '') {
                                    alert('Please enter a holiday name');
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('name', holidayName);
                                formData.append('date', info.dateStr);

                                fetch('/holidays/store', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        // Handle success
                                        console.log('Holiday saved:', data);
                                        location.reload();
                                    })
                                    .catch(error => {
                                        console.error('Error saving holiday:', error);
                                        alert('Failed to save holiday.');
                                    });

                                modal.remove();
                            });

                            if (document.getElementById('delete-holiday')) {
                                document.getElementById('delete-holiday').addEventListener('click', function() {
                                    fetch('/holidays/' + existingHoliday.id, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                        })
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Network response was not ok');
                                            }
                                            return response.json();
                                        })
                                        .then(data => {
                                            // Handle success
                                            console.log('Holiday deleted:', data);
                                            location.reload();
                                        })
                                        .catch(error => {
                                            console.error('Error deleting holiday:', error);
                                            alert('Failed to delete holiday.');
                                        });

                                    modal.remove();
                                });
                            }
                        }

                        // Update the selected date in the modal
                        document.getElementById('selected-date').textContent = info.dateStr;

                        // Set default holiday name if it exists
                        let existingHoliday = calendar.getEvents().find(event => event.startStr === info.dateStr);
                        if (existingHoliday) {
                            document.getElementById('holiday-name').value = existingHoliday.title;
                        }
                    }

                },
                eventContent: function(arg) {
                    let eventContent = arg.event.title;
                    return {
                        html: eventContent
                    };
                },
                height: 'auto',
                themeSystem: 'standard',
                fixedWeekCount: false,
                dayMaxEvents: true,
                events: function(info, successCallback, failureCallback) {
                    // Show loading indicator
                    loadingEl.classList.remove('hidden');
                    <?php

                    use App\Models\Holiday;

                    $holidays = Holiday::all();
                    $holidayEvents = $holidays->map(function ($holiday) {
                        return [
                            'id' => $holiday->id,
                            'title' => $holiday->name,
                            'start' => $holiday->date,
                            'allDay' => true,
                            'backgroundColor' => '#eab308',
                            'borderColor' => '#eab308',
                            'textColor' => 'white',
                            'extendedProps' => [
                                'description' => $holiday->name,
                                'type' => 'Declared Holiday',
                                'source' => 'PHP'
                            ]
                        ];
                    });

                    $existingEvents = $holidayEvents->toArray();
                    ?>

                    // Fetch holidays from API
                    fetch('https://calendarific.com/api/v2/holidays?api_key=fbC8fOBy90gl8zJxwLxp4sNyHX497I55&country=PH&year={{ now()->year }}')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.response && data.response.holidays) {
                                var holidays = data.response.holidays.map(holiday => ({
                                    title: holiday.name,
                                    start: holiday.date.iso,
                                    allDay: true,
                                    backgroundColor: getHolidayColor(holiday.type),
                                    borderColor: getHolidayColor(holiday.type),
                                    textColor: 'white',
                                    extendedProps: {
                                        description: holiday.description,
                                        type: holiday.type.join(', ')
                                    }
                                }));
                                // Append PHP holidays to the holidays array
                                var allHolidays = holidays.concat(<?php echo json_encode($existingEvents); ?>);
                                successCallback(allHolidays);
                            } else {
                                failureCallback('No holiday data available');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching holidays:', error);
                            failureCallback(error);
                        })
                        .finally(() => {
                            // Hide loading indicator
                            loadingEl.classList.add('hidden');
                        });
                },
                eventDidMount: function(info) {
                    // Add tooltips to events
                    if (info.event.extendedProps.description) {
                        info.el.title = info.event.extendedProps.description;
                    }
                },
                loading: function(isLoading) {
                    if (isLoading) {
                        loadingEl.classList.remove('hidden');
                    } else {
                        loadingEl.classList.add('hidden');
                    }
                }
            });

            calendar.render();

            // Function to determine holiday color based on type
            function getHolidayColor(types) {
                if (!types || !types.length) return '#3b82f6'; // Default blue

                if (types.includes('National holiday')) return '#ef4444'; // Red for national
                if (types.includes('Local holiday')) return '#f59e0b'; // Amber for local
                if (types.includes('Religious')) return '#8b5cf6'; // Purple for religious
                if (types.includes('Observance')) return '#10b981'; // Green for observance

                return '#3b82f6'; // Default blue
            }
        });
    </script>

    <!-- Main Content -->
    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6">
        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Departments</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $departments->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Students</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $departments->sum(function($dep) { return count($dep->students); }) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Teachers</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $departments->sum(function($dep) { return count($dep->teachers); }) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments Section -->
        <div class="bg-white/80 rounded-lg shadow mb-8">
            <div class="px-6 pb-0 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-blue-600">Department Overview</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($departments as $department)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all">
                        <div class="p-5 flex flex-col h-full">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $department->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Department Code: {{ $department->code }}</p>
                                </div>
                            </div>

                            <div class="flex-1"></div>

                            <div class="mt-5 pt-4 border-t border-gray-100">
                                <div class="flex justify-between">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-blue-50 rounded-lg mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-2.727 1.17 1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Students</p>
                                            <p class="font-semibold">{{ count($department->students) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="p-2 bg-green-50 rounded-lg mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Teachers</p>
                                            <p class="font-semibold">{{ count($department->teachers) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @php($clockedIn = $department->teachers()->get()->filter(fn($teacher) => $teacher->gateLogs->where('created_at', '>=', now()->startOfDay())->count() > 0)->count())
                            <div class="pt-3 border-gray-100">
                                <div class="flex items-center">
                                    <div class="p-2 bg-purple-50 rounded-lg mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Teachers Clocked In</p>
                                        <div class="flex items-center gap-2">
                                            <p class="font-semibold">{{ $clockedIn }}</p>
                                            @if(count($department->teachers) > 0)
                                            <span class="text-xs px-1.5 py-0.5 rounded {{ ($clockedIn / count($department->teachers) * 100) > 50 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ round($clockedIn / count($department->teachers) * 100) }}% today
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Events Section -->
        <div class="bg-white/80 rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">Upcoming & Ongoing Events</h2>
            <div class="overflow-x-auto">
                <div class="flex space-x-4 pb-3 overflow-x-scroll">
                    @forelse($events ?? [] as $event)
                    <div class="flex-shrink-0 w-80 bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-lg p-5 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $event->name }}</h3>
                            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">Event</span>
                        </div>
                        <div class="flex space-x-3 mb-3">
                            <div class="bg-white rounded-md border border-gray-200 px-3 py-2 text-center w-1/2 shadow-sm">
                                <span class="block text-xs uppercase tracking-wide text-gray-500 font-medium">Start</span>
                                <span class="font-semibold text-sm text-gray-800">{{ date('M d, Y', strtotime($event->start)) }}</span>
                                <span class="block text-xs text-blue-600 mt-1">{{ $event->time }}</span>
                            </div>
                            <div class="bg-white rounded-md border border-gray-200 px-3 py-2 text-center w-1/2 shadow-sm">
                                <span class="block text-xs uppercase tracking-wide text-gray-500 font-medium">End</span>
                                <span class="font-semibold text-sm text-gray-800">{{ date('M d, Y', strtotime($event->end)) }}</span>
                                <span class="block text-xs text-blue-600 mt-1">{{ $event->time }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-xs text-gray-600">{{ $event->address }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="w-full text-center py-4 text-gray-500">
                        No upcoming events
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Logs Section -->
        <div class="bg-white/80 rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">Latest Faculty Logs (24hrs)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                    <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Department</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">{{ $log->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $log->type == 'OUT' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-green-100 text-green-800 border border-green-200' }}">
                                    {{ ucfirst($log->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $log->user->getFullname() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                @if($log->user->department->name ?? false)
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-blue-400 mr-2"></div>
                                    {{ $log->user->department->name }}
                                </div>
                                @else
                                <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 bg-gray-50">
                                <svg class="mx-auto h-6 w-6 text-gray-400 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                No logs available at this time
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection