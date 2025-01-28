@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<div class="w-full p-6 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 max-h-screen overflow-auto">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold text-white mb-8 border-b pb-4">Edit Event</h1>

        <form action="/event/{{ $event->id }}/update" method="POST">
            @csrf
            <div class="flex flex-col space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col">
                        <label class="text-white text-sm font-semibold mb-2" for="name">Event Name</label>
                        <input value="{{ $event->name }}" class="border @error('name') border-red-600 @else border-gray-300 @enderror rounded-lg bg-white/90 p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" type="text" name="name" id="name">
                        @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="text-white text-sm font-semibold mb-2" for="address">Event Address</label>
                        <input value="{{ $event->address }}" class="border @error('address') border-red-600 @else border-gray-300 @enderror rounded-lg bg-white/90 p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" type="text" name="address" id="address">
                        @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="text-white text-sm font-semibold mb-2" for="description">Event Description</label>
                    <textarea class="border @error('description') border-red-600 @else border-gray-300 @enderror rounded-lg bg-white/90 p-3 h-32 focus:outline-none focus:ring-2 focus:ring-blue-400" name="description" id="description">{{ $event->description }}</textarea>
                    @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col">
                        <label class="text-white text-sm font-semibold mb-2" for="start">Event Start Date</label>
                        <input value="{{ $event->start }}" class="border @error('start') border-red-600 @else border-gray-300 @enderror rounded-lg bg-white/90 p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" type="datetime-local" name="start" id="start">
                        @error('start')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="text-white text-sm font-semibold mb-2" for="end">Event End Date</label>
                        <input value="{{ $event->end }}" class="border @error('end') border-red-600 @else border-gray-300 @enderror rounded-lg bg-white/90 p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" type="datetime-local" name="end" id="end">
                        @error('end')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <h2 class="text-2xl font-semibold text-white mb-4">
                        <i class="fas fa-layer-group mr-2"></i>Required Sections
                    </h2>
                    @error('sections')
                    <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
                    @enderror
                    <div class="grid grid-cols-4 gap-4">
                        @foreach([
                        1 => ['name' => 'First', 'icon' => 'fa-dice-one'],
                        2 => ['name' => 'Second', 'icon' => 'fa-dice-two'],
                        3 => ['name' => 'Third', 'icon' => 'fa-dice-three'],
                        4 => ['name' => 'Fourth', 'icon' => 'fa-dice-four']
                        ] as $year => $yearData)
                        @php($sections = \App\Models\StudentInfo::getExistingSections($year))
                        <div class="bg-white rounded-xl p-6 shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas {{ $yearData['icon'] }} mr-2 text-blue-500"></i>
                                {{ $yearData['name'] }} Year
                                <span class="text-sm text-gray-500 ml-2">({{ count($sections) }} sections)</span>
                            </h3>
                            <div class="space-y-2">
                                @foreach ($sections as $section)
                                <label class="flex items-center p-2 rounded hover:bg-gray-50 transition-colors cursor-pointer">
                                    <input class="w-4 h-4 mr-3 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        type="checkbox" 
                                        name="sections[]"
                                        value="{{ $section }}"
                                        {{ $event->isSectionRequired($section) ? 'checked' : '' }}>
                                    <span class="text-gray-700">
                                        <i class="fas fa-users mr-2 text-gray-400"></i>
                                        Section {{ $section }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8">
                    <button class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-lg" type="submit">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection