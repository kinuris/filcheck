<?php

namespace App\Models;

use App\Helpers\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'rfid',
        'profile_picture',
        'role',
        'gender',
        'birthdate',
        'phone_number',
        'department_id',
        'username',
        'password',
    ];

    public function gateLogs()
    {
        return $this->hasMany(EmployeeLog::class, 'user_id');
    }

    public function classes() {
        return $this->hasMany(RoomSchedule::class, 'user_id');
    }

    public function advisories()
    {
        return $this->hasMany(SectionAdvisory::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public static function teachers()
    {
        return self::query()->where('role', '=', 'Teacher');
    }

    public function advisedSections()
    {
        return $this->hasMany(SectionAdvisory::class, 'user_id');
    }

    public function latestLog()
    {
        return $this->hasOne(EmployeeLog::class, 'user_id')->latestOfMany();
    }

    public function image()
    {
        if (str_contains($this->profile_picture, 'http')) {
            return $this->profile_picture;
        } else {
            return asset('storage/users/images/' . $this->profile_picture);
        }
    }

    public function getFullname(): string
    {
        if ($this->middle_name) {
            return $this->first_name . ' ' . $this->middle_name[0] . '. ' . $this->last_name;
        } else {
            return $this->first_name . ' ' . $this->last_name;
        }
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
