<?php

namespace App\Mail;

use App\Models\CandidateInformation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateFinalSelectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;

    public function __construct(CandidateInformation $candidate)
    {
        $this->candidate = $candidate;
    }

    public function build()
    {
        return $this->subject('🎉 Congratulations! You Have Been Selected')
                    ->view('emails.candidates.candidate-final-selection')
                    ->with([
                        'name' => $this->candidate->first_name . ' ' . $this->candidate->last_name,
                        'position' => $this->candidate->position?->position_name ?? 'your applied position',
                    ]);
    }
}
