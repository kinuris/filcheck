@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 w-full max-h-screen overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Department</h2>

        <form action="{{ route('department.update', $department->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Department Name</label>
                <input type="text" name="name" id="name" value="{{ $department->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Department Code</label>
                <input type="text" name="code" id="code" value="{{ $department->code }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection