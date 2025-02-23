<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrregularRoomSchedule extends Model
{
    public function roomSchedule()
    {
        return $this->belongsTo(RoomSchedule::class, 'room_schedule_id');
    }

    public function student()
    {
        return $this->belongsTo(StudentInfo::class, 'student_info_id');
    }

    use HasFactory;
}
