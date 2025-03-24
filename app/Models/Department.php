<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = [
        'name',
        'code'
    ];

    public function students()
    {
        return $this->hasMany(StudentInfo::class);
    }

    public function teachers()
    {
        return $this->hasMany(User::class)->where('role', '=', 'Teacher');
    }

    use HasFactory;
}
