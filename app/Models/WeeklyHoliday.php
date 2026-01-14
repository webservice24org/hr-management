<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyHoliday extends Model
{
     protected $fillable = [
        'day_name',
        'day_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
