<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employee;;
use App\Models\Department;
use App\Models\SubDepartment;

class EmployeeInformation extends Model

{
    use HasFactory;
    protected $table = 'employee_informations';

    protected $fillable = [
        'employee_id',
        'department_id',
        'sub_department_id',
        'joining_date',
        'hire_date',
        'rehire_date',
        'id_card_no',
        'daily_working_hours',
        'pay_review',
        'pay_review_note',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }


    public function subDepartment()
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    }
}
