<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendanceRecord extends Model
{
    protected $table = 'event_attendance_records';
    protected $fillable = [
        'student_info_id',
        'event_id',
        'type',
        'time',
    ];

    public function studentInfo() {
        return $this->belongsTo(StudentInfo::class, 'student_info_id');
    }

    use HasFactory;
}
