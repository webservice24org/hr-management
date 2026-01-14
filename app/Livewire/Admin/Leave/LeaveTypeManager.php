<?php

namespace App\Livewire\Admin\Leave;

use Livewire\Component;
use App\Models\LeaveType;

class LeaveTypeManager extends Component
{
    public $leaveTypeId;
    public $leave_type;
    public $leave_days;
    public $is_active = true;

    protected $rules = [
        'leave_type' => 'required|string|max:100|unique:leave_types,leave_type',
        'leave_days' => 'required|integer|min:1',
        'is_active'  => 'boolean',
    ];

    protected $validationAttributes = [
        'leave_type' => 'Leave Type',
        'leave_days' => 'Leave Days',
    ];

    public function save()
    {
        $rules = $this->rules;

        // Unique validation fix for edit
        if ($this->leaveTypeId) {
            $rules['leave_type'] =
                'required|string|max:100|unique:leave_types,leave_type,' . $this->leaveTypeId;
        }

        $this->validate($rules);

        LeaveType::updateOrCreate(
            ['id' => $this->leaveTypeId],
            [
                'leave_type' => $this->leave_type,
                'leave_days' => $this->leave_days,
                'is_active'  => $this->is_active,
            ]
        );

        $this->resetForm();

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Success',
            message: 'Leave type saved successfully.'
        );
    }

    public function edit($id)
    {
        $leave = LeaveType::findOrFail($id);

        $this->leaveTypeId = $leave->id;
        $this->leave_type  = $leave->leave_type;
        $this->leave_days  = $leave->leave_days;
        $this->is_active   = $leave->is_active;
    }

    public function toggle($id)
    {
        $leave = LeaveType::findOrFail($id);
        $leave->update(['is_active' => !$leave->is_active]);
    }

    public function delete($id)
    {
        LeaveType::findOrFail($id)->delete();

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Deleted',
            message: 'Leave type deleted successfully.'
        );
    }

    public function resetForm()
    {
        $this->reset(['leaveTypeId', 'leave_type', 'leave_days', 'is_active']);
        $this->is_active = true;
    }

    public function render()
    {
        return view('livewire.admin.leave.leave-type-manager', [
            'leaveTypes' => LeaveType::orderBy('leave_type')->get(),
        ]);
    }
}
