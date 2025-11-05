<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CandidateInformation;
use App\Models\EmployeeInformation;
use App\Models\EmployeeSalary;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'national_id',
        'passport_no',
        'driving_license',
        'employee_type',
    ];

    // Relationship: Employee belongs to a candidate
    public function candidate()
    {
        return $this->belongsTo(CandidateInformation::class, 'candidate_id');
    }

    // ✅ Relationship: Employee has one EmployeeInformation
    public function information()
    {
        return $this->hasOne(EmployeeInformation::class, 'employee_id');
    }

    // ✅ Relationship: Employee has one EmployeeSalary
    public function salary()
    {
        return $this->hasOne(EmployeeSalary::class, 'employee_id');
    }
}

