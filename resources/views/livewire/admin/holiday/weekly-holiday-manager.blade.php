<div class="space-y-6">

    {{-- FORM --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">
            {{ $weeklyHolidayId ? 'Edit Weekly Holiday' : 'Add Weekly Holiday' }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="font-semibold">Day Name</label>
                <input type="text"
                       wire:model="day_name"
                       class="w-full border rounded p-2">
                @error('day_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="font-semibold">Day Number</label>
                <select wire:model="day_number" class="w-full border rounded p-2">
                    <option value="">-- Select --</option>
                    @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $i => $day)
                        <option value="{{ $i }}">{{ $day }} ({{ $i }})</option>
                    @endforeach
                </select>
                @error('day_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-2 mt-6">
                <input type="checkbox" wire:model="is_active">
                <label class="font-semibold">Active</label>
            </div>
        </div>

        <div class="mt-4 flex gap-2">
            <button wire:click="save"
                    class="bg-green-600 text-white px-5 py-2 rounded">
                Save
            </button>

            @if($weeklyHolidayId)
                <button wire:click="resetForm"
                        class="bg-gray-500 text-white px-5 py-2 rounded">
                    Cancel
                </button>
            @endif
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Weekly Holidays</h2>

        <table class="w-full border text-sm">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="border p-2">Day</th>
                    <th class="border p-2">Day Number</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($holidays as $holiday)
                <tr>
                    <td class="border p-2">{{ $holiday->day_name }}</td>
                    <td class="border p-2 text-center">{{ $holiday->day_number }}</td>
                    <td class="border p-2 text-center">
                        <span class="{{ $holiday->is_active ? 'text-green-600' : 'text-gray-500' }}">
                            {{ $holiday->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="space-x-2 text-center border p-2">
                        
                        <button
                            wire:click="edit({{ $holiday->id }})"
                            class="text-blue-600 hover:underline">
                            Edit
                        </button>

                        <button
                            wire:click="toggle({{ $holiday->id }})"
                            class="text-yellow-600 hover:underline">
                            {{ $holiday->is_active ? 'Disable' : 'Enable' }}
                        </button>

                        <button
                            wire:click="delete({{ $holiday->id }})"
                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                            class="text-red-600 hover:underline">
                            Delete
                        </button>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
