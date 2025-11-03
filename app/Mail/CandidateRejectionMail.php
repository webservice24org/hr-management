<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CandidateInformation;

class CandidateRejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;

    /**
     * Create a new message instance.
     */
    public function __construct(CandidateInformation $candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Application Update – Thank You for Applying')
            ->markdown('emails.candidates.CandidateRejected')
            ->with([
                'candidate' => $this->candidate,
                'appName' => config('app.name'),
            ]);
    }
}
