<div class="space-y-6">

    {{-- FORM --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4">
            {{ $leaveTypeId ? 'Edit Leave Type' : 'Add Leave Type' }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="font-semibold">Leave Type</label>
                <input type="text"
                       wire:model.defer="leave_type"
                       class="w-full border rounded p-2">
                @error('leave_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="font-semibold">Leave Days</label>
                <input type="number"
                       wire:model.defer="leave_days"
                       class="w-full border rounded p-2">
                @error('leave_days') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-3 mt-6">
                <input type="checkbox" wire:model="is_active">
                <label class="font-semibold">Active</label>
            </div>
        </div>

        <div class="mt-4 flex gap-3">
            <button wire:click="save"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Save
            </button>

            @if($leaveTypeId)
                <button wire:click="resetForm"
                        class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Cancel
                </button>
            @endif
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4">Leave Types</h2>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="border p-2">#</th>
                    <th class="border p-2">Leave Type</th>
                    <th class="border p-2">Days</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($leaveTypes as $leave)
                    <tr>
                        <td class="border p-2">{{ $loop->iteration }}</td>
                        <td class="border p-2">{{ $leave->leave_type }}</td>
                        <td class="border p-2">{{ $leave->leave_days }}</td>
                        <td class="border p-2">
                            <span class="px-2 py-1 rounded text-xs
                                {{ $leave->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $leave->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="border p-2 text-center space-x-2">
                            <button wire:click="edit({{ $leave->id }})"
                                    class="text-blue-600 hover:underline">
                                Edit
                            </button>

                            <button wire:click="toggle({{ $leave->id }})"
                                    class="text-yellow-600 hover:underline">
                                Toggle
                            </button>

                            <button wire:click="delete({{ $leave->id }})"
                                    class="text-red-600 hover:underline"
                                    onclick="confirm('Delete this leave type?') || event.stopImmediatePropagation()">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-500">
                            No leave types found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
