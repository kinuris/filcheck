@extends('layouts.admin')

@section('content')
<div class="w-full h-screen bg-gray-50">
    <div class="w-full inline-block h-full bg-white shadow-lg">
        <div class="h-16 p-4 border-b">
            <img class="h-full" src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="p-6 mb-16 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 h-[calc(100%-8rem)]">
            <div class="flex w-full mb-6 justify-between items-center">
                <h1 class="text-3xl font-bold text-white">Teachers Directory</h1>
                <a class="transition-all duration-300 hover:scale-105 shadow-lg text-md rounded-lg px-4 py-2 bg-white text-blue-700 hover:bg-blue-50 font-semibold flex items-center gap-2" href="/teacher/create">
                    <span class="material-symbols-outlined">add</span>
                    Add New Teacher
                </a>
            </div>

            <form action="/teacher" class="mb-6">
                <div class="mb-4 relative">
                    <input value="{{ request()->query('search') ?? '' }}" class="w-full rounded-lg shadow-lg bg-white border-0 p-2 pl-10 focus:ring-2 focus:ring-blue-500 transition-all duration-300" placeholder="Search teachers..." type="text" name="search" id="search">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-400">search</span>
                </div>

                <div class="flex w-full gap-4 items-center">
                    <select class="p-2 rounded-lg shadow-lg bg-white text-gray-700 border-0 focus:ring-2 focus:ring-blue-500 transition-all duration-300 w-64" name="dept" id="dept">
                        <option value="-1">All Departments</option>
                        @php $departments = App\Models\Department::all(); @endphp
                        @foreach ($departments as $department)
                        <option {{ request()->query('dept') == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->code }}</option>
                        @endforeach
                    </select>
                    <select class="p-2 rounded-lg shadow-lg bg-white text-gray-700 border-0 focus:ring-2 focus:ring-blue-500 transition-all duration-300 w-64" name="gender" id="gender">
                        <option value="">All Genders</option>
                        <option {{ request()->query('gender') == 'male' ? 'selected' : '' }} value="male">Male</option>
                        <option {{ request()->query('gender') == 'female' ? 'selected' : '' }} value="female">Female</option>
                    </select>
                    @if(request()->query('search') || request()->query('dept') || request()->query('gender'))
                    <a href="/teacher" class="transition-all duration-300 hover:scale-105 shadow-lg text-md rounded-lg px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined">clear</span>
                        Clear Filter
                    </a>
                    @endif
                </div>
            </form>

            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="p-2.5 text-left font-semibold">#</th>
                            <th class="p-2.5 text-left font-semibold">Employee ID</th>
                            <th class="p-2.5 text-left font-semibold">Last Name</th>
                            <th class="p-2.5 text-left font-semibold">First Name</th>
                            <th class="p-2.5 text-left font-semibold">M.I.</th>
                            <th class="p-2.5 text-left font-semibold">Phone #</th>
                            <th class="p-2.5 text-left font-semibold">Department</th>
                            <th class="p-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Group teachers by department code. Eager load 'department' in controller for performance.
                            $groupedTeachers = $teachers->groupBy(function($teacher) {
                                return $teacher->department->code ?? 'No Department'; // Group by department code, handle null department
                            });
                        @endphp

                        @forelse($groupedTeachers as $departmentCode => $teachersInDepartment)
                            {{-- Department Header Row --}}
                            <tr class="bg-gray-100 border-t border-b sticky top-0 z-10"> {{-- Added sticky header for department --}}
                                <td colspan="8" class="p-2.5 font-bold text-gray-800">{{ $departmentCode }}</td>
                            </tr>

                            {{-- Teachers within this department --}}
                            @foreach($teachersInDepartment as $teacher)
                                <tr class="border-t hover:bg-gray-50 transition-colors">
                                    <td class="p-2.5">{{ $teacher->id }}</td>
                                    <td class="p-2.5">{{ $teacher->employee_id }}</td>
                                    <td class="p-2.5">{{ $teacher->last_name }}</td>
                                    <td class="p-2.5">{{ $teacher->first_name }}</td>
                                    <td class="p-2.5">{{ $teacher->middle_name ? $teacher->middle_name[0] . '.' : '' }}</td>
                                    <td class="p-2.5">{{ $teacher->phone_number }}</td>
                                    <td class="p-2.5">{{ $teacher->department->code ?? 'N/A' }}</td> {{-- Show department code per teacher, handle null --}}
                                    <td class="p-2.5">
                                        <div class="flex gap-2 justify-end">
                                            <a class="transition-all duration-300 hover:scale-105 p-2 rounded-lg text-blue-600 hover:bg-blue-50" href="/teacher/edit/{{ $teacher->id }}" title="Edit">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                            {{-- Consider using a form for DELETE requests for better security/semantics --}}
                                            <form action="{{ route('teacher.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="transition-all duration-300 hover:scale-105 p-2 rounded-lg text-red-600 hover:bg-red-50" title="Delete">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr class="border-t">
                                <td colspan="8" class="p-4 text-center text-gray-500">No teachers found matching your criteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Add Pagination Links --}}
            <div class="mt-6">
                {{ $teachers->appends(request()->query())->links() }} {{-- appends() keeps query string parameters --}}
            </div>

        </div>
    </div>
</div>

@endsection {{-- End of main content section --}}

@section('script') {{-- Add scripts in a dedicated section if layout supports it --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="/teacher"]');
        const searchInput = document.getElementById('search');
        const deptSelect = document.getElementById('dept');
        const genderSelect = document.getElementById('gender');

        const submitForm = () => {
            // Use a small timeout to prevent potential race conditions with value updates
            setTimeout(() => form.submit(), 100);
        };

        // Add listeners
        searchInput?.addEventListener('blur', submitForm); // Submit on losing focus from search
        deptSelect?.addEventListener('change', submitForm);
        genderSelect?.addEventListener('change', submitForm);
    });
</script>
@endsection