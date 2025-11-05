<?php

namespace App\Livewire;

use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubDepartmentsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class SubDepartmentTable extends DataTableComponent
{
    protected $model = SubDepartment::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setBulkActions([
            'exportSelected' => 'Export to Excel',
            'pdfSelected' => 'Export to PDF',
        ]);
    }

    #[On('sub-departments-updated')]
    public function refreshTable(): void
    {
        $this->resetPage();
    }

   public function builder(): Builder
    {
        return SubDepartment::query()
            ->leftJoin('departments', 'sub_departments.department_id', '=', 'departments.id')
            ->leftJoin('users as creators', 'sub_departments.created_by', '=', 'creators.id')
            ->leftJoin('users as updaters', 'sub_departments.updated_by', '=', 'updaters.id')
            ->select(
                'sub_departments.*',
                'departments.department_name',
                'creators.name as creator_name',
                'updaters.name as updater_name'
            );
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            
            Column::make("Department", "department_id")
                ->label(fn($row) => $row->department_name ?? '-')
                ->sortable(function(Builder $query, $direction) {
                    $query->join('departments', 'sub_departments.department_id', '=', 'departments.id')
                          ->orderBy('departments.department_name', $direction)
                          ->select('sub_departments.*');
                }),

            Column::make("Sub Department Name", "sub_department_name")->sortable(),

            Column::make('Status', 'status')
                ->format(fn($value) => view('components.status-badge', ['status' => $value]))
                ->html(),

            Column::make("Created by", "created_by")
                ->label(fn($row) => $row->creator_name ?? '-')
                ->sortable(function(Builder $query, $direction) {
                    $query->join('users as creators', 'sub_departments.created_by', '=', 'creators.id')
                          ->orderBy('creators.name', $direction)
                          ->select('sub_departments.*');
                }),

            Column::make("Updated by", "updated_by")
                ->label(fn($row) => $row->updater_name ?? '-')
                ->sortable(function(Builder $query, $direction) {
                    $query->join('users as updaters', 'sub_departments.updated_by', '=', 'updaters.id')
                          ->orderBy('updaters.name', $direction)
                          ->select('sub_departments.*');
                }),

            Column::make('Actions', 'id')
                ->label(fn($row) => view('livewire.admin.sub-department.sub-department-actions', ['subDepartment' => $row]))
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

        return Excel::download(new SubDepartmentsExport($selected), 'sub_departments.xlsx');
    }

    public function pdfSelected()
    {
        $selected = $this->getSelected();

        if (empty($selected)) {
            $this->dispatch('toastMagic', status: 'error', title: 'No selection', message: 'Please select at least one record.');
            return;
        }

        $subDepartments = \App\Models\SubDepartment::query()
            ->with([
                'department:id,department_name',
                'creator:id,name',
                'updater:id,name'
            ])
            ->whereIn('id', $selected)
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.sub-departments-pdf', [
            'subDepartments' => $subDepartments
        ]);

        return response()->streamDownload(fn() => print($pdf->output()), 'sub_departments.pdf');
    }



}
