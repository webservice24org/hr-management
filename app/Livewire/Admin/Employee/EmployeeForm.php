<?php

namespace App\Livewire\Admin\Employee;

use App\Models\CandidateInformation;
use App\Models\Employee;
use App\Models\EmployeeInformation;
use App\Models\EmployeeSalary;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\Department;
use App\Models\SubDepartment;

class EmployeeForm extends Component
{
    public $step = 1;

    // Step 1: Employee
     public $candidates = [];
    public $departments = [];
    public $subDepartments = [];
    public $candidate_id;
    public $national_id;
    public $passport_no;
    public $driving_license;
    public $employee_type;

    // Step 2: Employee Information
    public $department_id;
    public $sub_department_id;
    public $joining_date;
    public $hire_date;
    public $rehire_date;
    public $id_card_no;
    public $daily_working_hours;
    public $pay_review;
    public $pay_review_note;

    // Step 3: Salary
    public $basic_salary = 0;
    public $transport_allowance = 0;
    public $medical_allowance = 0;
    public $house_rent = 0;
    public $gross_salary = 0;
    public $account_no;
    public $bank_name;
    public $bank_branch;
    public $routing_no;
    public $tin_no;

    public $employee_id;

    protected $rules = [
        // Step 1
        'candidate_id' => 'required|exists:candidate_informations,id',
        'national_id' => 'required|string|max:100',
        'employee_type' => 'required|in:Full time,Part time,Contractual,Daily worker',

        // Step 2
        'department_id' => 'nullable|integer',
        'joining_date' => 'required|date',
        'hire_date' => 'required|date',

        // Step 3
        'basic_salary' => 'required|numeric|min:0',
    ];

    // Load all departments when component mounts
    public function mount($employee_id = null)
    {
        $this->candidates = CandidateInformation::where('status', 'Final Selected')->get();
        $this->departments = Department::orderBy('department_name')->get();
        $this->subDepartments = collect();

        if ($employee_id) {
    $this->employee_id = $employee_id;

    $employee = Employee::with(['information', 'salary'])->findOrFail($employee_id);

    // Step 1
    $this->candidate_id = $employee->candidate_id;
    $this->national_id = $employee->national_id;
    $this->passport_no = $employee->passport_no;
    $this->driving_license = $employee->driving_license;
    $this->employee_type = $employee->employee_type;

    // Step 2
    if ($employee->information) {
        $info = $employee->information;
        $this->department_id = $info->department_id;

        // load sub-departments but **don't reset sub_department_id yet**
        $this->subDepartments = SubDepartment::where('department_id', $this->department_id)
            ->orderBy('sub_department_name')
            ->get();

        $this->sub_department_id = $info->sub_department_id; // ✅ keep selected
        $this->joining_date = $info->joining_date;
        $this->hire_date = $info->hire_date;
        $this->rehire_date = $info->rehire_date;
        $this->id_card_no = $info->id_card_no;
        $this->daily_working_hours = $info->daily_working_hours;

        // normalize pay_review to match option values
        $this->pay_review = strtolower($info->pay_review); 
        $this->pay_review_note = $info->pay_review_note;
        }

        // Step 3
        if ($employee->salary) {
            $salary = $employee->salary;
            $this->basic_salary = $salary->basic_salary;
            $this->transport_allowance = $salary->transport_allowance;
            $this->medical_allowance = $salary->medical_allowance;
            $this->house_rent = $salary->house_rent;
            $this->gross_salary = $salary->gross_salary;
            $this->account_no = $salary->account_no;
            $this->bank_name = $salary->bank_name;
            $this->bank_branch = $salary->bank_branch;
            $this->routing_no = $salary->routing_no;
            $this->tin_no = $salary->tin_no;
        }
    }

    }



    public function updatedDepartmentId($departmentId)
    {
        $this->subDepartments = SubDepartment::where('department_id', $departmentId)
            ->orderBy('sub_department_name')
            ->get();

        // Only reset sub_department_id if it's empty
        if (!$this->sub_department_id) {
            $this->sub_department_id = null;
        }
    }





    

    public function updated($field)
    {
        if (in_array($field, ['basic_salary', 'transport_allowance', 'medical_allowance', 'house_rent'])) {
            $this->calculateGross();
        }
    }

    public function calculateGross()
    {
        $this->gross_salary = 
            floatval($this->basic_salary) + 
            floatval($this->transport_allowance) + 
            floatval($this->medical_allowance) + 
            floatval($this->house_rent);
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    protected function validateStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'candidate_id' => 'required|exists:candidate_informations,id',
                'national_id' => 'required|string|max:100',
                'employee_type' => 'required|in:Full time,Part time,Contractual,Daily worker',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'joining_date' => 'required|date',
                'hire_date' => 'required|date',
            ]);
        } elseif ($this->step === 3) {
            $this->validate([
                'basic_salary' => 'required|numeric|min:0',
            ]);
        }
    }

    public function save()
    {
        $this->validate();

        // ✅ If employee_id exists, we're editing
        if ($this->employee_id) {
            $employee = Employee::findOrFail($this->employee_id);
            $employee->update([
                'candidate_id' => $this->candidate_id,
                'national_id' => $this->national_id,
                'passport_no' => $this->passport_no,
                'driving_license' => $this->driving_license,
                'employee_type' => $this->employee_type,
            ]);

            // ✅ Update Employee Information
            $employeeInfo = EmployeeInformation::firstOrNew(['employee_id' => $employee->id]);
            $employeeInfo->fill([
                'department_id' => $this->department_id,
                'sub_department_id' => $this->sub_department_id,
                'joining_date' => $this->joining_date,
                'hire_date' => $this->hire_date,
                'rehire_date' => $this->rehire_date,
                'id_card_no' => $this->id_card_no,
                'daily_working_hours' => $this->daily_working_hours,
                'pay_review' => $this->pay_review,
                'pay_review_note' => $this->pay_review_note,
            ]);
            $employeeInfo->save();

            // ✅ Update Employee Salary
            $employeeSalary = EmployeeSalary::firstOrNew(['employee_id' => $employee->id]);
            $employeeSalary->fill([
                'basic_salary' => $this->basic_salary,
                'transport_allowance' => $this->transport_allowance,
                'medical_allowance' => $this->medical_allowance,
                'house_rent' => $this->house_rent,
                'gross_salary' => $this->gross_salary,
                'account_no' => $this->account_no,
                'bank_name' => $this->bank_name,
                'bank_branch' => $this->bank_branch,
                'routing_no' => $this->routing_no,
                'tin_no' => $this->tin_no,
            ]);
            $employeeSalary->save();

            $message = 'Employee updated successfully.';
        } 
        else {
            // ✅ Creating new Employee
            $employee = Employee::create([
                'candidate_id' => $this->candidate_id,
                'national_id' => $this->national_id,
                'passport_no' => $this->passport_no,
                'driving_license' => $this->driving_license,
                'employee_type' => $this->employee_type,
            ]);

            EmployeeInformation::create([
                'employee_id' => $employee->id,
                'department_id' => $this->department_id,
                'sub_department_id' => $this->sub_department_id,
                'joining_date' => $this->joining_date,
                'hire_date' => $this->hire_date,
                'rehire_date' => $this->rehire_date,
                'id_card_no' => $this->id_card_no,
                'daily_working_hours' => $this->daily_working_hours,
                'pay_review' => $this->pay_review,
                'pay_review_note' => $this->pay_review_note,
            ]);

            EmployeeSalary::create([
                'employee_id' => $employee->id,
                'basic_salary' => $this->basic_salary,
                'transport_allowance' => $this->transport_allowance,
                'medical_allowance' => $this->medical_allowance,
                'house_rent' => $this->house_rent,
                'gross_salary' => $this->gross_salary,
                'account_no' => $this->account_no,
                'bank_name' => $this->bank_name,
                'bank_branch' => $this->bank_branch,
                'routing_no' => $this->routing_no,
                'tin_no' => $this->tin_no,
            ]);

            // Create user only for new employees
            $candidate = CandidateInformation::find($this->candidate_id);
            User::create([
                'name' => "{$candidate->first_name} {$candidate->last_name}",
                'email' => $candidate->email,
                'password' => Hash::make('123456'),
                'status' => 'Pending',
            ]);

            $message = 'Employee created successfully.';
        }

        $this->dispatch(
            'toastMagic',
            status: 'success',
            title: 'Success',
            message: $message
        );
        return redirect()->route('admin.employee.manager');
    }


    public function render()
    {
        return view('livewire.admin.employee.employee-form');
    }
}
