<?php

namespace App\Http\Controllers;

use App\Models\ActiveSms;
use App\Models\GateLog;
use App\Models\StudentInfo;
use App\Models\User;
use App\Helpers\Message;
use App\Models\EmployeeLog;
use App\Models\StudentDisabled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function get(string $rfid)
    {
        $student = StudentInfo::query()
            ->whereDoesntHave('disabledRelation')
            ->where('rfid', '=', $rfid)
            ->first();

        $teacher = User::query()
            ->where('rfid', '=', $rfid)
            ->first();

        if (!$student && !$teacher) {
            return response('Not found', 404);
        }

        if ($student && $teacher) {
            return response('Multiple found', 404);
        }

        if ($student) {
            $data = $student->toArray();
            $data = array_merge($data, [
                'department' => $student->department,
                'year_sec' => 'Year Level ' . $student->year . ' & Section ' . $student->section,
                'image' => $student->image(),
            ]);

            return response()->json(['student' => $data]);
        }

        if ($teacher) {
            $data = $teacher->toArray();
            $data = array_merge($data, [
                'department' => $teacher->department,
                'image' => $teacher->image(),
                'year_sec' => 'TEACHER',
                'student_number' => 'TEACHER',
            ]);

            return response()->json(['student' => $data]);
        }
    }

    public function log(string $rfid)
    {
        $student = StudentInfo::query()
            ->whereDoesntHave('disabledRelation')
            ->where('rfid', '=', $rfid)
            ->first();

        $teacher = User::query()
            ->where('role', '=', 'Teacher')
            ->where('rfid', '=', $rfid)
            ->first();

        if (!$student && !$teacher) {
            return response('Not found', 404);
        }

        if ($student) {
            $log = $student->gateLogs()
                ->latest()
                ->first();

            if ($log && !$log->isSameDay(date_create('now'))) {
                $state = 'IN';
            } else if ($log && $log->isSameDay(date_create('now'))) {
                $log->type === 'IN' ? $state = 'OUT' : $state = 'IN';
            } else if (is_null($log)) {
                $state = 'IN';
            }

            GateLog::query()->create([
                'student_info_id' => $student->id,
                'type' => $state,
                'day' => date_create('now')->format('Y-m-d'),
                'time' => date_create('now')->format('H:i:s'),
            ]);

            return response()->json(['state' => $state]);
        }

        if ($teacher) {
            $log = $teacher->gateLogs()
                ->latest()
                ->first();

            if ($log && !$log->isSameDay(date_create('now'))) {
                $state = 'IN';
            } else if ($log && $log->isSameDay(date_create('now'))) {
                $log->type === 'IN' ? $state = 'OUT' : $state = 'IN';
            } else if (is_null($log)) {
                $state = 'IN';
            }

            EmployeeLog::query()->create([
                'type' => $state,
                'day' => date_create('now')->format('Y-m-d'),
                'time' => date_create('now')->format('H:i:s'),
                'user_id' => $teacher->id,
            ]);

            return response()->json(['state' => $state]);
        }
    }

    public function studentView()
    {
        return view('student.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = StudentInfo::query();
        $advisedSections = User::query()->find(Auth::user()->id)->advisedSections;

        $students = $students->whereIn('section', $advisedSections->pluck('section'));
        $courses = StudentInfo::query()
            ->get()
            ->map(fn($student) => $student->getCodeAndSection())
            ->map(fn($section) => $section[0])
            ->unique();

        if (Auth::user()->role === 'Admin') {
            $students = StudentInfo::query();
        }

        // Apply year filter if present
        if (request('year')) {
            $students = $students->where('year', '=', request('year'));
        }

        // Apply gender filter if present
        if (request('gender')) {
            $students = $students->where('gender', '=', request('gender'));
        }

        // Apply course filter if present
        if (request('course')) {
            $course = request('course');
            $students = $students->where(function ($query) use ($course) {
                $query->whereRaw("section LIKE ?", ["%$course%"]);
            });
        }

        $search = request('search');
        if ($search) {
            $students = $students->where('rfid', 'like', '%' . $search . '%')
                ->orWhere('student_number', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%');
        }

        if (request('show_disabled', 0) != 1) {
            $students = $students->whereDoesntHave('disabledRelation');
        }

        $students = $students->paginate(7);

        return view('student.manage')
            ->with('students', $students)
            ->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rfid' => ['required'],
            'student_number' => ['required', 'unique:student_infos'],
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'department' => ['required'],
            'gender' => ['required'],
            'birthdate' => ['required', 'date'],
            'phone_number' => ['required'],
            'guardian' => ['required'],
            'address' => ['required'],
            'profile' => ['required', 'image', 'mimes:jpeg,png,jpg'],
            'year' => ['required'],
            'section_letter' => ['required'],
            'section' => ['required'],
        ]);

        // TODO: add year and section
        if (User::query()->where('rfid', '=', $request->rfid)->exists()) {
            return redirect()->back()->withErrors(['rfid' => 'RFID already used by an employee'])->withInput();
        }

        if (StudentInfo::query()->whereDoesntHave('disabledRelation')->where('rfid', '=', $request->rfid)->exists()) {
            return redirect()->back()->withErrors(['rfid' => 'RFID already exists'])->withInput();
        }

        $image = $request->file('profile');
        $filename = sha1(time()) . '.' . $image->extension();

        $image->storePubliclyAs('public/student/images', $filename);

        $validated['profile_picture'] = $filename;
        $validated['department_id'] = $validated['department'];
        $validated['section'] = $validated['section'] . '-' . $validated['year'] . $validated['section_letter'];
        $validated['year'] = (int) $validated['year'][0];

        $student = StudentInfo::query()->create($validated);

        if ($request->has('sms_activated')) {
            ActiveSms::query()
                ->create([
                    'student_info_id' => $student->id,
                ]);
        }

        return redirect('/student')->with('message', 'Student created successfully');
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
    public function edit(StudentInfo $student)
    {
        return view('student.update')
            ->with('student', $student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentInfo $student)
    {
        $validated = $request->validate([
            'rfid' => ['required'],
            'student_number' => ['required', Rule::unique('student_infos')->ignore($student->id)],
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'department' => ['required'],
            'gender' => ['required'],
            'birthdate' => ['required', 'date'],
            'phone_number' => ['required'],
            'guardian' => ['required'],
            'address' => ['required'],
            'profile' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'year' => ['required'],
            'section_letter' => ['required'],
            'section' => ['required'],
        ]);

        if (User::query()->where('rfid', '=', $request->rfid)->exists()) {
            return redirect()->back()->withErrors(['rfid' => 'RFID already used by an employee'])->withInput();
        }

        if (StudentInfo::query()->whereDoesntHave('disabledRelation')->where('id', '!=', $student->id)->where('rfid', '=', $request->rfid)->exists()) {
            return redirect()->back()->withErrors(['rfid' => 'RFID already exists'])->withInput();
        }

        $validated['department_id'] = $validated['department'];
        $validated['section'] = $validated['section'] . '-' . $validated['year'] . $validated['section_letter'];
        $validated['year'] = (int) $validated['year'][0];

        if ($request->has('sms_activated')) {
            ActiveSms::query()
                ->create([
                    'student_info_id' => $student->id,
                ]);
        } else {
            ActiveSms::query()
                ->where('student_info_id', '=', $student->id)
                ->delete();
        }

        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $filename = sha1(time()) . '.' . $image->extension();

            Storage::delete('public/student/images/' . $student->profile_picture);

            $image->storePubliclyAs('public/student/images', $filename);
            $validated['profile_picture'] = $filename;
        }

        $student->update($validated);

        return redirect('/student')->with('message', 'Student updated successfully');
    }

    public function smsNotifyGuardian(StudentInfo $student)
    {
        $latest = $student->latestLog;

        if ($latest === null) {
            return abort(404);
        }

        if (!$student->activatedSms()) {
            return response('Not Activated SMS', 200);
        }

        $msg = Message::filcheck();

        if ($latest->type === 'OUT') {
            $msg->setMessage('FILCHECK: Hey there ' . $student->guardian . ', ' . $student->full_name . ' has LEFT⬅️ the school this ' . date_create($latest->day)->format('jS \o\f F, Y,') . ' ' . date_create($latest->time)->format('g:i A') . '.');
        } else {
            $msg->setMessage('FILCHECK: Hey there ' . $student->guardian . ', ' . $student->full_name . ' has ENTERED✅ the school this ' . date_create($latest->day)->format('jS \o\f F, Y,') . ' ' . date_create($latest->time)->format('g:i A') . '.');
        }

        $msg->setFullPhoneNumber($student->fullPhoneNumber());
        $msg->send();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentInfo $student)
    {
        Storage::delete('public/student/images/' . $student->profile_picture);
        $student->delete();

        return redirect('/student')->with('message', 'Student deleted successfully');
    }

    public function decomission(StudentInfo $student)
    {
        $disabled = new StudentDisabled();
        $disabled->student_info_id = $student->id;

        $disabled->save();

        return redirect()->route('student.index')->with('message', 'Student decomissioned successfully');
    }
}
