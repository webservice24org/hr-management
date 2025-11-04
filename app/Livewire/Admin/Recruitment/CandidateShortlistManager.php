<?php

namespace App\Livewire\Admin\Recruitment;

use Livewire\Component;
use App\Models\CandidateShortlist;
use Livewire\Attributes\On;
use App\Traits\HasDeleteConfirmation;

class CandidateShortlistManager extends Component
{
    use HasDeleteConfirmation;

    #[On('confirm-candidate-short-list-delete')]
    public function handleCandidateShortListDelete(int $id)
    {
        $this->confirmDelete($id);
    }

    protected function performDelete(int $id)
    {
        $candidate = CandidateShortlist::findOrFail($id);
        $candidate->delete();

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'Candidate Short List Deleted',
            message: 'Candidate Short List deleted successfully.',
            options: ['showCloseBtn' => true]
        );

        $this->dispatch('candidate-updated'); // Tell datatable to refresh
    }

    public function render()
    {
        return view('livewire.admin.recruitment.candidate-shortlist-manager');
    }
}
