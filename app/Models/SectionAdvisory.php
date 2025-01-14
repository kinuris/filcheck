<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionAdvisory extends Model
{
    protected $table = 'section_advisories';
    protected $fillable = [
        'section',
        'user_id',
    ];

    use HasFactory;
}
