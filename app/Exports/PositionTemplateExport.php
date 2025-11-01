<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PositionTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Optional example rows for guidance (can be empty if you prefer)
        return [
            ['Software Engineer', 'Handles development and maintenance of software systems'],
            ['HR Executive', 'Responsible for HR operations and employee relations'],
            ['Marketing Specialist', 'Focuses on brand promotion and lead generation'],
            ['Finance Analyst', 'Monitors financial performance and budgeting'],
        ];
    }

    public function headings(): array
    {
        return [
            'position_name',       // mandatory
            'position_details',    // optional
        ];
    }
}
