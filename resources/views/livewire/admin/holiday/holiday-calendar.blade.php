<div class="p-6 bg-white rounded shadow">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <button wire:click="previousMonth">←</button>
        <h2 class="text-lg font-bold">{{ $monthName }} {{ $year }}</h2>
        <button wire:click="nextMonth">→</button>
    </div>

    {{-- DAYS HEADER --}}
    <div class="grid grid-cols-7 text-center font-semibold mb-2">
        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
            <div>{{ $day }}</div>
        @endforeach
    </div>

    {{-- CALENDAR --}}
    <div class="grid grid-cols-7 gap-1">
        {{-- EMPTY CELLS --}}
        @for ($i = 0; $i < $startDay; $i++)
            <div></div>
        @endfor

        {{-- DAYS --}}
        @foreach($days as $day)
            <div class="border p-2 text-sm rounded
                {{ $day['is_weekly'] ? 'bg-red-100' : '' }}
                {{ $day['holidays']->isNotEmpty() ? 'bg-green-100' : '' }}
            ">
                <div class="font-bold">{{ $day['date']->day }}</div>

                {{-- WEEKLY HOLIDAY --}}
                @if($day['is_weekly'])
                    <div class="text-xs text-red-700">
                        Weekly Holiday
                    </div>
                @endif

                {{-- PUBLIC HOLIDAYS --}}
                @foreach($day['holidays'] as $holiday)
                    <div class="text-xs text-green-700">
                        {{ $holiday->name }}
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

</div>
