<?php

namespace App\Mail;

use App\Models\CandidateInformation;
use App\Models\CandidateShortlist;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateShortlistedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $shortlist;

    public function __construct(CandidateInformation $candidate, CandidateShortlist $shortlist)
    {
        $this->candidate = $candidate;
        $this->shortlist = $shortlist;
    }

    public function build()
    {
        return $this->subject('Congratulations! You Have Been Shortlisted')
            ->markdown('emails.candidates.shortlisted');
    }
}
