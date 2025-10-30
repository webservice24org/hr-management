<?php

namespace App\Livewire\Admin\Employee;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\HasDeleteConfirmation;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\On;

class PositionManager extends Component
{
    use WithPagination, HasDeleteConfirmation, WithFileUploads;

    public $showModal = false;
    public $positionId;
    public $position_name;
    public $position_details;
    public $status = 'active';
    public $excelFile;

    protected $rules = [
        'position_name' => 'required|string|max:255',
        'position_details' => 'nullable|string',
        'status' => 'required|in:active,inactive',
    ];

    public function render()
    {
        return view('livewire.admin.employee.position-manager');
    }

    // ==========================
    // MODAL HANDLERS
    // ==========================

    public function create()
    {
        $this->reset(['positionId', 'position_name', 'position_details', 'status']);
        $this->showModal = true;
    }

    #[On('edit-position')]
    public function edit($id)
    {
        $position = Position::findOrFail($id);

        $this->positionId = $id;
        $this->position_name = $position->position_name;
        $this->position_details = $position->position_details;
        $this->status = $position->status;

        $this->showModal = true;
    }

#[On('confirm-position-delete')]
    public function handlePositiontDelete(int $id)
    {
        $this->confirmDelete($id);
    }


    // Handle actual deletion using HasDeleteConfirmation trait
    protected function performDelete(int $id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'position Deleted',
            message: 'position deleted successfully.',
            options: ['showCloseBtn' => true]
        );

        // Tell datatable to refresh
        $this->dispatch('position-updated');
    }

    // ==========================
    // SAVE
    // ==========================
    public function save()
    {
        $this->validate();

        $position = Position::updateOrCreate(
            ['id' => $this->positionId],
            [
                'uuid' => $this->positionId
                    ? Position::find($this->positionId)->uuid
                    : (string) Str::uuid(),
                'position_name' => $this->position_name,
                'position_details' => $this->position_details,
                'status' => $this->status,
                'created_by' => $this->positionId ? Position::find($this->positionId)->created_by : Auth::id(),
                'updated_by' => Auth::id(),
            ]
        );

        $this->dispatch('toastMagic',
            status: 'success',
            title: $this->positionId ? 'Position Updated' : 'Position Created',
            message: $this->positionId
                ? 'Position has been successfully updated.'
                : 'New position has been created successfully.',
            options: [
                'showCloseBtn' => true,
                'timeout' => 3000,
            ]
        );

        $this->dispatch('position-updated');

        $this->showModal = false;
        $this->reset(['positionId', 'position_name', 'position_details', 'status']);
    }
}
