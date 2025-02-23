<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectEventAttendance extends Model
{
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function student()
    {
        return $this->belongsTo(StudentInfo::class, 'student_info_id');
    }

    public function schedule()
    {
        return $this->belongsTo(RoomSchedule::class, 'room_schedule_id');
    }

    public function logs() {
        return $this->hasMany(SubjectEventAttRecord::class, 'subject_event_attendance_id');
    }

    use HasFactory;
}
