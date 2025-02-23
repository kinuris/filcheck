<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrregularAttendanceRecord extends Model
{
    public function irregularRoomSchedule()
    {
        return $this->belongsTo(IrregularRoomSchedule::class, 'irregular_room_schedule_id');
    }

    use HasFactory;
}
