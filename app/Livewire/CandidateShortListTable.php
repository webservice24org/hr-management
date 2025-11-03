<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\CandidateShortlist;
use Illuminate\Database\Eloquent\Builder;

class CandidateShortListTable extends DataTableComponent
{
  // protected $model = CandidateShortlist::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
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
            Column::make("Candidate apply id", "candidate_apply_id") ->sortable(),
            Column::make('Candidate', 'candidate.first_name')
            ->format(fn($value, $row) => $row->candidate ? $row->candidate->first_name . ' ' . $row->candidate->last_name : '-')
            ->sortable(),
            Column::make("Interview date", "interview_date")
                ->sortable(),
            Column::make('Listed by', 'listedBy.name')
                ->sortable(),
            Column::make('Actions', 'id')
            ->label(fn($row) => view('livewire.admin.recruitment.partials.shortlist-actions', ['row' => $row]))
            ->html(),
        ];
    }
}
