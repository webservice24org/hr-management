<?php

namespace App\Livewire\Admin\Holiday;

use Livewire\Component;
use App\Models\WeeklyHoliday;


class WeeklyHolidayManager extends Component
{
    public $day_name;
    public $day_number;
    public $is_active = false;
    public $weeklyHolidayId = null;

    protected $rules = [
        'day_name'   => 'required|string|max:20',
        'day_number' => 'required|integer|min:0|max:6|unique:weekly_holidays,day_number',
        'is_active'  => 'boolean',
    ];

    protected $validationAttributes = [
        'day_name' => 'Day Name',
        'day_number' => 'Day Number',
    ];

    public function save()
    {
        $rules = $this->rules;

        // Ignore unique rule when editing
        if ($this->weeklyHolidayId) {
            $rules['day_number'] =
                'required|integer|min:0|max:6|unique:weekly_holidays,day_number,' .
                $this->weeklyHolidayId;
        }

        $this->validate($rules);

        WeeklyHoliday::updateOrCreate(
            ['id' => $this->weeklyHolidayId],
            [
                'day_name'   => $this->day_name,
                'day_number' => $this->day_number,
                'is_active'  => $this->is_active,
            ]
        );

        $this->resetForm();

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Saved',
            message: 'Weekly holiday saved successfully.'
        );
    }

    public function edit($id)
    {
        $holiday = WeeklyHoliday::findOrFail($id);

        $this->weeklyHolidayId = $holiday->id;
        $this->day_name = $holiday->day_name;
        $this->day_number = $holiday->day_number;
        $this->is_active = $holiday->is_active;
    }

    public function toggle($id)
    {
        $holiday = WeeklyHoliday::findOrFail($id);
        $holiday->update(['is_active' => !$holiday->is_active]);
    }

    public function delete($id)
    {
        WeeklyHoliday::findOrFail($id)->delete();
    }

    public function resetForm()
    {
        $this->reset(['day_name', 'day_number', 'is_active', 'weeklyHolidayId']);
    }

    public function render()
    {
        return view('livewire.admin.holiday.weekly-holiday-manager', [
            'holidays' => WeeklyHoliday::orderBy('day_number')->get(),
        ]);
    }
}
