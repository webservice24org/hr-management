<div class="space-y-8">

    {{-- FORM --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">
            {{ $isEdit ? 'Edit Holiday' : 'Add Holiday' }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text"
                   wire:model.defer="holiday_name"
                   placeholder="Holiday Name"
                   class="border rounded p-2">

            <input type="date"
                   wire:model.defer="from_date"
                   class="border rounded p-2">

            <input type="date"
                   wire:model.defer="to_date"
                   class="border rounded p-2">

            <button wire:click="save"
                    class="bg-green-600 text-white rounded px-4 py-2">
                {{ $isEdit ? 'Update' : 'Save' }}
            </button>
        </div>
    </div>

    {{-- LIST --}}
    <div class="bg-white rounded shadow">
        <table class="w-full border text-sm">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="border p-2">Holiday</th>
                    <th class="border p-2">From</th>
                    <th class="border p-2">To</th>
                    <th class="border p-2">Days</th>
                    <th class="border p-2">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($holidays as $holiday)
                    <tr>
                        <td class="border p-2">{{ $holiday->holiday_name }}</td>
                        <td class="border p-2">{{ $holiday->from_date->format('d M Y') }}</td>
                        <td class="border p-2">{{ $holiday->to_date->format('d M Y') }}</td>
                        <td class="border p-2 text-center font-bold">
                            {{ $holiday->total_days }}
                        </td>
                        <td class="border p-2 text-center">
                            <button wire:click="edit({{ $holiday->id }})"
                                    class="text-blue-600">Edit</button>
                            |
                            <button wire:click="delete({{ $holiday->id }})"
                                    class="text-red-600">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            No holidays found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
