<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveSms extends Model
{
    protected $table = 'active_sms';
    protected $fillable = [
        'student_info_id',
    ];

    public function studentInfo()
    {
        return $this->belongsTo(StudentInfo::class, 'student_info_id');
    }

    use HasFactory;
}
