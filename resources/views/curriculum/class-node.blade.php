@extends('layouts.plain')

@section('content')
<div class="w-screen h-screen relative">
    <div class="absolute w-full h-full">
        <img class="object-cover h-full w-full absolute blur-[3px]" src="{{ asset('assets/bg.png') }}" alt="Background" >
        <div class="h-full w-full bg-gray-800/70 absolute z-10"></div>
    </div>

    <div class="absolute top-4 left-4 z-50 flex items-center space-x-4">
        <a href="/" class="text-white bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded">
            Back
        </a>

        @php($subject = $room->scheduleAt(date_create('now')->format('H:i')))
        <div class="text-white bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded">
            Current Subject: <span id="current-subject">{{ is_null($subject) ? '(None)' : $subject->subject->name }}</span>
        </div>

        <div class="text-white bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded">
            Section: <span id="current-subject">{{ is_null($subject) ? '(None)' : $subject->section }}</span>
        </div>

        <a href="javascript:location.reload()" class="text-white rounded p-1.5 hover:rotate-12 transition-transform duration-300">
            <span class="material-symbols-outlined me-3">
                refresh
            </span>
        </a>
    </div>

    <div class="absolute inset-0 flex flex-col items-center justify-center z-20">
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-64 aspect-square">
            <img class="w-full object-cover h-full" src="{{ asset('assets/placeholder.png') }}" alt="Placeholder Image" id="profile">
        </div>

        <div class="mt-4 text-center">
            <label for="name" class="block text-sm font-medium text-white">Name</label>
            <input type="text" name="name" id="name" class="mt-1 min-w-96 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
        </div>

        <div class="mt-4 flex justify-center space-x-6">
            <div class="text-center">
                <label for="section" class="block text-sm font-medium text-white">Section</label>
                <input type="text" name="section" id="section" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="text-center">
                <label for="year_level" class="block text-sm font-medium text-white">Year Level</label>
                <input type="text" name="year_level" id="year_level" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>
        </div>

        <div class="mt-4 flex justify-center space-x-6">
            <div class="text-center">
                <label for="date" class="block text-sm font-medium text-white">Date</label>
                <input type="text" name="date" id="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="text-center">
                <label for="time" class="block text-sm font-medium text-white">Time</label>
                <input type="text" name="time" id="time" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>
        </div>
        <p class="p-2 absolute left-10 max-w-64 text-center" id="message"></p>
    </div>
</div>
@include('includes.receiver-notifier')
@endsection

@section('script')
@include('includes.receiver-script')
<script>
    const stream = new EventSource('http://localhost:8081/stream/current?stream=current');

    stream.addEventListener('message', async function(e) {
        const response = await fetch('/attendance/record/' + e.data + '/' + "{{ $room->scheduleAt(date_create('now')->format('H:i'))->id ?? '-1' }}");
        document.getElementById('message').textContent = '';
        document.getElementById('message').classList.remove('text-red-500', 'bg-red-100', 'border', 'border-red-400', 'text-green-500', 'bg-green-100', 'border-green-400', 'px-4', 'py-2', 'rounded', 'shadow-md');

        if (!response.ok) {
            document.getElementById('message').textContent = 'Error recording attendance';
            document.getElementById('message').classList.add('text-red-500', 'bg-red-100', 'border', 'border-red-400', 'px-4', 'py-2', 'rounded', 'shadow-md');

            return;
        }

        const data = await response.json();
        if (data.status === 'ssnf') {
            document.getElementById('message').textContent = data.message;
            document.getElementById('message').classList.add('text-red-500', 'bg-red-100', 'border', 'border-red-400', 'px-4', 'py-2', 'rounded', 'shadow-md');

            document.getElementById('name').value = '';
            document.getElementById('section').value = '';
            document.getElementById('year_level').value = '';
            document.getElementById('date').value = '';
            document.getElementById('time').value = '';
            document.getElementById('profile').src = "{{ asset('assets/placeholder.png') }}";

            return;
        }

        if (data.status === 'success') {
            const student = JSON.parse(data.student);

            document.getElementById('name').value = student.fullname;
            document.getElementById('section').value = student.section;
            document.getElementById('year_level').value = student.year;
            document.getElementById('date').value = student.date;
            document.getElementById('time').value = student.time;
            document.getElementById('profile').src = student.profile;

            document.getElementById('message').textContent = data.message;
            document.getElementById('message').classList.add('text-green-500', 'bg-green-100', 'border', 'border-green-400', 'px-4', 'py-2', 'rounded', 'shadow-md');
        }
    });
</script>
@endsection