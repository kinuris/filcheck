@extends('layouts.admin')

@section('content')
<div class="w-full p-6 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 max-h-screen overflow-auto">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <form class="bg-white p-8 shadow-2xl rounded-lg" action="{{ route('subject.store') }}" method="POST">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Create Subject</h1>
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700">Subject Name</label>
                        <input type="text" name="name" id="name" 
                            class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-900 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                            required>
                        @if ($errors->has('name'))
                        <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="code" class="block text-sm font-semibold text-gray-700">Subject Code</label>
                        <input type="text" name="code" id="code" 
                            class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-900 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                            required>
                        @if ($errors->has('code'))
                        <span class="text-red-500 text-sm">{{ $errors->first('code') }}</span>
                        @endif
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="/curriculum" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        Create Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection