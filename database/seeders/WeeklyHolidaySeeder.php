<?php

namespace Database\Seeders;
use App\Models\WeeklyHoliday;
use Illuminate\Database\Seeder;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WeeklyHolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            ['Sunday', 0],
            ['Monday', 1],
            ['Tuesday', 2],
            ['Wednesday', 3],
            ['Thursday', 4],
            ['Friday', 5],
            ['Saturday', 6],
        ];

        foreach ($days as [$name, $number]) {
            WeeklyHoliday::updateOrCreate(
                ['day_number' => $number],
                ['day_name' => $name, 'is_active' => false]
            );
        }
    }
}
