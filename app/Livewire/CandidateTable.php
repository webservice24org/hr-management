<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\CandidateInformation;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Builder;

class CandidateTable extends DataTableComponent
{
    //protected $model = CandidateInformation::class;

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
            Column::make("Apply id", "candidate_apply_id")
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
                ->format(fn($value, $row, Column $column) => '<img src="' . asset('storage/' . $value) . '" alt="Picture" width="50" height="50">')
                ->html(),
            Column::make('Status', 'status')
            ->format(function($value, $row) {
                if (!$row) return '-';

                $status = $row->status;

                $colors = [
                    'Pending'        => 'bg-gray-200 text-gray-800',
                    'Short Listed'   => 'bg-blue-200 text-blue-800',
                    'Rejected'       => 'bg-red-200 text-red-800',
                    'Waiting List'   => 'bg-yellow-200 text-yellow-800',
                    'Final Selected' => 'bg-green-200 text-green-800',
                ];

                $badgeColor = $colors[$status] ?? 'bg-gray-200 text-gray-800';

                return "<span class='px-2 py-1 rounded-full text-xs font-semibold $badgeColor'>$status</span>";
            })
            ->html()
            ->sortable(),

            Column::make('Actions', 'id')
                ->label(fn($row) => view('livewire.admin.recruitment.partials.candidate-actions', ['candidate' => $row]))
                ->html(),

        ];
    }
}
