@extends('layouts.teacher')

@section('content')
<div class="bg-gradient-to-b from-blue-500 to-blue-400 w-full">
    <div class="w-full inline-block bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
    </div>

    <div class="px-8 py-4">
        <h1 class="text-white text-3xl">Events in your handled sections</h1>

        @php($advisedSections = Auth::user()->advisedSections)
        <p class="text-white mt-5">Advised Sections: {{ count($advisedSections) }}</p>

        <div class="flex mt-1 gap-1.5">
            @foreach($advisedSections as $section)
            <p class="text-white bg-slate-700 p-2 rounded-lg">{{ $section->section }}</p>
            @endforeach
        </div>

        <h1 class="text-2xl font-bold text-white stroke-black stroke-1 mt-12">YOUR CLASSES</h1>
        @php($classes = Auth::user()->classes)

        <div class="flex mt-4">
            @foreach ($classes as $class)
            <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                <h2 class="text-xl font-semibold">{{ $class->subject->name }}</h2>
                <p class="text-gray-600 leading-none mt-2">Rm. {{ $class->room->name }}</p>
                <p class="text-gray-600 text-xs">{{ $class->room->building}}</p>
                <p class="text-gray-600 my-2">{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($class->end_time)->format('g:i A') }}</p>
                <a href="{{ route('class.attendance.view', ['sched' => $class->id]) }}" class="text-blue-500 hover:underline">View Class</a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection