<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'name',
        'building',
    ];

    public function schedules()
    {
        return $this->hasMany(RoomSchedule::class, 'room_id');
    }

    public function scheduleAt($time)
    {
        return $this->schedules()
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->first();
    }

    use HasFactory;
}
