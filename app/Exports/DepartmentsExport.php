<?php


namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartmentsExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct(array $ids = [])
    {
        $this->ids = $ids; // optionally pass selected IDs from your DataTable
    }

    public function collection()
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

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'UUID',
            'Department Name',
            'Status',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At',
        ];
    }
}
