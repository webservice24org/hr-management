<?php

namespace App\Exports;

use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf;

class DepartmentsPdfExport
{
    protected $ids;

    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }

    public function generate()
    {
        $query = Department::query()
            ->leftJoin('users as creators', 'departments.created_by', '=', 'creators.id')
            ->leftJoin('users as updaters', 'departments.updated_by', '=', 'updaters.id')
            ->select(
                'departments.id',
                'departments.uuid',
                'departments.department_name',
                'departments.status',
                'creators.name as created_by_name',
                'updaters.name as updated_by_name',
                'departments.created_at',
                'departments.updated_at'
            );

        if (!empty($this->ids)) {
            $query->whereIn('departments.id', $this->ids);
        }

        $departments = $query->get()->map(fn($dept) => [
            'id' => $dept->id,
            'uuid' => $dept->uuid,
            'department_name' => $dept->department_name,
            'status' => ucfirst($dept->status),
            'created_by_name' => $dept->created_by_name ?? '-',
            'updated_by_name' => $dept->updated_by_name ?? '-',
            'created_at' => optional($dept->created_at)->format('Y-m-d H:i:s') ?? '-',
            'updated_at' => optional($dept->updated_at)->format('Y-m-d H:i:s') ?? '-',
        ])->toArray();

        return Pdf::loadView('exports.departments-pdf', ['departments' => $departments])
                  ->download('departments.pdf');
    }
}
