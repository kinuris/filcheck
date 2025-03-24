<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RoomSchedule;
use App\Models\SectionAdvisory;
use App\Models\StudentInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function dashboardView()
    {
        $advisories = Auth::user()->advisories;
        $students = new Collection();
        foreach ($advisories as $advisory) {
            $students = $students->merge(StudentInfo::query()
                ->whereDoesntHave('disabledRelation')
                ->where('section', '=', $advisory->section)
                ->get());
        }

        $absent = $students->filter(function ($student) {
            $gateLogs = $student->gateLogs;

            return $gateLogs->where('created_at', '>=', now()->startOfDay())->count() < 1;
        });

        $present = $students->filter(function ($student) {
            $gateLogs = $student->gateLogs;

            return $gateLogs->where('created_at', '>=', now()->startOfDay())->count() > 0;
        });

        $events = new Collection();
        $events = $events->merge(Event::ongoingEvents()->get())
            ->merge(Event::upcomingEvents()->get());

        $classesForToday = RoomSchedule::query()
            ->where('user_id', Auth::id())
            ->where('days_recurring', 'like', '%' . now()->format('D') . '%')
            ->orderBy('start_time')
            ->get();

        return view('teacher.dashboard')
            ->with('advisories', $advisories)
            ->with('events', $events)
            ->with('absent', $absent)
            ->with('present', $present)
            ->with('classesForToday', $classesForToday);
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

        // Filter by department if requested
        if (request('dept') && request('dept') != -1) {
            $teachers = $teachers->where('department_id', request('dept'));
        }

        // Filter by gender if requested
        if (request('gender')) {
            $teachers = $teachers->where('gender', request('gender'));
        }

        $teachers = $teachers->paginate(7);

        return view('teacher.manage')->with('teachers', $teachers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = StudentInfo::query()
            ->whereDoesntHave('disabledRelation')
            ->distinct('section')
            ->pluck('section');

        $existing = SectionAdvisory::query()
            ->distinct('section')
            ->pluck('section');

        $sections = $sections->diff($existing);

        return view('teacher.create')->with('sections', $sections);
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
            'employee_id' => ['required', 'unique:users'],
            'phone_number' => ['required', 'unique:users'],
            'gender' => ['required'],
            'rfid' => ['required', 'unique:users'],
            'birthdate' => ['required', 'date'],
            'username' => ['required', 'unique:users'],
            'password' => ['required'],
            'department' => ['required'],
            'profile' => ['required', 'image', 'mimes:jpg,png,jpeg'],
            'advisories' => ['nullable', 'array'],
        ]);

        if (StudentInfo::query()->whereDoesntHave('disabledRelation')->where('rfid', '=', $request->rfid)->exists()) {
            return redirect()->back()->withErrors(['rfid' => 'RFID already exists'])->withInput();
        }

        $validated['role'] = 'Teacher';
        $validated['department_id'] = $validated['department'];
        $validated['password'] = bcrypt($validated['password']);

        if ($request->hasFile('profile')) {
            $image = $request->file('profile');

            $filename = sha1(time()) . '.' . $image->getClientOriginalExtension();
            $image->storePubliclyAs('public/users/images', $filename);

            $validated['profile_picture'] = $filename;
        }

        $teacher = User::query()->create($validated);
        foreach ($validated['advisories'] ?? [] as $advisory) {
            SectionAdvisory::query()->create([
                'user_id' => $teacher->id,
                'section' => $advisory
            ]);
        }

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
            ->whereDoesntHave('disabledRelation')
            ->distinct('section')
            ->pluck('section');

        $existing = SectionAdvisory::query()
            ->where('user_id', '!=', $teacher->id)
            ->distinct('section')
            ->pluck('section');

        $sections = $sections->diff($existing);

        return view('teacher.update')->with('teacher', $teacher)
            ->with('sections', $sections);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $teacher)
    {
        $validated = $request->validate([
            'rfid' => ['required'],
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'employee_id' => ['required', Rule::unique('users')->ignore($teacher->id)],
            'last_name' => ['required'],
            'phone_number' => ['required', Rule::unique('users')->ignore($teacher->id)],
            'gender' => ['required'],
            'birthdate' => ['required', 'date'],
            'username' => ['required', Rule::unique('users')->ignore($teacher->id)],
            'department' => ['required'],
            'profile' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
            'advisories' => ['nullable', 'array'],
        ]);

        if (StudentInfo::query()->whereDoesntHave('disabledRelation')->where('rfid', '=', $request->rfid)->exists()) {
            return redirect()->back()->withErrors(['rfid' => 'RFID already exists'])->withInput();
        }

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
    public function destroy(User $teacher)
    {
        Storage::delete('public/users/images/' . $teacher->profile_picture);

        $teacher->delete();

        return redirect('/teacher')->with('message', 'Successfully deleted teacher');
    }
}
