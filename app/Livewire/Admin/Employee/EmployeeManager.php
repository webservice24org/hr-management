<?php

namespace App\Livewire\Admin\Employee;

use Livewire\Component;
use App\Models\Employee;
use App\Models\CandidateInformation;
use Livewire\WithPagination;

class EmployeeManager extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $confirmingDelete = false;
    public $deleteId = null;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->deleteId = $id;
    }

    public function deleteEmployee()
    {
        $employee = Employee::find($this->deleteId);

        if ($employee) {
            $employee->delete();
            $this->dispatch('toastMagic', status: 'error', title: 'Deleted', message: 'Employee deleted successfully.');
        }

        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $employees = Employee::with(['candidate'])
            ->whereHas('candidate', function ($q) {
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%");
            })
            ->orWhere('national_id', 'like', "%{$this->search}%")
            ->paginate($this->perPage);

        return view('livewire.admin.employee.employee-manager', [
            'employees' => $employees
        ]);
    }
}
