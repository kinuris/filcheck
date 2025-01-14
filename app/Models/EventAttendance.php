<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendance extends Model
{
    protected $table = 'event_attendances';

    protected $fillable = [
        'student_info_id',
        'event_id'
    ];

    public function studentInfo()
    {
        return $this->belongsTo(StudentInfo::class, 'student_info_id');
    }

    use HasFactory;
}
