<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLog extends Model
{
    protected $table = 'employee_logs';
    protected $fillable = [
        'type',
        'day',
        'time',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isSameDay(\DateTime $date)
    {
        return date_create($this->day)->format('Y-m-d') === $date->format('Y-m-d');
    }

    use HasFactory;
}
