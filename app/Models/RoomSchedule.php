<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomSchedule extends Model
{
    protected $table = 'room_schedules';

    protected $fillable = [
        'days_recurring', // Mon,Wed,Fri
        'section',
        'start_time',
        'end_time',
        'user_id', // teacher 
        'room_id',
        'subject_id',
    ];

    public function eventAttendances() {
        return $this->hasMany(SubjectEventAttendance::class);
    }

    public function lastClass()
    {
        $today = now();
        $dayNames = json_decode($this->days_recurring);
        $latestDate = null;

        for ($i = 0; $i <= 7; $i++) {
            $checkDate = $today->copy()->subDays($i);
            $dayName = $checkDate->format('D');

            if (in_array($dayName, $dayNames)) {
                $latestDate = $checkDate;
                break;
            }
        }

        return $latestDate;
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function irregulars()
    {
        return $this->hasMany(IrregularRoomSchedule::class);
    }

    public function regulars()
    {
        return StudentInfo::query()->where('section', '=', $this->section)->get();
    }

    use HasFactory;
}
