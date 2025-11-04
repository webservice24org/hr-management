<?php

namespace App\Livewire\Admin\Recruitment;

use Livewire\Component;
use App\Models\CandidateInformation;
use App\Models\CandidateInterview;
use App\Models\CandidateShortlist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\CandidateFinalSelectionMail;
use Illuminate\Support\Facades\Mail;

class CandidateInterviewManager extends Component
{
    public $candidate_id;
    public $position_id;
    public $interviewer;
    public $viva_marks=0;
    public $written_marks=0;
    public $mcq_marks=0;
    public $recommendation_note;
    public $selection;
    public $interviewer_comments;

    public $candidate;
    public $candidate_name;
    public $position_name;
    public $users = [];




public $total_marks = 0;

    protected $rules = [
        'interviewer' => 'required|exists:users,id',
        'viva_marks' => 'required|numeric|min:0',
        'written_marks' => 'nullable|numeric|min:0',
        'mcq_marks' => 'nullable|numeric|min:0',
        'recommendation_note' => 'nullable|string',
        'selection' => 'nullable|string|in:Final Selected,Rejected',
        'interviewer_comments' => 'nullable|string',
    ];

    public function mount($candidateId)
    {
        $this->candidate = CandidateInformation::with(['position', 'educations', 'experiences'])
            ->findOrFail($candidateId);

        $this->candidate_id   = $this->candidate->id;
        $this->position_id    = $this->candidate->position_id;
        $this->candidate_name = "{$this->candidate->first_name} {$this->candidate->last_name}";
        $this->position_name  = $this->candidate->position?->position_name ?? 'N/A';

        $this->users = User::select('id', 'name')->get();

        // ✅ Load interview data if it exists
        $interview = CandidateInterview::where('candidate_id', $candidateId)->first();
        if ($interview) {
            $this->interviewer          = $interview->interviewer;
            $this->viva_marks           = $interview->viva_marks;
            $this->written_marks        = $interview->written_marks;
            $this->mcq_marks            = $interview->mcq_marks;
            $this->total_marks          = $interview->total_marks;
            $this->recommendation_note  = $interview->recommendation_note;
            $this->selection            = $interview->selection;
            $this->interviewer_comments = $interview->interviewer_comments;
        }
    }


    // Automatically update total whenever marks change
    public function updated($property)
    {
        if (in_array($property, ['viva_marks', 'written_marks', 'mcq_marks'])) {
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $this->total_marks = 
            floatval($this->viva_marks ?? 0) + 
            floatval($this->written_marks ?? 0) + 
            floatval($this->mcq_marks ?? 0);
    }
    public function getTotalMarksProperty()
    {
        return collect([
            $this->viva_marks,
            $this->written_marks,
            $this->mcq_marks,
        ])->filter()->sum();
    }



        

    

    public function saveInterview()
    {
        $this->validate();
        $this->calculateTotal();

        // ✅ Save or update interview record
        $interview = CandidateInterview::updateOrCreate(
            ['candidate_id' => $this->candidate_id],
            [
                'interviewer' => $this->interviewer,
                'position_id' => $this->position_id,
                'interview_date' => now(),
                'viva_marks' => $this->viva_marks,
                'written_marks' => $this->written_marks,
                'mcq_marks' => $this->mcq_marks,
                'total_marks' => $this->total_marks,
                'recommendation_note' => $this->recommendation_note,
                'selection' => $this->selection,
                'interviewer_comments' => $this->interviewer_comments,
                'listed_by' => Auth::id(),
            ]
        );

        // ✅ Automatically update CandidateInformation status
        $candidate = CandidateInformation::find($this->candidate_id);

        if ($this->selection === 'Final Selected') {
            $candidate->update(['status' => 'Final Selected']);

            try {
                Mail::to($candidate->email)->send(new CandidateFinalSelectionMail($candidate));
            } catch (\Exception $e) {
                \Log::error('Failed to send Final Selection email: ' . $e->getMessage());
            }

        } elseif ($this->selection === 'Rejected') {
            $candidate->update(['status' => 'Rejected']);
        } elseif ($this->selection === 'Waiting List') {
            $candidate->update(['status' => 'Waiting List']);
        }

        // ✅ Success Toast
        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Interview Saved',
            message: 'Interview saved successfully!',
            options: ['showCloseBtn' => true]
        );

        return redirect()->route('admin.shortlists.view');
    }



    



    public function render()
    {
        return view('livewire.admin.recruitment.candidate-interview-manager');
    }
}
