<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeePerformance;

class EmployeePerformanceDetail extends Model
{
     protected $fillable = [
        'employee_performance_id',
        'section',
        'criteria',
        'score',
        'comments',
    ];

    public function performance()
    {
        return $this->belongsTo(EmployeePerformance::class, 'employee_performance_id');
    }
}
