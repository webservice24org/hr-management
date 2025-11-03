<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\CandidateInformation;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Builder;

class CandidateTable extends DataTableComponent
{
    protected $model = CandidateInformation::class;

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
        return CandidateInformation::query()->with('position'); 
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Candidate apply id", "candidate_apply_id")
                ->sortable(),
            Column::make("Position", "position.position_name")
                ->sortable(),
            Column::make("First name", "first_name")
                ->sortable(),
            Column::make("Last name", "last_name")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Phone", "phone")
                ->sortable(),
            Column::make("Picture", "picture")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make('Actions', 'id')
                ->label(fn($row) => view('livewire.admin.recruitment.partials.candidate-actions', ['candidate' => $row]))
                ->html(),

        ];
    }
}
