<?php

namespace App\Imports;

use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class PositionsImport implements ToCollection, WithHeadingRow
{
    public $imported = 0;
    public $skipped = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $positionName = trim($row['position_name'] ?? '');

            if (empty($positionName)) {
                $this->skipped++;
                continue;
            }

            // Check for duplicate by name
            $existing = Position::where('position_name', $positionName)->first();

            if ($existing) {
                $this->skipped++;
                continue;
            }

            Position::create([
                'uuid' => (string) Str::uuid(),
                'position_name' => $positionName,
                'position_details' => $row['position_details'] ?? null,
                'status' => 'active',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            $this->imported++;
        }
    }
}
