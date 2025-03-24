@extends('layouts.admin')

@section('title', 'Create Event')

@section('content')
<div class="w-full p-8 bg-gradient-to-r from-blue-700 to-blue-900 max-h-screen overflow-auto">
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-2xl p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-calendar-plus mr-3 text-blue-600"></i>Create Event
        </h1>

        <form action="/event/store" method="POST">
            @csrf
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col">
                        <label class="text-gray-700 font-medium mb-2" for="name">Event Name</label>
                        <input value="{{ old('name') }}" class="border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="name" id="name">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-700 font-medium mb-2" for="address">Event Address</label>
                        <input value="{{ old('address') }}" class="border @error('address') border-red-500 @else border-gray-300 @enderror rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="address" id="address">
                        @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-700 font-medium mb-2" for="description">Event Description</label>
                    <textarea class="border @error('description') border-red-500 @else border-gray-300 @enderror rounded-lg p-3 h-32 focus:outline-none focus:ring-2 focus:ring-blue-500" name="description" id="description">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col">
                        <label class="text-gray-700 font-medium mb-2" for="start">Event Start Date</label>
                        <input value="{{ old('start') }}" class="border @error('start') border-red-500 @else border-gray-300 @enderror rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" type="datetime-local" name="start" id="start">
                        @error('start')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-700 font-medium mb-2" for="end">Event End Date</label>
                        <input value="{{ old('end') }}" class="border @error('end') border-red-500 @else border-gray-300 @enderror rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" type="datetime-local" name="end" id="end">
                        @error('end')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-layer-group mr-2 text-blue-600"></i>Required Sections
                    </h2>
                    @error('sections')
                    <p class="text-red-500 text-sm mb-3 bg-red-50 p-2 rounded">{{ $message }}</p>
                    @enderror
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach([
                        1 => ['name' => 'First', 'icon' => 'fa-dice-one'],
                        2 => ['name' => 'Second', 'icon' => 'fa-dice-two'],
                        3 => ['name' => 'Third', 'icon' => 'fa-dice-three'],
                        4 => ['name' => 'Fourth', 'icon' => 'fa-dice-four']
                        ] as $year => $yearData)
                        @php($sections = \App\Models\StudentInfo::getExistingSections($year))
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas {{ $yearData['icon'] }} mr-2 text-blue-600"></i>
                                {{ $yearData['name'] }} Year
                                <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded-full">{{ count($sections) }}</span>
                            </h3>
                            <div class="space-y-1.5">
                                @foreach ($sections as $section)
                                <label class="flex items-center p-2 rounded hover:bg-white transition-colors cursor-pointer">
                                    <input class="w-4 h-4 mr-3 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        type="checkbox"
                                        name="sections[]"
                                        value="{{ $section }}">
                                    <span class="text-gray-700">
                                        <i class="fas fa-users mr-2 text-gray-500"></i>
                                        Section {{ $section }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ url()->previous() }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-medium flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Cancel
                    </a>
                    <button class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm flex items-center" type="submit">
                        <i class="fas fa-plus mr-2"></i> Create Event
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection