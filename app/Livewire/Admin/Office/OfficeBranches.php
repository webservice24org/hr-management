<?php

namespace App\Livewire\Admin\Office;

use Livewire\Component;
use App\Models\OfficeBranch;
use App\Traits\HasDeleteConfirmation;

class OfficeBranches extends Component
{

    use HasDeleteConfirmation;

    public $branches;
    public $branch_name, $branch_code, $address, $city, $division, $phone, $email, $status = 'Active';
    public $branchId = null;
    public $showModal = false;

    public function rules()
    {
        return [
            'branch_name' => 'required|string|max:255',
            'branch_code' => 'required|string|max:50|unique:office_branches,branch_code,' . ($this->branchId ?? 'NULL') . ',id',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'division' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:Active,Inactive',
        ];
    }


    public function mount()
    {
        $this->loadBranches();
    }

    public function loadBranches()
    {
        $this->branches = OfficeBranch::orderBy('id', 'desc')->get();
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->resetExcept(['branches']);
        $this->showModal = true;

        if ($id) {
            $branch = OfficeBranch::findOrFail($id);
            $this->branchId = $branch->id;
            $this->branch_name = $branch->branch_name;
            $this->branch_code = $branch->branch_code;
            $this->address = $branch->address;
            $this->city = $branch->city;
            $this->division = $branch->division;
            $this->phone = $branch->phone;
            $this->email = $branch->email;
            $this->status = $branch->status;
        }
    }


    public function saveBranch()
    {
        $this->validate();

        OfficeBranch::updateOrCreate(
            ['id' => $this->branchId],
            [
                'branch_name' => $this->branch_name,
                'branch_code' => $this->branch_code,
                'address' => $this->address,
                'city' => $this->city,
                'division' => $this->division,
                'phone' => $this->phone,
                'email' => $this->email,
                'status' => $this->status,
            ]
        );

        $this->showModal = false;
        $this->reset(['branch_name', 'branch_code', 'address', 'city', 'division', 'phone', 'email', 'status', 'branchId']);
        $this->loadBranches();

        $this->dispatch('toastMagic', 
            status: 'success', 
            title: 'Branch Saved', 
            message: 'Office branch information saved successfully.'
        );
    }


     protected function performDelete(int $id)
    {
        OfficeBranch::findOrFail($id)->delete();
        $this->loadBranches();

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'Branch Deleted',
            message: 'Branch deleted successfully.',
            options: ['showCloseBtn' => true]
        );
    }

    public function render()
    {
        return view('livewire.admin.office.office-branches');
    }
    
}
