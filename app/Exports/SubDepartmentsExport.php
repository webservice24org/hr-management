<?php

namespace App\Exports;

use App\Models\SubDepartment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class SubDepartmentsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    protected $ids;

    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }

    public function collection()
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

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'UUID',
            'Department Name',
            'Sub Department Name',
            'Status',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->uuid,
            $row->department_name,
            $row->sub_department_name,
            ucfirst($row->status),
            $row->created_by_name ?? '-',
            $row->updated_by_name ?? '-',
            $row->created_at,
            $row->updated_at,
        ];
    }
}
