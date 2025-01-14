<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomSchedule extends Model
{
    protected $table = 'room_schedules';

    protected $fillable = [
        'days_recurring', // M,W,F
        'section',
        'start_time',
        'end_time',
        'user_id', // creator
        'room_id',
        'subject_id',
    ];

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function room() {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function teacher() {
        return $this->belongsTo(User::class, 'user_id');
    }

    use HasFactory;
}
