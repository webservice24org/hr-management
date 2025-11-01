<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\CandidateInformation;
use Barryvdh\DomPDF\Facade\Pdf; // assuming you have barryvdh/laravel-dompdf installed

class CandidateSuccess extends Component
{
    public $candidate;

    public function mount($id)
    {
        $this->candidate = CandidateInformation::with(['educations', 'experiences'])
            ->findOrFail($id);
    }

    public function downloadPdf()
    {
        $pdf = Pdf::loadView('pdf.candidate-application', [
            'candidate' => $this->candidate
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Candidate_Application_' . $this->candidate->candidate_apply_id . '.pdf');
    }

    public function render()
    {
        return view('livewire.frontend.candidate-success')
            ->layout('layouts.frontend')
            ->title('Application Submitted');
    }
}
