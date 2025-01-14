<?php

namespace App\Http\Controllers;

use App\Models\SectionAdvisory;
use App\Models\StudentInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function dashboardView()
    {
        return view('teacher.dashboard');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = User::teachers();

        $search = request('search');
        if ($search) {
            $teachers = $teachers->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%');
        }

        $teachers = $teachers->paginate(7);

        return view('teacher.manage')->with('teachers', $teachers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'phone_number' => ['required', 'unique:users'],
            'gender' => ['required'],
            'rfid' => ['required', 'unique:users'],
            'birthdate' => ['required', 'date'],
            'username' => ['required', 'unique:users'],
            'password' => ['required'],
            'department' => ['required'],
            'profile' => ['required', 'image', 'mimes:jpg,png,jpeg']
        ]);

        $validated['role'] = 'Teacher';
        $validated['department_id'] = $validated['department'];
        $validated['password'] = bcrypt($validated['password']);

        if ($request->hasFile('profile')) {
            $image = $request->file('profile');

            $filename = sha1(time()) . '.' . $image->getClientOriginalExtension();
            $image->storePubliclyAs('public/users/images', $filename);

            $validated['profile_picture'] = $filename;
        }

        User::query()->create($validated);

        return redirect('/teacher')->with('message', 'Successfully created teacher');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $teacher)
    {
        $sections = StudentInfo::query()
            ->distinct('section')
            ->pluck('section');

        return view('teacher.update')->with('teacher', $teacher)
            ->with('sections', $sections);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $teacher)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'phone_number' => ['required', Rule::unique('users')->ignore($teacher->id)],
            'gender' => ['required'],
            'birthdate' => ['required', 'date'],
            'username' => ['required', Rule::unique('users')->ignore($teacher->id)],
            'department' => ['required'],
            'profile' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
            'advisories' => ['nullable', 'array'],
        ]);

        SectionAdvisory::query()->where('user_id', $teacher->id)->delete();
        foreach ($validated['advisories'] ?? [] as $advisory) {
            SectionAdvisory::query()->create([
                'user_id' => $teacher->id,
                'section' => $advisory
            ]);
        }

        $validated['department_id'] = $validated['department'];
        if ($request->hasFile('profile')) {
            Storage::delete('public/users/images/' . $teacher->profile_picture);

            $image = $request->file('profile');

            $filename = sha1(time()) . '.' . $image->getClientOriginalExtension();
            $image->storePubliclyAs('public/users/images', $filename);

            $validated['profile_picture'] = $filename;
        }

        $teacher->update($validated);

        return redirect('/teacher')->with('message', 'Successfully updated teacher');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
