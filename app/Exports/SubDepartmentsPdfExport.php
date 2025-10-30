<?php

namespace App\Exports;

use App\Models\SubDepartment;
use Barryvdh\DomPDF\Facade\Pdf;

class SubDepartmentsPdfExport
{
    protected $ids;

    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }

    public function generate()
    {
        $query = SubDepartment::query()
            ->leftJoin('departments', 'sub_departments.department_id', '=', 'departments.id')
            ->leftJoin('users as creators', 'sub_departments.created_by', '=', 'creators.id')
            ->leftJoin('users as updaters', 'sub_departments.updated_by', '=', 'updaters.id')
            ->select(
                'sub_departments.id',
                'sub_departments.uuid',
                'departments.department_name',
                'sub_departments.sub_department_name',
                'sub_departments.status',
                'creators.name as created_by_name',
                'updaters.name as updated_by_name',
                'sub_departments.created_at',
                'sub_departments.updated_at'
            );

        if (!empty($this->ids)) {
            $query->whereIn('sub_departments.id', $this->ids);
        }

        $subDepartments = $query->get()->map(function ($sub) {
            $sub->department_name = $sub->department_name ?? '-';
            $sub->sub_department_name = $sub->sub_department_name ?? '-';
            $sub->status = ucfirst($sub->status ?? 'Inactive');
            $sub->created_by_name = $sub->created_by_name ?? '-';
            $sub->updated_by_name = $sub->updated_by_name ?? '-';
            return $sub;
        });

        


        // ✅ Ensure UTF-8 encoding to prevent "Malformed UTF-8" error
        array_walk_recursive($subDepartments, function (&$value) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        });
        
        return Pdf::loadView('exports.sub-departments-pdf', ['subDepartments' => $subDepartments])
        ->download('sub_departments.pdf');

    }
}
