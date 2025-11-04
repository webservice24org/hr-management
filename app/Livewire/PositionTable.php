<?php

namespace App\Livewire;

use App\Models\Position;
use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PositionsExport;
use App\Exports\PositionsPdfExport;
use Livewire\Attributes\On;


class PositionTable extends DataTableComponent
{
    protected $model = Position::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setBulkActions([
            'exportSelected' => 'Export to Excel',
        ]);
    }

    #[On('position-updated')]
    public function refreshTable(): void
    {
        $this->resetPage(); 

    }
    
    public function builder(): Builder
    {
        return Position::query()
            ->leftJoin('users as creators', 'positions.created_by', '=', 'creators.id')
            ->leftJoin('users as updaters', 'positions.updated_by', '=', 'updaters.id')
            ->select(
                'positions.*',
                'creators.name as creator_name',
                'updaters.name as updater_name'
            );
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Position name", "position_name")->sortable(),
            Column::make("Position details", "position_details")->sortable(),
            Column::make("Status", "status")
                ->format(fn($value) => view('components.status-badge', ['status' => $value]))
                ->html(),
            Column::make("Created by", "created_by")
                ->label(fn($row) => $row->creator_name ?? '-')
                ->sortable(function(Builder $query, $direction) {
                    $query->join('users as creators', 'positions.created_by', '=', 'creators.id')
                          ->orderBy('creators.name', $direction)
                          ->select('positions.*');
                }),
            Column::make("Updated by", "updated_by")
                ->label(fn($row) => $row->updater_name ?? '-')
                ->sortable(function(Builder $query, $direction) {
                    $query->join('users as updaters', 'positions.updated_by', '=', 'updaters.id')
                          ->orderBy('updaters.name', $direction)
                          ->select('positions.*');
                }),
            Column::make("Created at", "created_at")->sortable(),
            Column::make('Actions', 'id')
                ->label(fn($row) => view('livewire.admin.employee.position-actions', ['position' => $row]))
                ->html(),
        ];
    }



    public function exportSelected()
    {
        $selected = $this->getSelected();

        if (empty($selected)) {
            $this->dispatch('toastMagic', status: 'error', title: 'No selection', message: 'Please select at least one record.');
            return;
        }

        return Excel::download(new PositionsExport($selected), 'positions.xlsx');
    }

}
