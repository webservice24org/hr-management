<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\HasDeleteConfirmation;

class RoleManager extends Component
{
    use HasDeleteConfirmation;

    public $permissions; // All available permissions
    public $selectedPermissions = []; // Permission IDs selected for current role

    public $roles=[];
    public $roleId, $name;
    public $isEdit = false;

    public $roleIdToDelete;
    

    public function loadRoles()
    {
        
        $this->roles = Role::orderBy('name')->get();
    }

    public function mount()
    {
        
        $this->loadRoles();
        $this->loadPermissions();
    }


    public function loadPermissions()
    {
        
        $this->permissions = Permission::orderBy('name')->get();
    }


    public function render()
    {
        $this->roles = Role::all();
        return view('livewire.admin.users.role-manager');
    }

    public function resetForm()
    {
        $this->roleId = null;
        $this->name = '';
        $this->isEdit = false;
    }

    

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create(['name' => $this->name]);

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Role Created',
            message: 'Role created successfully!',
            options: [
                'showCloseBtn' => true,
            ],
        );

        $this->resetForm();
    }

   

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $this->roleId = $id;
        $this->name = $role->name;
        $this->isEdit = true;

        $this->selectedPermissions = $role->permissions->pluck('id')->toArray(); // ✅ Load permissions
    }

    


    public function update()
    {
      
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->roleId,
        ]);

        $role = Role::findOrFail($this->roleId);
        $role->update(['name' => $this->name]);

        $permissionNames = Permission::whereIn('id', $this->selectedPermissions)->pluck('name');
        $role->syncPermissions($permissionNames); 

        $this->dispatch('toastMagic',
            status: 'info',
            title: 'Role Updated',
            message: 'Role updated successfully.',
            options: [
                'showCloseBtn' => true,
            ],
        );
        $this->resetForm();
    }


    public function toggleSelectAll()
    {
        if ($this->allPermissionsSelected()) {
            $this->selectedPermissions = [];
        } else {
            $this->selectedPermissions = $this->permissions->pluck('id')->map(fn($id) => (string) $id)->toArray();
        }
    }

    public function allPermissionsSelected()
    {
        return count($this->permissions) === count($this->selectedPermissions);
    }


    protected function performDelete(int $id)
    {
        Role::findOrFail($id)->delete();

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'Role Deleted',
            message: 'Role deleted successfully.',
            options: ['showCloseBtn' => true]
        );
    }






}
