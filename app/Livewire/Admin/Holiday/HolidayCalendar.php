<?php

namespace App\Livewire\Admin\Holiday;

use Livewire\Component;
use App\Models\Holiday;
use App\Models\WeeklyHoliday;
use Carbon\Carbon;

class HolidayCalendar extends Component
{
    public $month;
    public $year;

    public function mount()
    {
        $this->month = now()->month;
        $this->year  = now()->year;
    }

    public function previousMonth()
    {
        $date = Carbon::create($this->year, $this->month)->subMonth();
        $this->month = $date->month;
        $this->year  = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->year, $this->month)->addMonth();
        $this->month = $date->month;
        $this->year  = $date->year;
    }

    public function render()
    {
        $start = Carbon::create($this->year, $this->month)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        /* ---------------- PUBLIC HOLIDAYS ---------------- */
        $holidays = Holiday::whereDate('from_date', '<=', $end)
            ->whereDate('to_date', '>=', $start)
            ->get();

        /* ---------------- WEEKLY HOLIDAYS ---------------- */
        $weeklyHolidays = WeeklyHoliday::where('is_active', true)
            ->pluck('day_number')
            ->toArray();

        /* ---------------- BUILD CALENDAR DAYS ---------------- */
        $calendarDays = [];

        for ($day = 1; $day <= $start->daysInMonth; $day++) {
            $date = Carbon::create($this->year, $this->month, $day);

            $isWeeklyHoliday = in_array($date->dayOfWeek, $weeklyHolidays);

            $holidayForDay = $holidays->filter(function ($holiday) use ($date) {
                return $date->between(
                    Carbon::parse($holiday->from_date),
                    Carbon::parse($holiday->to_date)
                );
            });

            $calendarDays[] = [
                'date'            => $date,
                'is_weekly'       => $isWeeklyHoliday,
                'holidays'        => $holidayForDay,
                'is_holiday'      => $isWeeklyHoliday || $holidayForDay->isNotEmpty(),
            ];
        }

        return view('livewire.admin.holiday.holiday-calendar', [
            'days'         => $calendarDays,
            'startDay'    => $start->dayOfWeek,
            'monthName'   => $start->format('F'),
            'year'        => $this->year,
        ]);
    }
}
