<?php

namespace App\Livewire\Admin\Employee;

use Livewire\Component;
use App\Models\EmployeePerformance;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeePerformanceForm extends Component
{
    public $employee_id;
    public $overall_comment;
    public $is_locked = false;
    public $can_edit = false;
    public $employee;
    public $performance;



    public $sectionA = [
        [
            'label' => 'Demonstrated Knowledge of duties & Quality of Work',
            'rating' => null,
            'score' => 0,
            'comments' => '',
        ],
        [
            'label' => 'Timeliness of Delivery',
            'rating' => null,
            'score' => 0,
            'comments' => '',
        ],
        [
            'label' => 'Impact of Achievement',
            'rating' => null,
            'score' => 0,
            'comments' => '',
        ],
        [
            'label' => 'Overall Achievement of Goals/Objectives',
            'rating' => null,
            'score' => 0,
            'comments' => '',
        ],
        [
            'label' => 'Going beyond the call of Duty',
            'rating' => null,
            'score' => 0,
            'comments' => '',
        ],
    ];

    public $sectionB = [
        [
            'label' => 'Interpersonal skills & ability to work in a team environment',
            'rating' => null,
            'score' => 0,
            'comments' => '',
        ],
        [
            'label' => 'Attendance and Punctuality',
            'rating' => null,
            'score' => 0,
            'comments' => '',
        ],
    ];


    protected function ratingScoreA($rating)
    {
        return match ($rating) {
            'P'  => 0,
            'NI' => 3,
            'G'  => 6,
            'VG' => 9,
            'E'  => 12,
            default => 0,
        };
    }

    protected function ratingScoreB($rating)
    {
        return match ($rating) {
            'P'  => 2,
            'NI' => 4,
            'G'  => 6,
            'VG' => 9,
            'E'  => 10,
            default => 0,
        };
    }


    public function mount($employee_id)
    {
        $this->employee_id = $employee_id;
        

        $this->sectionA = [
            ['label' => 'Quality of Work', 'rating' => null, 'comments' => ''],
            ['label' => 'Job Knowledge', 'rating' => null, 'comments' => ''],
            ['label' => 'Productivity', 'rating' => null, 'comments' => ''],
        ];

        $this->sectionB = [
            ['label' => 'Attendance', 'rating' => null, 'comments' => ''],
            ['label' => 'Teamwork', 'rating' => null, 'comments' => ''],
        ];

        // 🔁 Load existing review (EDIT MODE)
        $performance = EmployeePerformance::where('employee_id', $employee_id)->first();
        $this->can_edit = auth()->user()?->hasRole('Super Admin');

        if ($performance) {
            $this->sectionA = $performance->section_a ?? $this->sectionA;
            $this->sectionB = $performance->section_b ?? $this->sectionB;
            $this->overall_comment = $performance->overall_comment;
            $this->is_locked = $performance->is_locked && !$this->can_edit;
        }

        $this->employee = Employee::with('information.department','candidate.interviews')
            ->findOrFail($employee_id);

        $this->performance = EmployeePerformance::where('employee_id', $employee_id)->first();

        

    }

    public function exportPdf()
        {
            $pdf = Pdf::loadView(
                'livewire.admin.employee.performance-pdf',
                [
                    'employee'    => $this->employee,
                    'performance' => $this->performance
                ]
            )->setPaper('a4', 'portrait');

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'Performance-Review-' . $this->employee->employee_code . '.pdf'
            );
        }

    

    public function updatedSectionA($value, $key)
{
    // Get index from key like "0.rating"
    [$index, $field] = explode('.', $key);

    if ($field === 'rating') {
        $this->sectionA[$index]['score'] = $this->ratingScoreA($value);
    }
}

public function updatedSectionB($value, $key)
{
    [$index, $field] = explode('.', $key);

    if ($field === 'rating') {
        $this->sectionB[$index]['score'] = $this->ratingScoreB($value);
    }
}



    /* ---------------- COMPUTED TOTALS ---------------- */

    public function getSectionATotalProperty()
    {
        return collect($this->sectionA)->sum('score');
    }

    public function getSectionBTotalProperty()
    {
        return collect($this->sectionB)->sum('score');
    }

    public function getTotalScoreProperty()
    {
        return $this->sectionATotal + $this->sectionBTotal;
    }


    /* ---------------- SAVE ---------------- */

    public function save()
{
    // 🚫 Normal users blocked if locked
    if ($this->is_locked && !$this->can_edit) {
        return;
    }

    EmployeePerformance::updateOrCreate(
        ['employee_id' => $this->employee_id],
        [
            'section_a' => $this->sectionA,
            'section_b' => $this->sectionB,
            'total_score' => $this->totalScore,
            'final_rating' => $this->finalRating(),
            'overall_comment' => $this->overall_comment,

            // 🔐 Only lock if NOT Super Admin
            'is_locked' => !$this->can_edit,
        ]
    );

    // Lock UI only for non-admin
    if (!$this->can_edit) {
        $this->is_locked = true;
    }

    $this->dispatch('toastMagic',
        status: 'success',
        title: 'Saved',
        message: $this->can_edit
            ? 'Performance updated by Super Admin.'
            : 'Performance saved and locked.'
    );
}


    private function finalRating()
    {
        return match (true) {
            $this->totalScore >= 90 => 'Excellent',
            $this->totalScore >= 75 => 'Very Good',
            $this->totalScore >= 60 => 'Good',
            default => 'Needs Improvement',
        };
    }

    public function render()
    {
        return view('livewire.admin.employee.employee-performance-form');
    }
}