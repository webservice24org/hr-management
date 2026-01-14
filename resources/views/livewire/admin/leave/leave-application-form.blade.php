<div class="max-w-7xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">

    <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">
        Leave Application Form
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- EMPLOYEE SELECT --}}
        <div>
            <label class="font-semibold">Employee</label>
            <select wire:model="employee_id"
                    class="w-full border rounded p-2">
                <option value="">-- Select Employee --</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">
                        {{ $emp->candidate->first_name }}
                        {{ $emp->candidate->last_name }}
                        ({{ $emp->national_id ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
            @error('employee_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>


        {{-- LEAVE TYPE --}}
        <div>
            <label class="font-semibold">Leave Type</label>
            <select wire:model="leave_type_id"
                    class="w-full border rounded p-2">
                <option value="">-- Select Leave Type --</option>
                @foreach($leaveTypes as $type)
                    <option value="{{ $type->id }}">
                        {{ $type->leave_type }} ({{ $type->leave_days }} days)
                    </option>
                @endforeach
            </select>
            @error('leave_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    {{-- FROM DATE --}}
    <div>
        <label class="font-semibold">From Date</label>
        <input type="date"
               wire:model="from_date"
               class="w-full border rounded p-2">
        @error('from_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- END DATE --}}
    <div>
        <label class="font-semibold">End Date</label>
        <input type="date"
               wire:model="end_date"
               class="w-full border rounded p-2">
        @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- TOTAL DAYS (AUTO) --}}
    <div>
        <label class="font-semibold">Total Days</label>
        <input type="number"
               wire:model="total_days"
               readonly
               class="w-full border rounded p-2 bg-gray-100">
    </div>

</div>


        {{-- FILE --}}
        <div class="md:col-span-2">
            <label class="font-semibold">Application Attachment</label>
            <input type="file"
                   wire:model="application_hard_copy"
                   class="w-full border rounded p-2">
            <p class="text-xs text-gray-500">jpg / png / pdf (Max 2MB)</p>
        </div>

        {{-- REASON --}}
        <div class="md:col-span-2">
            <label class="font-semibold">Reason</label>
            <textarea wire:model="reason"
                      rows="3"
                      class="w-full border rounded p-2"></textarea>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="mt-6 text-right">
        <button wire:click="submit"
                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            Submit Leave Application
        </button>
    </div>

</div>
