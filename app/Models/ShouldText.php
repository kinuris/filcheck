<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShouldText extends Model
{
    protected $table = 'should_texts';
    protected $fillable = [
        'student_info_id',
    ];

    use HasFactory;
}
