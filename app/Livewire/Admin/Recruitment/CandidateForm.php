<?php

namespace App\Livewire\Admin\Recruitment;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CandidateInformation;
use App\Models\CandidateEducation;
use App\Models\CandidateWorkExperience;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CandidateForm extends Component
{
    use WithFileUploads;

    // Step control
    public $step = 1;

    // Candidate info fields
    public $candidate_apply_id;
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

    // Dynamic education and experience arrays
    public $educations = [];
    public $experiences = [];

    // For preview data
    public $preview = false;

    protected $rules = [
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'position_id' => 'required|exists:positions,id',
        'picture' => 'nullable|image|max:2048',
    ];

    public function render()
    {
        $positions = Position::where('status', 'active')->get();
        return view('livewire.admin.recruitment.candidate-form', compact('positions'));
    }

    // ============================
    // Step Navigation
    // ============================

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validateOnly('first_name');
            $this->validateOnly('email');
        }
        $this->step++;
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    // ============================
    // Dynamic Education Handlers
    // ============================

    public function addEducation()
    {
        $this->educations[] = [
            'degree' => '',
            'institution' => '',
            'result' => '',
            'comments' => '',
        ];
    }

    public function removeEducation($index)
    {
        unset($this->educations[$index]);
        $this->educations = array_values($this->educations);
    }

    // ============================
    // Dynamic Experience Handlers
    // ============================

    public function addExperience()
    {
        $this->experiences[] = [
            'company_name' => '',
            'working_period' => '',
            'duties' => '',
            'supervisor' => '',
        ];
    }

    public function removeExperience($index)
    {
        unset($this->experiences[$index]);
        $this->experiences = array_values($this->experiences);
    }

    // ============================
    // Preview & Submit
    // ============================

    public function showPreview()
    {
        $this->preview = true;
    }

    public function editForm()
    {
        $this->preview = false;
        $this->step = 1;
    }

    public function submit()
    {
        $this->validate();

        $candidate = CandidateInformation::create([
            'candidate_apply_id' => rand(0, 20),
            //'uuid' => Str::uuid(),
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
            'status' => 'active',
            'created_by' => Auth::id(),
        ]);

        if ($this->picture) {
            $path = $this->picture->store('candidate_pictures', 'public');
            $candidate->update(['picture' => $path]);
        }

        // Save Education Info
        foreach ($this->educations as $edu) {
            CandidateEducation::create([
                'candidate_id' => $candidate->id,
                'degree' => $edu['degree'] ?? '',
                'institution' => $edu['institution'] ?? '',
                'result' => $edu['result'] ?? '',
                'comments' => $edu['comments'] ?? '',
            ]);
        }

        // Save Experience Info
        foreach ($this->experiences as $exp) {
            CandidateWorkExperience::create([
                'candidate_id' => $candidate->id,
                'company_name' => $exp['company_name'] ?? '',
                'working_period' => $exp['working_period'] ?? '',
                'duties' => $exp['duties'] ?? '',
                'supervisor' => $exp['supervisor'] ?? '',
            ]);
        }

        $this->resetExcept('step');
        $this->dispatch('toastMagic', status: 'success', title: 'Candidate Saved', message: 'Candidate information saved successfully!');
        $this->step = 1;
    }
}
