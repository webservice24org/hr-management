<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Department;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DepartmentsExport; 
use Barryvdh\DomPDF\Facade\Pdf;

class DepartmentsTable extends DataTableComponent
{
    protected $model = Department::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchStatus(true);
        $this->setSearchPlaceholder('Search Departments...');
        $this->setBulkActions([
            'exportSelected' => 'Export to Excel',
            'pdfSelected' => 'Export to PDF',
        ]);
        
    }

    #[On('departments-updated')]
    public function refreshTable(): void
    {
        $this->resetPage(); 

    }


    public function builder(): Builder
    {
        return Department::query()
            ->leftJoin('users as creators', 'departments.created_by', '=', 'creators.id')
            ->leftJoin('users as updaters', 'departments.updated_by', '=', 'updaters.id')
            ->select(
                'departments.*',
                'creators.name as creator_name',
                'updaters.name as updater_name'
            );
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Uuid", "uuid")->sortable(),
            Column::make("Department name", "department_name")->sortable(),
            Column::make('Status', 'status')
                ->format(fn($value) => view('components.status-badge', ['status' => $value]))
                ->html(),

            // Use relationship for display, but use a DB column for sorting/search
            Column::make("Created by", "created_by")
                ->label(fn($row) => $row->creator?->name ?? '-')
                ->sortable(function(Builder $query, $direction) {
                    $query->join('users as creators', 'departments.created_by', '=', 'creators.id')
                          ->orderBy('creators.name', $direction)
                          ->select('departments.*');
                }),

            Column::make("Updated by", "updated_by")
                ->label(fn($row) => $row->updater?->name ?? '-')
                ->sortable(function(Builder $query, $direction) {
                    $query->join('users as updaters', 'departments.updated_by', '=', 'updaters.id')
                          ->orderBy('updaters.name', $direction)
                          ->select('departments.*');
                }),

            Column::make("Created at", "created_at")->sortable(),
            Column::make("Updated at", "updated_at")->sortable(),

            Column::make('Actions', 'id')
                ->label(fn($row) => view('livewire.admin.department.department-actions', ['department' => $row]))
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

        // Generate and download Excel file
        return Excel::download(new DepartmentsExport($selected), 'departments.xlsx');
    }

    public function pdfSelected()
    {
        $selected = $this->getSelected();

        if (empty($selected)) {
            $this->dispatch('toastMagic', status: 'error', title: 'No selection', message: 'Please select at least one record.');
            return;
        }

        $departments = \App\Models\Department::whereIn('id', $selected)->get();

        $pdf = Pdf::loadView('exports.departments-pdf', ['departments' => $departments]);
        return response()->streamDownload(fn() => print($pdf->output()), 'departments.pdf');
    }

}
