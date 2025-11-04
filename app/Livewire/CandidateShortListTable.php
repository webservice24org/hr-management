<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\CandidateShortlist;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class CandidateShortListTable extends DataTableComponent
{
    protected $model = CandidateShortlist::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    #[On('candidate-updated')]
    public function refreshTable(): void
    {
        $this->resetPage(); 

    }

    public function builder(): Builder
    {
        return CandidateShortlist::query()->with(['candidate', 'listedBy']); 
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Candidate id", "candidate_id")
                ->sortable(),

            Column::make("Candidate apply id", "candidate_apply_id")
                ->sortable(),

            Column::make("Interview date", "interview_date")
            ->sortable(),

            Column::make('Candidate', 'candidate.first_name')
            ->format(fn($value, $row) => $row->candidate ? $row->candidate->first_name . ' ' . $row->candidate->last_name : '-')
            ->sortable(),
            
            Column::make('Listed by', 'listedBy.name')
                ->sortable(),

            Column::make('Status', 'candidate.status')
            ->format(function($value, $row) {
                if (!$row->candidate) return '-';

                $status = $row->candidate->status;

                $colors = [
                    'Pending'        => 'bg-gray-200 text-gray-800',
                    'Short Listed'   => 'bg-blue-200 text-blue-800',
                    'Rejected'       => 'bg-red-200 text-red-800',
                    'Waiting List'   => 'bg-yellow-200 text-yellow-800',
                    'Final Selected' => 'bg-green-200 text-green-800',
                ];

                $badgeColor = $colors[$status] ?? 'bg-gray-200 text-gray-800';

                return "<span class='px-2 py-1 rounded-full text-xs font-semibold $badgeColor transition-colors duration-500 ease-in-out'>$status</span>";
            })
            ->html()
            ->sortable(),




            Column::make('Actions', 'id')
            ->label(fn($row) => view('livewire.admin.recruitment.partials.shortlist-actions', ['row' => $row]))
            ->html(),
        ];
    }
}
