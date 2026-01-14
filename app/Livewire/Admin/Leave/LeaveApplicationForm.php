<?php

namespace App\Livewire\Admin\Leave;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LeaveApplication;
use App\Models\LeaveType;
use Carbon\Carbon;
use App\Models\Employee;

class LeaveApplicationForm extends Component
{
    use WithFileUploads;

    public $employee_id;
    public $leave_type_id;
    public $from_date;
    public $end_date;
    public $total_days = 0;
    public $reason;
    public $application_hard_copy;

    protected $rules = [
        'employee_id'   => 'required|exists:employees,id',
        'leave_type_id' => 'required|exists:leave_types,id',
        'from_date'     => 'required|date',
        'end_date'      => 'required|date|after_or_equal:from_date',
        'reason'        => 'nullable|string',
        'application_hard_copy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];

    public function mount()
    {
        /**
         * FUTURE EMPLOYEE PANEL LOGIC
         * --------------------------------
         * if (auth()->check() && auth()->user()->employee) {
         *     $this->employee_id = auth()->user()->employee->id;
         * }
         */
    }

    public function updated($property)
    {
        if ($this->from_date && $this->end_date) {
            $this->total_days =
                \Carbon\Carbon::parse($this->from_date)
                    ->diffInDays(\Carbon\Carbon::parse($this->end_date)) + 1;
        }
    }

    public function updatedFromDate()
    {
        $this->calculateTotalDays();
    }

    public function updatedEndDate()
    {
        $this->calculateTotalDays();
    }

    private function calculateTotalDays()
    {
        if (!$this->from_date || !$this->end_date) {
            $this->total_days = 0;
            return;
        }

        $from = Carbon::parse($this->from_date);
        $to   = Carbon::parse($this->end_date);

        if ($to->lt($from)) {
            $this->total_days = 0;
            return;
        }

        // BASIC CALCULATION (holidays excluded later)
        $this->total_days = $from->diffInDays($to) + 1;
    }

    public function submit()
    {
        $this->validate();

        $filePath = $this->application_hard_copy
            ? $this->application_hard_copy->store('leave_applications', 'public')
            : null;

        LeaveApplication::create([
            'employee_id' => $this->employee_id,
            'leave_type_id' => $this->leave_type_id,
            'from_date' => $this->from_date,
            'end_date' => $this->end_date,
            'total_days' => $this->total_days,
            'application_hard_copy' => $filePath,
            'reason' => $this->reason,
            'status' => 'pending',
        ]);

        $this->reset();

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Submitted',
            message: 'Leave application submitted successfully.'
        );
    }

    public function render()
    {
        return view('livewire.admin.leave.leave-application-form', [
            'leaveTypes' => LeaveType::orderBy('leave_type')->get(),
            'employees'  => Employee::with('candidate')
                                ->orderBy('id')
                                ->get(),
        ]);
    }
}