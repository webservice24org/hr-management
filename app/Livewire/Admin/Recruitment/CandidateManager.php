<?php

namespace App\Livewire\Admin\Recruitment;

use Livewire\Component;
use App\Models\CandidateInformation;
use Livewire\WithPagination;
use App\Traits\HasDeleteConfirmation;
use Livewire\Attributes\On;
use Barryvdh\DomPDF\Facade\Pdf;

class CandidateManager extends Component
{
    use WithPagination, HasDeleteConfirmation;

    

    #[On('confirm-candidate-delete')]
    public function handleCandidateDelete(int $id)
    {
        $this->confirmDelete($id);
    }

    protected function performDelete(int $id)
{
    $candidate = CandidateInformation::findOrFail($id);

    // Delete picture from storage if it exists
    if ($candidate->picture && \Storage::disk('public')->exists($candidate->picture)) {
        \Storage::disk('public')->delete($candidate->picture);
    }

    // Delete the candidate record
    $candidate->delete();

    $this->dispatch('toastMagic',
        status: 'error',
        title: 'Candidate Deleted',
        message: 'Candidate deleted successfully.',
        options: ['showCloseBtn' => true]
    );

    $this->dispatch('candidate-updated'); // Tell datatable to refresh
}


    

    public function render()
    {
        return view('livewire.admin.recruitment.candidate-manager', [
            'candidates' => CandidateInformation::with('position')->latest()->get(),
        ]);
    }
}
