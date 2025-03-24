<?php

namespace App\Models;

use App\Helpers\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    protected $table = 'student_infos';
    protected $fillable = [
        'rfid',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'student_number',
        'phone_number',
        'profile_picture',
        'guardian',
        'birthdate',
        'department_id',
        'address',
        'year',
        'section'
    ];

    public static function getExistingSections(?int $year = null)
    {
        $unparsed = StudentInfo::query()
            ->whereDoesntHave('disabledRelation')
            ->select('section');

        if ($year != null) {
            $unparsed = $unparsed->where('year', '=', $year);
        }

        $unparsed = $unparsed
            ->distinct()
            ->get();

        $parsed = array();
        foreach ($unparsed->toArray() as $section) {
            array_push($parsed, $section['section']);
        }

        return $parsed;
    }

    public function attendanceRecordOf(Event $event)
    {
        return $this->hasMany(EventAttendanceRecord::class, 'student_info_id')
            ->where('event_id', '=', $event->id);
    }

    public function getCodeAndSection() {
        $parts = explode('-', $this->section);

        return [
            $parts[0],
            $parts[1][1]
        ];        
    }

    public function activatedSms(): bool
    {
        return ActiveSms::query()
            ->where('student_info_id', '=', $this->id)
            ->exists();
    }

    public function disabled(): bool
    {
        return StudentDisabled::query()
            ->where('student_info_id', '=', $this->id)
            ->exists();
    }

    public function disabledRelation()
    {
        return $this->hasOne(StudentDisabled::class);
    }

    public function gateLogs()
    {
        return $this->hasMany(GateLog::class, 'student_info_id');
    }

    public function latestLog()
    {
        return $this->hasOne(GateLog::class, 'student_info_id')->latestOfMany();
    }

    public function fullPhoneNumber()
    {
        return '63' . substr($this->phone_number, 1);
    }

    public function gateLogsByDay()
    {
        $logs = $this->gateLogs()
            ->orderBy('day', 'DESC')
            ->orderBy('time', 'DESC')
            ->get();

        $result = [];
        foreach ($logs as $log) {
            $key = date_create($log->day)->format('Y-m-d');

            if (array_key_exists($key, $result)) {
                array_push($result[$key], $log);
            } else {
                $result[$key] = array($log);
            }
        }

        return $result;
    }

    public function getFullNameAttribute()
    {
        if ($this->middle_name == null) {
            return $this->first_name . ' ' . $this->last_name;
        }

        return $this->first_name . ' ' . $this->middle_name[0] . '. ' . $this->last_name;
    }

    public function shouldText(): bool
    {
        return $this->guardian()->first() !== null;
    }

    public function notifyGuardian()
    {
        $msg = Message::filcheck();
        $msg->setFullPhoneNumber($this->guardian()->first()->registered_number);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function image()
    {
        if (str_contains($this->profile_picture, 'http')) {
            return $this->profile_picture;
        } else {
            return asset('storage/student/images/' . $this->profile_picture);
        }
    }

    use HasFactory;
}
