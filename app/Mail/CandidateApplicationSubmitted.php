<?php

namespace App\Mail;

use App\Models\CandidateInformation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class CandidateApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;

    public function __construct(CandidateInformation $candidate)
    {
        $this->candidate = $candidate;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pdf.candidate-application', [
            'candidate' => $this->candidate
        ]);

        return $this->subject('Your Application Has Been Submitted Successfully!')
                    ->view('emails.candidate-application-submitted')
                    ->attachData(
                        $pdf->output(),
                        'Candidate_Application_' . $this->candidate->candidate_apply_id . '.pdf',
                        ['mime' => 'application/pdf']
                    );
    }
}
