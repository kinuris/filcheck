<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectEventAttRecord extends Model
{
    public function eventAttendance()
    {
        return $this->belongsTo(SubjectEventAttendance::class, 'subject_event_attendance_id');
    }

    public function student()
    {
        return $this->belongsTo(StudentInfo::class, 'student_info_id');
    }

    use HasFactory;
}
