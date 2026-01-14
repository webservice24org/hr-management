<?php

namespace App\Livewire\Admin\Holiday;


use Livewire\Component;
use App\Models\Holiday;

class HolidayManager extends Component
{
    public $holiday_id;
    public $holiday_name;
    public $from_date;
    public $to_date;

    public $isEdit = false;

    protected $rules = [
        'holiday_name' => 'required|string|max:255',
        'from_date'    => 'required|date',
        'to_date'      => 'required|date|after_or_equal:from_date',
    ];

    public function resetForm()
    {
        $this->reset(['holiday_id','holiday_name','from_date','to_date','isEdit']);
    }

    public function save()
    {
        $this->validate();

        Holiday::updateOrCreate(
            ['id' => $this->holiday_id],
            [
                'holiday_name' => $this->holiday_name,
                'from_date'    => $this->from_date,
                'to_date'      => $this->to_date,
            ]
        );

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Success',
            message: $this->isEdit ? 'Holiday updated.' : 'Holiday created.'
        );

        $this->resetForm();
    }

    public function edit($id)
    {
        $holiday = Holiday::findOrFail($id);

        $this->holiday_id   = $holiday->id;
        $this->holiday_name = $holiday->holiday_name;
        $this->from_date    = $holiday->from_date->format('Y-m-d');
        $this->to_date      = $holiday->to_date->format('Y-m-d');

        $this->isEdit = true;
    }

    public function delete($id)
    {
        Holiday::findOrFail($id)->delete();

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Deleted',
            message: 'Holiday removed.'
        );
    }

    public function render()
    {
        return view('livewire.admin.holiday.holiday-manager', [
            'holidays' => Holiday::orderBy('from_date')->get()
        ]);
    }
}
