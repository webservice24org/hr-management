<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CandidateInformation;
use App\Models\CandidateEducation;
use App\Models\CandidateWorkExperience;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Mail\CandidateApplicationSubmitted;
use Illuminate\Support\Facades\Mail;


class CandidateApplication extends Component
{
    use WithFileUploads;

    // Step navigation
    public $step = 1;

    // Candidate info
    public $position_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $alternative_phone;
    public $present_address;
    public $permanent_address;
    public $division;
    public $city;
    public $post_code;
    public $picture;

    // Dynamic Education & Experience
    public $educations = [];
    public $experiences = [];

    // Preview state
    public $showPreview = false;

    protected $rules = [
        'position_id' => 'required|exists:positions,id',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'present_address' => 'required|string|max:500',
        'permanent_address' => 'required|string|max:500',
        'division' => 'required|string|max:100',
        'city' => 'required|string|max:100',
        'post_code' => 'required|integer',
        'picture' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->educations = [
            ['degree' => '', 'institution' => '', 'result' => '', 'comments' => '']
        ];

        $this->experiences = [
            ['company_name' => '', 'working_period' => '', 'duties' => '', 'supervisor' => '']
        ];
    }

    public function render()
    {
        return view('livewire.frontend.candidate-application', [
            'positions' => \App\Models\Position::where('status', 'active')->get(),
        ])->layout('layouts.frontend')->title('Apply Now');
    }

    // Step Controls
    public function nextStep()
    {
        if ($this->step < 3) {
            $this->step++;
        } else {
            $this->showPreview = true;
        }
    }

    public function previousStep()
    {
        if ($this->showPreview) {
            $this->showPreview = false;
        } elseif ($this->step > 1) {
            $this->step--;
        }
    }

    // Dynamic add/remove
    public function addEducation()
    {
        $this->educations[] = ['degree' => '', 'institution' => '', 'result' => '', 'comments' => ''];
    }

    public function removeEducation($index)
    {
        unset($this->educations[$index]);
        $this->educations = array_values($this->educations);
    }

    public function addExperience()
    {
        $this->experiences[] = ['company_name' => '', 'working_period' => '', 'duties' => '', 'supervisor' => ''];
    }

    public function removeExperience($index)
    {
        unset($this->experiences[$index]);
        $this->experiences = array_values($this->experiences);
    }

    // Final submit
    public function submit()
    {
        $this->validate();

        // Save picture
        $picturePath = $this->picture ? $this->picture->store('candidate_photos', 'public') : null;

        $candidate = CandidateInformation::create([
            'candidate_apply_id' => rand(1000, 9999),
            //'uuid' => (string) Str::uuid(),
            'position_id' => $this->position_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'alternative_phone' => $this->alternative_phone,
            'present_address' => $this->present_address,
            'permanent_address' => $this->permanent_address,
            'division' => $this->division,
            'city' => $this->city,
            'post_code' => $this->post_code,
            'picture' => $picturePath,
        ]);

        foreach ($this->educations as $edu) {
            CandidateEducation::create([
                'candidate_id' => $candidate->id,
                'degree' => $edu['degree'],
                'institution' => $edu['institution'],
                'result' => $edu['result'],
                'comments' => $edu['comments'],
            ]);
        }

        foreach ($this->experiences as $exp) {
            CandidateWorkExperience::create([
                'candidate_id' => $candidate->id,
                'company_name' => $exp['company_name'],
                'working_period' => $exp['working_period'],
                'duties' => $exp['duties'],
                'supervisor' => $exp['supervisor'],
            ]);
        }

        session()->flash('success', 'Your application has been submitted successfully!');
        $this->resetExcept('positions');
        Mail::to($candidate->email)->send(new CandidateApplicationSubmitted($candidate));
        //Mail::to($candidate->email)->queue(new CandidateApplicationSubmitted($candidate));
        return redirect()->route('candidate.success', ['id' => $candidate->id]);
    }
}
