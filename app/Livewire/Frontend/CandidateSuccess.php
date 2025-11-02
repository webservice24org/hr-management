<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\CandidateInformation;
use Barryvdh\DomPDF\Facade\Pdf;

class CandidateSuccess extends Component
{
    public $candidate;

    public function mount($id)
    {
        // Load candidate + relationships
        $this->candidate = CandidateInformation::with(['position', 'educations', 'experiences'])
            ->findOrFail($id);
    }

    public function downloadPdf()
    {
        try {
            $pdf = Pdf::loadView('pdf.candidate-application', [
                'candidate' => $this->candidate
            ])->setPaper('a4');

            return response()->streamDownload(
                fn() => print($pdf->output()),
                'Candidate_Application_' . $this->candidate->candidate_apply_id . '.pdf'
            );
        } catch (\Exception $e) {
            session()->flash('error', 'Unable to generate PDF: ' . $e->getMessage());
            return back();
        }
    }

    public function render()
    {
        return view('livewire.frontend.candidate-success')
            ->layout('layouts.frontend')
            ->title('Application Submitted');
    }
}
