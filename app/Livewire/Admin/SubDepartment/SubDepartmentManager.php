<?php

namespace App\Livewire\Admin\SubDepartment;

use App\Models\SubDepartment;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\HasDeleteConfirmation;
use App\Imports\SubDepartmentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

class SubDepartmentManager extends Component
{
    use WithPagination, HasDeleteConfirmation, WithFileUploads;

    public $sub_departmentId;
    public $department_id;
    public $sub_department_name;
    public $status = 'active';
    public $showModal = false;

    public $excelFile;

    protected $rules = [
        'department_id' => 'required|exists:departments,id',
        'sub_department_name' => 'required|string|max:255',
        'status' => 'required|in:active,inactive',
    ];

    #[On('edit-sub-department')]
    public function edit($id)
    {
        $subDept = SubDepartment::findOrFail($id);
        $this->sub_departmentId = $id;
        $this->department_id = $subDept->department_id;
        $this->sub_department_name = $subDept->sub_department_name;
        $this->status = $subDept->status;
        $this->showModal = true;
    }

    public function create()
    {
        $this->reset(['sub_departmentId', 'department_id', 'sub_department_name', 'status']);
        $this->status = 'active';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        SubDepartment::updateOrCreate(
            ['id' => $this->sub_departmentId],
            [
                'uuid' => $this->sub_departmentId
                    ? SubDepartment::find($this->sub_departmentId)->uuid
                    : (string) Str::uuid(),
                'department_id' => $this->department_id,
                'sub_department_name' => $this->sub_department_name,
                'status' => $this->status,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]
        );

        $this->dispatch('toastMagic', [
            'status' => 'success',
            'title' => $this->sub_departmentId ? 'Sub Department Updated' : 'Sub Department Created',
            'message' => $this->sub_departmentId
                ? 'Sub department updated successfully.'
                : 'New sub department created successfully.',
        ]);

        $this->dispatch('sub-departments-updated');
        $this->reset(['showModal', 'sub_departmentId', 'department_id', 'sub_department_name', 'status']);
    }

    #[On('confirm-sub-department-delete')]
    public function handleDepartmentDelete(int $id)
    {
        $this->confirmDelete($id);
    }

    protected function performDelete(int $id)
    {
        SubDepartment::findOrFail($id)->delete();

        $this->dispatch('toastMagic', [
            'status' => 'error',
            'title' => 'Sub Department Deleted',
            'message' => 'Sub department deleted successfully.',
        ]);

        $this->dispatch('sub-departments-updated');
    }

    public function render()
    {
        $departments = Department::where('status', 'active')->get();

        return view('livewire.admin.sub-department.sub-department-manager', [
            'departments' => $departments,
        ]);
    }

    public function importExcel()
    {
        if (!$this->excelFile) {
            $this->dispatch('toastMagic', status: 'error', title: 'No File', message: 'Please select an Excel file.');
            return;
        }

        $import = new SubDepartmentsImport;
        Excel::import($import, $this->excelFile);

        $this->dispatch('toastMagic', 
            status: 'success', 
            title: 'Import Completed', 
            message: "Inserted: {$import->inserted}, Skipped: {$import->skipped}"
        );

        $this->excelFile = null;

        // Optionally refresh datatable
        $this->dispatch('sub-departments-updated');
    }


}
