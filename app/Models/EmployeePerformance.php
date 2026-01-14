<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\EmployeePerformanceDetail;

class EmployeePerformance extends Model
{
    protected $fillable = [
        'employee_id',
        'review_date',
        'review_period',
        'section_a',
        'section_b',
        'total_score',
        'final_rating',
        'overall_comment',
        'is_locked',
    ];

    protected $casts = [
        'section_a' => 'array',
        'section_b' => 'array',
        'review_date' => 'date',
        'is_locked' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function details()
    {
        return $this->hasMany(EmployeePerformanceDetail::class);
    }

}
