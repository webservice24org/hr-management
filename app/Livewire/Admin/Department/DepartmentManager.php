<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasDeleteConfirmation;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DepartmentsImport;

use Livewire\Attributes\On;

class DepartmentManager extends Component
{
    use WithPagination, HasDeleteConfirmation, WithFileUploads;

    public $showModal = false;
    public $departmentId;
    public $department_name;
    public $status = 'active';
    public $excelFile;

    protected $rules = [
        'department_name' => 'required|string|max:255',
        'status' => 'required|in:active,inactive',
    ];

    public function render()
    {
        return view('livewire.admin.department.department-manager');
    }

    public function create()
    {
        $this->reset(['departmentId', 'department_name', 'status']);
        $this->showModal = true;
    }

    #[On('edit-department')]
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $this->departmentId = $id;
        $this->department_name = $department->department_name;
        $this->status = $department->status; // ✅ Correct
        $this->showModal = true;
    }


    #[On('confirm-department-delete')]
    public function handleDepartmentDelete(int $id)
    {
        $this->confirmDelete($id);
    }


    // Handle actual deletion using HasDeleteConfirmation trait
    protected function performDelete(int $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'Department Deleted',
            message: 'Department deleted successfully.',
            options: ['showCloseBtn' => true]
        );

        // Tell datatable to refresh
        $this->dispatch('departments-updated');
    }

    public function save()
    {
        $this->validate();

        $department = Department::updateOrCreate(
            ['id' => $this->departmentId],
            [
                'uuid' => $this->departmentId 
                    ? Department::find($this->departmentId)->uuid 
                    : (string) Str::uuid(),
                'department_name' => $this->department_name,
                'status' => $this->status === 'active' ? 'active' : 'inactive',
                'created_by' => $this->departmentId ? Department::find($this->departmentId)->created_by : Auth::id(),
                'updated_by' => Auth::id(),
            ]
        );

        $this->dispatch('toastMagic',
            status: 'success',
            title: $this->departmentId ? 'Department Updated' : 'Department Created',
            message: $this->departmentId 
                ? 'Department has been successfully updated.' 
                : 'New department has been created successfully.',
            options: [
                'showCloseBtn' => true,
                'timeout' => 3000,
            ],
        );

        $this->dispatch('departments-updated');

        $this->showModal = false;
        $this->reset(['departmentId', 'department_name', 'status']);
    }

    public function importExcel()
    {
        $this->validate([
            'excelFile' => 'required|file|mimes:xlsx,csv',
        ]);

        Excel::import(new DepartmentsImport, $this->excelFile->store('temp'));

        $this->excelFile = null; 

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Departments Imported',
            message: 'Excel file imported successfully!',
            options: [
                'showCloseBtn' => true,
                'timeout' => 3000,
            ]
        );

        $this->dispatch('departments-updated');
    }


    
}


