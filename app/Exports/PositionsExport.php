<?php

namespace App\Exports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PositionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $ids;

    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $query = Position::query()
            ->leftJoin('users as creators', 'positions.created_by', '=', 'creators.id')
            ->leftJoin('users as updaters', 'positions.updated_by', '=', 'updaters.id')
            ->select(
                'positions.id',
                'positions.uuid',
                'positions.position_name',
                'positions.position_details',
                'positions.status',
                'creators.name as created_by_name',
                'updaters.name as updated_by_name',
                'positions.created_at',
                'positions.updated_at'
            );

        if (!empty($this->ids)) {
            $query->whereIn('positions.id', $this->ids);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'UUID',
            'Position Name',
            'Position Details',
            'Status',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At',
        ];
    }

    public function map($position): array
    {
        return [
            $position->id,
            $position->uuid,
            $position->position_name,
            $position->position_details ?? '-',
            ucfirst($position->status),
            $position->created_by_name ?? '-',
            $position->updated_by_name ?? '-',
            optional($position->created_at)->format('Y-m-d H:i:s') ?? '-',
            optional($position->updated_at)->format('Y-m-d H:i:s') ?? '-',
        ];
    }
}
