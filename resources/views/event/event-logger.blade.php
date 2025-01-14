@extends('layouts.plain')

@section('content')
<div class="relative h-screen p-3">
    @include('includes.receiver-notifier')
    <h1>Event Name: {{ $event->name }}</h1>
    <p>{{ $event->address }}</p>

    <p class="text-xs mt-2">Description:</p>
    <p class="leading-none">{{ $event->description }}</p>
    <p class="mt-3 text-xs">Event ID: {{ $event->event_id }}</p>
    <p class="text-xs">From: {{ $event->start }}</p>
    <div class="flex">
        <p class="text-xs">To: {{ $event->end }} </p>
        @if($event->hasEnded())
        <p class="text-xs ml-1 text-red-500">(Ended {{ $event->end->diffForHumans() }})</p>
        @endif
    </div>

    @if ($event->hasEnded())
    <h1 class="text-red-500 font-bold text-xl">Event has ended</h1>
    @endif

    <div class="flex-[2] p-8 flex flex-col justify-evenly place-items-center min-w-[400px]">
        <div class="aspect-square border border-black w-full max-w-96 min-w-80 rounded-2xl shadow-lg shadow-slate-600">
            <img class="object-cover aspect-square rounded-2xl bg-white" src="{{ asset('assets/placeholder.png') }}" id="profile" alt="Student Profile">
        </div>
        <h1 class="text-3xl font-extrabold mt-4 text-center" id="student_id">(NONE)</h1>
    </div>
</div>
@endsection

@section('script')
@include('includes.receiver-script')
@include('includes.event-attendance-script')
<script>
</script>
@endsection