<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleAttendanceRecord extends Model
{
    protected $table = 'schedule_attendance_records';

    protected $fillable = [
        'room_schedule_id',
        'student_info_id',
        'type',
        'day',
        'time',
    ];

    use HasFactory;
}
