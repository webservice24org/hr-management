<?php

namespace App\Imports;

use App\Models\Department;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DepartmentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $departmentName = trim($row['department_name'] ?? '');

            if (empty($departmentName)) {
                continue; // Skip empty rows
            }

            // Skip if department already exists
            if (Department::where('department_name', $departmentName)->exists()) {
                continue;
            }
            if (Department::whereRaw('LOWER(department_name) = ?', [strtolower($departmentName)])->exists()) {
                continue;
            }


            Department::create([
                'uuid' => (string) Str::uuid(),
                'department_name' => $departmentName,
                'status' => 'active', // default status
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
