<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GateLog extends Model
{
    protected $table = 'gate_logs';
    protected $fillable = [
        'type',
        'day',
        'time',
        'student_info_id'
    ];

    public function isSameDay(DateTime $date)
    {
        return date_create($this->day)->format('Y-m-d') === $date->format('Y-m-d');
    }

    use HasFactory;
}
