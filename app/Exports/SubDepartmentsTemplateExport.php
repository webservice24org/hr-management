<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubDepartmentsTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Example rows (optional: you can leave it empty)
        return [
            ['1', 'HR Support'],
            ['2', 'IT Operations'],
            ['1', 'Finance'],
            ['3', 'Marketing'],
        ];
    }

    public function headings(): array
    {
        return [
            'department_id',
            'sub_department_name',
        ];
    }
}
