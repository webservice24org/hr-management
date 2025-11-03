<?php

namespace App\Livewire\Admin\Recruitment;

use Livewire\Component;

class CandidateShortlist extends Component
{
    public function render()
    {
        return view('livewire.admin.recruitment.candidate-shortlist')
            ->title('Shortlisted Candidates');
    }
}
