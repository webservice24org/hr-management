<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class DepartmentTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // No rows, just headers
        return [
            // Optionally add example rows
            // ['Example Department']
        ];
    }

    public function headings(): array
    {
        return [
            'Department Name',
        ];
    }
}
