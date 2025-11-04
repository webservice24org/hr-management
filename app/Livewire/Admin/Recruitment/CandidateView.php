<?php

namespace App\Livewire\Admin\Recruitment;

use Livewire\Component;
use App\Models\CandidateInformation;
use App\Models\CandidateShortlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\CandidateShortlistedMail; // we’ll create this next
use App\Mail\CandidateRejectionMail;
use Illuminate\Support\Facades\DB;


class CandidateView extends Component
{
    public $candidate;
    public $showShortlistModal = false;
    public $showRejectModal = false;
    public $interview_date;

    public function mount($id)
    {
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

    // ==============================
    // SHORTLIST FUNCTIONS
    // ==============================
    public function openShortlistModal()
    {
        $this->interview_date = null;
        $this->showShortlistModal = true; 
    }

    public function saveShortlist()
    {
        $this->validate([
            'interview_date' => 'required|date|after_or_equal:today',
        ]);

        $exists = \App\Models\CandidateShortlist::where('candidate_apply_id', $this->candidate->candidate_apply_id)->exists();

        if ($exists) {
            $this->dispatch('toastMagic', 
                status:  'warning',
                title: 'Already Shortlisted',
                message:  'This application ID is already shortlisted.',
                options:  ['showCloseBtn' => true],
            );
            return;
        }

        // ✅ Create shortlist
        $shortlist = \App\Models\CandidateShortlist::create([
            'candidate_id' => $this->candidate->id,
            'candidate_apply_id' => $this->candidate->candidate_apply_id,
            'interview_date' => $this->interview_date,
            'listed_by' => Auth::id(),
        ]);

        // ✅ Update CandidateInformation status
        $this->candidate->update([
            'status' => 'Short Listed',
        ]);

        // ✅ Send email (optional)
        try {
            Mail::to($this->candidate->email)->send(new CandidateShortlistedMail($this->candidate, $shortlist));
        } catch (\Exception $e) {
            session()->flash('error', 'Shortlisted but email failed to send: ' . $e->getMessage());
        }

        // ✅ Toast success
        $this->dispatch('toastMagic',
                status: 'success',
                title: 'Candidate Shortlisted',
                message: 'Candidate shortlisted successfully with interview date.',
                options: ['showCloseBtn' => true]
            );

        // ✅ Refresh DataTable and UI
        $this->dispatch('shortlist-saved');

        $this->showShortlistModal = false;
        $this->reset('interview_date');
    }






    public function openRejectModal()
    {
        $this->showRejectModal = true;
    }

    public function rejectCandidate()
    {
        $this->validate([
            'candidate.id' => 'required'
        ]);

        DB::beginTransaction();

        try {
            // ✅ Update candidate status
            $this->candidate->update([
                'status' => 'Rejected',
            ]);

            DB::commit();

            // ✅ Send rejection email after DB commit
            try {
                Mail::to($this->candidate->email)
                    ->send(new CandidateRejectionMail($this->candidate));
            } catch (\Exception $e) {
                session()->flash('error', 'Candidate rejected, but email failed: ' . $e->getMessage());
            }

            // ✅ Toast success message
            $this->dispatch('toastMagic', 
                status:  'error',
                title:  'Candidate Rejected',
                message:  'Candidate rejected and status updated successfully.',
                options: ['showCloseBtn' => true],
            );

            $this->showRejectModal = false;

        } catch (\Exception $e) {
            DB::rollBack();

            // ❌ Toast error if failed
            $this->dispatch('toastMagic', 
                status:  'error',
                title:  'Error',
                message:  'Failed to reject candidate: ' . $e->getMessage(),
                options: ['showCloseBtn' => true],
            );
        }
    }



    public function render()
    {
        return view('livewire.admin.recruitment.candidate-view')
            ->title('Candidate Details');
    }
}
