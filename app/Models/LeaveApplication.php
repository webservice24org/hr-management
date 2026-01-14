<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\LeaveType;

class LeaveApplication extends Model
{
    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'from_date',
        'end_date',
        'total_days',
        'application_hard_copy',
        'reason',
        'status',
    ];

    protected $casts = [
        'from_date' => 'date',
        'end_date'  => 'date',
    ];

    /* ---------------- RELATIONSHIPS ---------------- */

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    /* ---------------- AUTO TOTAL DAYS ---------------- */

    protected static function booted()
    {
        static::saving(function ($leave) {
            if ($leave->from_date && $leave->end_date) {
                $leave->total_days =
                    Carbon::parse($leave->from_date)
                        ->diffInDays(Carbon::parse($leave->end_date)) + 1;
            }
        });
    }

    // App\Models\LeaveApplication.php
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }


}
