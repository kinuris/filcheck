<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'section' => 'required',
            'subject_name' => 'required',
            'room_name' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'days' => 'required|array',
        ]);

        if ($validator->fails()) {
            session()->flash('openModal', 1);

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $existingSchedules = RoomSchedule::where('room_id', $request->room_id)
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                });
            })
            ->get();

        foreach ($existingSchedules as $schedule) {
            $existingDays = json_decode($schedule->days_recurring, true);
            $newDays = $request->days;

            if (array_intersect($existingDays, $newDays)) {
                session()->flash('openModal', 1);
                session()->flash('conflicting_schedule', $schedule->id);

                return redirect()->back()
                    ->withErrors(['conflict' => 'The schedule conflicts with an existing schedule.'])
                    ->withInput();
            }
        }

        $roomSchedule = new RoomSchedule();
        $roomSchedule->user_id = $request->teacher_id;
        $roomSchedule->room_id = $request->room_id;
        $roomSchedule->subject_id = $request->subject_id;
        $roomSchedule->start_time = $request->start_time;
        $roomSchedule->end_time = $request->end_time;
        $roomSchedule->section = $request->section;
        $roomSchedule->days_recurring = json_encode($request->days);
        
        $roomSchedule->save();

        return redirect('/curriculum')->with('success', 'Room schedule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomSchedule $roomSchedule)
    {
        $roomSchedule->delete();

        return redirect('/curriculum')->with('success', 'Room schedule deleted successfully.');
    }

    public function classNodeSetup(Request $request) {
        $validator = Validator::make($request->all(), [
            'room_name' => 'required|exists:rooms,name',
        ]); 

        if ($validator->fails()) {
            session()->flash('openModal', 1);

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        return redirect()->route('class-node.view', ['room' => $request->room_name]);
    }

    public function classNodeView(string $room) {
        $room = Room::where('name', $room)->first();

        return view('curriculum.class-node')->with('room', $room);
    }
}
