@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<div class="p-4 bg-gradient-to-b from-blue-500 to-blue-400 w-full">
    <h1 class="text-3xl font-bold text-white mb-8">Create Event</h1>

    <form action="/event/{{ $event->id }}/update" method="POST">
        @csrf
        <div class="flex flex-col">
            <div class="flex flex-col w-full">
                <div class="flex space-x-4 w-full">
                    <div class="flex flex-col flex-1">
                        <label class="text-white" for="name">Event Name:</label>
                        <input value="{{ $event->name }}" class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" type="text" name="name" id="name">
                    </div>
                    <div class="flex flex-col flex-1">
                        <label class="text-white" for="address">Event Address:</label>
                        <input value="{{ $event->address }}" class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" type="text" name="address" id="address">
                    </div>
                </div>

                <label class="text-white mt-4" for="description">Event Description:</label>
                <textarea class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" name="description" id="description">{{ $event->description }}</textarea>

                <div class="flex space-x-4 w-full mt-4">
                    <div class="flex flex-col flex-1">
                        <label class="text-white" for="start">Event Start Date:</label>
                        <input value="{{ $event->start }}" class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" type="datetime-local" name="start" id="start">
                    </div>

                    <div class="flex flex-col flex-1">
                        <label class="text-white" for="end">Event End Date:</label>
                        <input value="{{ $event->end }}" class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" type="datetime-local" name="end" id="end">
                    </div>
                </div>

                <button class="bg-green-300 px-5 rounded-lg border-black border mt-3 p-2 w-fit" type="submit">Save</button>
            </div>
            <div class="flex">
                @php($sections = \App\Models\StudentInfo::getExistingSections(1))
                <div class="first-year-container border border-gray-300 p-3 rounded-lg m-3 ml-0 flex-1">
                    <h1 class="mb-3 text-white">First Year Sections ({{ count($sections) }})</h1>
                    @foreach ($sections as $section)
                    <div class="border p-2 rounded flex">
                        <input {{ $event->isSectionRequired($section) ? 'checked' : '' }} class="mr-2" type="checkbox" name="sections[]" value="{{ $section }}">
                        <p class="text-white">{{ $section }}</p>
                    </div>
                    @endforeach
                </div>

                @php($sections = \App\Models\StudentInfo::getExistingSections(2))
                <div class="second-year-container border border-gray-300 p-3 rounded-lg m-3 flex-1">
                    <h1 class="mb-3 text-white">Second Year Sections ({{ count($sections) }})</h1>
                    @foreach ($sections as $section)
                    <div class="border p-2 rounded flex">
                        <input {{ $event->isSectionRequired($section) ? 'checked' : '' }} class="mr-2" type="checkbox" name="sections[]" value="{{ $section }}">
                        <p class="text-white">{{ $section }}</p>
                    </div>
                    @endforeach
                </div>

                @php($sections = \App\Models\StudentInfo::getExistingSections(3))
                <div class="second-year-container border border-gray-300 p-3 rounded-lg m-3 flex-1">
                    <h1 class="mb-3 text-white">Third Year Sections ({{ count($sections) }})</h1>
                    @foreach ($sections as $section)
                    <div class="border p-2 rounded flex">
                        <input {{ $event->isSectionRequired($section) ? 'checked' : '' }} class="mr-2" type="checkbox" name="sections[]" value="{{ $section }}">
                        <p class="text-white">{{ $section }}</p>
                    </div>
                    @endforeach
                </div>

                @php($sections = \App\Models\StudentInfo::getExistingSections(4))
                <div class="second-year-container border border-gray-300 p-3 rounded-lg m-3 mr-0 flex-1">
                    <h1 class="mb-3 text-white">Fourth Year Sections ({{ count($sections) }})</h1>
                    @foreach ($sections as $section)
                    <div class="border p-2 rounded flex">
                        <input {{ $event->isSectionRequired($section) ? 'checked' : '' }} class="mr-2" type="checkbox" name="sections[]" value="{{ $section }}">
                        <p class="text-white">{{ $section }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div>
<!-- <form action="/event/{{ $event->id }}/update" method="POST">
        @csrf
        <div class="flex">
            <div class="flex flex-col">
                <label for="name">Event Name:</label>
                <input value="{{ $event->name }}" class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" type="text" name="name" id="name">

                <label for="address">Event Address:</label>
                <input value="{{ $event->address }}" class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" type="text" name="address" id="address">

                <label for="description">Event Description:</label>
                <textarea class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" name="description" id="description">{{ $event->description }}</textarea>

                <label for="start">Event Start Date:</label>
                <input value="{{ $event->start }}" class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" type="datetime-local" name="start" id="start">

                <label for="end">Event End Date:</label>
                <input value="{{ $event->end }}" class="border-black shadow-lg border rounded-lg bg-blue-100 p-2" type="datetime-local" name="end" id="end">

                <button class="bg-green-300 px-5 rounded-lg border-black border mt-3" type="submit">Save</button>
            </div>
            <div class="flex flex-col">
                @php($sections = \App\Models\StudentInfo::getExistingSections(1))
                <div class="first-year-container border border-gray-300 p-3 rounded-lg m-3">
                    <h1 class="mb-3">First Year Sections ({{ count($sections) }})</h1>
                    @foreach ($sections as $section)
                    <div class="border p-2 rounded flex">
                        <input {{ $event->isSectionRequired($section) ? 'checked' : '' }} class="mr-2" type="checkbox" name="sections[]" value="{{ $section }}">
                        <p>{{ $section }}</p>
                    </div>
                    @endforeach
                </div>

                @php($sections = \App\Models\StudentInfo::getExistingSections(2))
                <div class="second-year-container border border-gray-300 p-3 rounded-lg m-3">
                    <h1 class="mb-3">Second Year Sections ({{ count($sections) }})</h1>
                    @foreach ($sections as $section)
                    <div class="border p-2 rounded flex">
                        <input {{ $event->isSectionRequired($section) ? 'checked' : '' }} class="mr-2" type="checkbox" name="sections[]" value="{{ $section }}">
                        <p>{{ $section }}</p>
                    </div>
                    @endforeach
                </div>

                @php($sections = \App\Models\StudentInfo::getExistingSections(3))
                <div class="second-year-container border border-gray-300 p-3 rounded-lg m-3">
                    <h1 class="mb-3">Third Year Sections ({{ count($sections) }})</h1>
                    @foreach ($sections as $section)
                    <div class="border p-2 rounded flex">
                        <input {{ $event->isSectionRequired($section) ? 'checked' : '' }} class="mr-2" type="checkbox" name="sections[]" value="{{ $section }}">
                        <p>{{ $section }}</p>
                    </div>
                    @endforeach
                </div>

                @php($sections = \App\Models\StudentInfo::getExistingSections(4))
                <div class="second-year-container border border-gray-300 p-3 rounded-lg m-3">
                    <h1 class="mb-3">Fourth Year Sections ({{ count($sections) }})</h1>
                    @foreach ($sections as $section)
                    <div class="border p-2 rounded flex">
                        <input {{ $event->isSectionRequired($section) ? 'checked' : '' }} class="mr-2" type="checkbox" name="sections[]" value="{{ $section }}">
                        <p>{{ $section }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div> -->
@endsection