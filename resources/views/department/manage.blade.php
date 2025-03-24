@extends('layouts.admin')

@section('content')
<div class="w-full p-6 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 max-h-screen overflow-auto">
    <h1 class="text-4xl font-bold mb-8 text-white tracking-wide">Department Management</h1>
    <!-- <div class="flex gap-4 mb-6">
        <h1 class="text-2xl font-bold text-white tracking-wide">Manage Departments</h1>
        <div class="flex-1"></div>
        <a href="{{ route('department.create') }}"
            class="bg-white hover:bg-blue-50 transition-colors duration-200 text-blue-800 py-2 px-4 rounded-lg shadow-lg flex items-center gap-2">
            <i class="fas fa-plus-circle mr-2"></i>Add New Department
        </a>
    </div> -->
    <div class="flex gap-4 mb-6">
        <a href="{{ route('department.create') }}" class="bg-white hover:bg-blue-50 transition-colors duration-200 text-blue-800 py-2 px-4 rounded-lg shadow-lg flex items-center gap-2">
            <span class="material-symbols-outlined">add_circle</span>
            <span class="font-semibold">Create Department</span>
        </a>

        <div class="flex-1"></div>
    </div>

    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-sm uppercase">
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold">Department Name</th>
                    <th class="px-6 py-4 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($departments as $department)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4">{{ $department->id }}</td>
                    <td class="px-6 py-4 font-medium text-center">{{ $department->name }}</td>
                    <td class="px-6 py-4 flex justify-center">
                        <div class="flex gap-2">
                            <a href="{{ route('department.edit', $department->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 transition-colors duration-200 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                            <form action="{{ route('department.destroy', $department->id) }}"
                                method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 transition-colors duration-200 text-white px-4 py-2 rounded-lg"
                                    onclick="return confirm('Are you sure you want to delete this department?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection