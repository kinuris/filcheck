<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\EventAttendanceRecord;
use App\Models\RoomSchedule;
use App\Models\StudentInfo;
use App\Models\SubjectEventAttendance;
use App\Models\SubjectEventAttRecord;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return view('event.manage')->with('events', $events);
    }

    public function delete(Event $event)
    {
        return view('event.delete')->with('event', $event);
    }

    public function edit(Event $event)
    {
        return view('event.edit')->with('event', $event);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'description' => ['required'],
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after:start'],
            'sections' => ['nullable', 'min:0', 'array'],
        ]);

        $event->update($validated);

        if (isset($validated['sections'])) {
            EventAttendance::query()
                ->where('event_id', '=', $event->id)
                ->delete();

            foreach ($validated['sections'] as $section) {
                $students = StudentInfo::query()
                    ->where('section', '=', $section)
                    ->whereDoesntHave('disabledRelation')
                    ->get();

                foreach ($students as $student) {
                    EventAttendance::query()->create([
                        'student_info_id' => $student->id,
                        'event_id' => $event->id,
                    ]);
                }
            }
        }

        return redirect('/event')->with('message', 'Successfully updated ' . '(' . $validated['name'] . ')' . ' event');
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'description' => ['required'],
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after:start'],
            'sections' => ['nullable', 'min:0', 'array'],
        ]);

        $validated['event_id'] = Event::genNoCollisionEventID();
        $event = Event::query()->create($validated);

        if (isset($validated['sections'])) {
            foreach ($validated['sections'] as $section) {
                $students = StudentInfo::query()
                    ->where('section', '=', $section)
                    ->whereDoesntHave('disabledRelation')
                    ->get();

                foreach ($students as $student) {
                    EventAttendance::query()->create([
                        'student_info_id' => $student->id,
                        'event_id' => $event->id,
                    ]);
                }
            }
        }

        return redirect('/event')->with('message', 'Successfully created ' . '(' . $validated['name'] . ')' . ' event');
    }

    public function nodeView()
    {
        return view('event.event-node');
    }

    public function nodeSetup()
    {
        $validated = request()->validate([
            'event_id' => [
                'required',
                // NOTE: Does NOT work
                // Rule::exists('events')
                //     ->where('event_id', 'EVT-' . request()->post('event_id'))
            ],
        ]);

        // TODO: rewrite using validation
        $existing = Event::query()
            ->where('event_id', '=', 'EVT-' . $validated['event_id'])
            ->first();

        if (is_null($existing)) {
            return back()->withErrors([
                'event_id' => 'Event ID does not exist',
            ]);
        }

        return redirect('/event/node/setup?' . 'event_id=' . urlencode($validated['event_id']));
    }

    public function nodeEventLoggerView()
    {
        $eventId = request('event_id');

        if (!$eventId) {
            return redirect('/event/node')->withErrors(['event_id' => 'Event ID does not exist']);
        }

        $event = Event::query()
            ->where('event_id', '=', 'EVT-' . $eventId)
            ->first();

        return view('event.event-logger')->with('event', $event);
    }

    public function nodeEventAttendanceLog(Request $request)
    {
        $rfid = $request->json('rfid');

        $student = StudentInfo::query()
            ->whereDoesntHave('disabledRelation')
            ->where('rfid', '=', $rfid)
            ->first();

        $expected = SubjectEventAttendance::query()->where('event_id', '=', $request->json('event_id'))->where('student_info_id', '=', $student->id)->first();
        if ($expected !== null) {
            $lastRecord = $expected->logs()->latest()->first(); 

            $record = new SubjectEventAttRecord();

            $record->student_info_id = $student->id;
            $record->subject_event_attendance_id = $expected->id;
            $record->type = is_null($lastRecord) ? 'ENTER' : ($lastRecord->type === 'ENTER' ? 'EXIT' : 'ENTER');
            $record->time = date_create();

            $record->save();
        }

        $lastRecord = EventAttendanceRecord::query()
            ->where('student_info_id', '=', $student->id)
            ->where('event_id', '=', $request->json('event_id'))
            ->latest()
            ->first();

        $record = EventAttendanceRecord::query()->create([
            'student_info_id' => $student->id,
            'event_id' => $request->json('event_id'),
            'type' => is_null($lastRecord) ? 'ENTER' : ($lastRecord->type === 'ENTER' ? 'EXIT' : 'ENTER'),
            'time' => date_create(),
        ]);

        return response()->json($record);
    }

    public function teacherView()
    {
        $advisedSections = User::query()->find(Auth::user()->id)->advisedSections;

        $eventMode = request('event', 'ongoing');

        if ($eventMode === 'ongoing') {
            $events = Event::ongoingEvents();
        } elseif ($eventMode === 'future') {
            $events = Event::upcomingEvents();
        } elseif ($eventMode === 'past') {
            $events = Event::pastEvents();
        }

        $events = $events->whereRelation('students', fn($q) => $q->whereIn('section', $advisedSections->pluck('section')))->get();

        return view('event.event-teacher')->with('events', $events);
    }

    public function attendanceClassView(RoomSchedule $schedule, Event $event)
    {
        return view('subject.event-attendance-record')
            ->with('schedule', $schedule)
            ->with('event', $event);
    }

    public function attendanceView(Event $event)
    {
        $advisedSections = User::query()
            ->find(Auth::user()->id)
            ->advisedSections;

        $students = $event->students
            ->whereIn('section', $advisedSections->pluck('section'));

        $timeThreshold = request('time_threshold');
        $dayCount = request('day_count');

        $view = view('event.attendance');

        if (isset($timeThreshold) && isset($dayCount)) {
            $records = $event->attendeesAtDay($dayCount)
                ->where('type', '=', 'ENTER')
                ->where('time', request('late') == 1 ? '>' : (request('ontime') == 1 ? '<=' : throw new Exception('Unreachable')), $timeThreshold)
                ->orderBy('created_at', 'ASC');

            $records = $records->get();
            $latestInRecords = array();
            foreach ($records->groupBy('student_info_id') as $arr) {
                $latestInRecords[] = $arr->sortByDesc('created_at')->first();
            }

            $view = $view->with('records', $latestInRecords);
        }

        return $view
            ->with('event', $event)
            ->with('students', $students);
    }

    public function classEvents(RoomSchedule $schedule)
    {
        $events = $schedule->eventAttendances()
            ->get()
            ->unique('event_id')
            ->map(fn($ea) => $ea->event);

        return view('subject.event-attendance')
            ->with('schedule', $schedule)
            ->with('events', $events);
    }

    public function createClassEvent(Request $request, RoomSchedule $schedule)
    {
        $request->validate([
            'event_id' => ['required', 'exists:events,id'],
        ]);

        $exists = SubjectEventAttendance::query()
            ->where('room_schedule_id', '=', $schedule->id)
            ->where('event_id', '=', $request->post('event_id'))
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'event_id' => 'Event is already assigned to this class'
            ]);
        }

        $students = $schedule->regulars()
            ->filter(fn($s) => !$s->disabled())
            ->merge(
                $schedule->irregulars()
                    ->get()
                    ->map(fn($ir) => $ir->student)
                    ->filter(fn($s) => !$s->disabled())
            );

        foreach ($students as $student) {
            $attendance = new SubjectEventAttendance();

            $attendance->event_id = $request->post('event_id');
            $attendance->room_schedule_id = $schedule->id;
            $attendance->student_info_id = $student->id;

            $attendance->save();
        }

        return redirect()->route('class.events', $schedule);
    }
}
