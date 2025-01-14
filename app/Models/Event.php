<?php

namespace App\Models;

use DateInterval;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = [
        'name',
        'event_id',
        'description',
        'address',
        'start',
        'end',
    ];

    public function dayCount()
    {
        $start = new \DateTime($this->start);
        $end = new \DateTime($this->end);

        $days = $start->diff($end)->days;

        return $days + 1;
    }

    public function attendeesAtDay(int $day)
    {
        if ($day > $this->dayCount()) {
            throw "Over the available days.";
        }

        $start = new \DateTime($this->start);

        $day = $day - 1;
        if ($day > 0) {
            $start->add(new DateInterval("P{$day}D"));
        }

        $dayStart = (clone $start)->setTime(0, 0, 0);
        $dayEnd = (clone $start)->setTime(23, 59, 59);

        return $this->attendanceRecords()
            ->where('created_at', '>', $dayStart)
            ->where('created_at', '<', $dayEnd);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(EventAttendanceRecord::class, 'event_id');
    }

    public function students()
    {
        return $this->hasManyThrough(StudentInfo::class, EventAttendance::class, 'event_id', 'id', 'id', 'student_info_id');
    }

    public function attendances()
    {
        return $this->hasMany(EventAttendance::class, 'event_id');
    }

    public function isSectionRequired(string $section): bool
    {
        return EventAttendance::query()
            ->where('event_id', '=', $this->id)
            ->whereRelation('studentInfo', 'section', '=', $section)
            ->exists();
    }

    public function hasEnded(): bool
    {
        return $this->end < now();
    }

    public static function genNoCollisionEventID(): string
    {
        while (true) {
            $internalId = 'EVT-' . str_pad(rand(0, 999999), 6, "0", STR_PAD_LEFT);
            if (self::query()->where('event_id', '=', $internalId)->exists()) {
                continue;
            }

            return $internalId;
        }
    }

    public function casts(): array
    {
        return [
            'start' => 'datetime',
            'end' => 'datetime',
        ];
    }

    public static function ongoingEvents()
    {
        return self::query()
            ->where('start', '<=', now())
            ->where('end', '>=', now());
    }

    public static function pastEvents()
    {
        return self::query()
            ->where('end', '<', now());
    }

    public static function upcomingEvents()
    {
        return self::query()
            ->where('start', '>', now());
    }

    use HasFactory;
}
