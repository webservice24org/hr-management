<?php

namespace App\Livewire\Admin\Employee;

use Livewire\Component;
use App\Models\Employee;

class EmployeeViewManager extends Component
{

    public $employee_id;
    public $employee;

    public function mount($employee_id)
    {
        $this->employee_id = $employee_id;

        $this->employee = Employee::with([
            'candidate.interviews', // ✅ ADD THIS
            'information.department',
            'information.subDepartment',
            'salary'
        ])->findOrFail($employee_id);
    }


    public function render()
    {
        return view('livewire.admin.employee.employee-view-manager');
    }

}
