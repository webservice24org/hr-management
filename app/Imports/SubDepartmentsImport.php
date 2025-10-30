<?php

namespace App\Imports;

use App\Models\SubDepartment;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class SubDepartmentsImport implements ToCollection, WithHeadingRow
{
    public $inserted = 0;
    public $skipped = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Skip if no department_id or sub_department_name
            if (empty($row['department_id']) || empty($row['sub_department_name'])) {
                $this->skipped++;
                continue;
            }

            $exists = SubDepartment::where('sub_department_name', $row['sub_department_name'])
                        ->where('department_id', $row['department_id'])
                        ->first();

            if ($exists) {
                $this->skipped++;
                continue;
            }

            SubDepartment::create([
                'uuid' => (string) Str::uuid(),
                'department_id' => $row['department_id'],
                'sub_department_name' => $row['sub_department_name'],
                'status' => 'active',
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $this->inserted++;
        }
    }
}
