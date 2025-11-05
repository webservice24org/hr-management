<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employee;

class EmployeeSalary extends Model
{
    use HasFactory;

    protected $table = 'employee_salaries';

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'transport_allowance',
        'medical_allowance',
        'house_rent',
        'gross_salary',
        'account_no',
        'bank_name',
        'bank_branch',
        'routing_no',
        'tin_no',
    ];

    // 🔗 Relationship
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // 🧮 Automatically calculate gross_salary
    protected static function booted()
    {
        static::saving(function ($salary) {
            $salary->gross_salary =
                ($salary->basic_salary ?? 0) +
                ($salary->transport_allowance ?? 0) +
                ($salary->medical_allowance ?? 0) +
                ($salary->house_rent ?? 0);
        });
    }
}
