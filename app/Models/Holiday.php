<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'holiday_name',
        'from_date',
        'to_date',
        'total_days',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];

    /**
     * Automatically calculate total days before saving
     */
    protected static function booted()
    {
        static::saving(function ($holiday) {
            if ($holiday->from_date && $holiday->to_date) {
                $holiday->total_days =
                    Carbon::parse($holiday->from_date)
                        ->diffInDays(Carbon::parse($holiday->to_date)) + 1;
            }
        });
    }
}
