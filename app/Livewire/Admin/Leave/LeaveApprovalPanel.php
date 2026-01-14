<?php

namespace App\Livewire\Admin\Leave;

use Livewire\Component;
use App\Models\LeaveApplication;

class LeaveApprovalPanel extends Component
{
    public function approve($id)
    {
        $leave = LeaveApplication::findOrFail($id);

        $leave->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Approved',
            message: 'Leave approved successfully.'
        );
    }

    public function reject($id)
    {
        $leave = LeaveApplication::findOrFail($id);

        $leave->update([
            'status'      => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'Rejected',
            message: 'Leave rejected.'
        );
    }

    public function render()
    {
        return view('livewire.admin.leave.leave-approval-panel', [
            'leaves' => LeaveApplication::with([
                'employee.candidate',
                'leaveType'
            ])->latest()->get()
        ]);
    }
}
