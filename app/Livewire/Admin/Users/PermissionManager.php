<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use App\Traits\HasDeleteConfirmation;

class PermissionManager extends Component
{
    use WithPagination;
    use HasDeleteConfirmation;

    public $name, $permissionId, $isEdit = false;

    protected function ensureAdmin()
    {
        if (!auth()->user()->hasAnyRole(['Super Admin'])) {
            abort(403, 'Unauthorized.');
        }
    }

    public function render()
    {
        return view('livewire.admin.users.permission-manager', [
            'permissions' => Permission::orderBy('name')->paginate(10)
        ]);
    }

    public function store()
    {
        //$this->ensureAdmin();
        $this->validate(['name' => 'required|unique:permissions,name']);

        Permission::create(['name' => $this->name]);
        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Permission Created',
            message: 'Permission created successfully.',
            options: [
                'showCloseBtn' => true,
            ],
        );

        $this->resetForm();
    }

    public function edit($id)
    {
        //$this->ensureAdmin();
        $permission = Permission::findOrFail($id);
        $this->permissionId = $id;
        $this->name = $permission->name;
        $this->isEdit = true;
    }

    public function update()
    {
        //$this->ensureAdmin();
        $this->validate([
            'name' => 'required|unique:permissions,name,' . $this->permissionId,
        ]);

        Permission::findOrFail($this->permissionId)->update(['name' => $this->name]);

        $this->dispatch('toastMagic',
            status: 'info',
            title: 'Permission Updated',
            message: 'Permission updated successfully.',
            options: [
                'showCloseBtn' => true,
            ],
        );
        $this->resetForm();
    }

    protected function performDelete(int $id)
    {
        Permission::findOrFail($id)->delete();

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'Permission Deleted',
            message: 'Permission deleted successfully.',
            options: ['showCloseBtn' => true]
        );
    }

    public function resetForm()
    {
        $this->name = '';
        $this->permissionId = null;
        $this->isEdit = false;

        $this->resetPage();
    }
}