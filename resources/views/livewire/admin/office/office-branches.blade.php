<div class="p-6 space-y-6 shadow-sm p-4 bg-white dark:bg-gray-800">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Office Branch Management</h2>
        <button wire:click="openModal" class="bg-green-700 hover:bg-green-800 hover:cursor-pointer text-white px-4 py-2 rounded-lg">
            + Add Branch
        </button>
    </div>

    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-3 text-left border">Branch Name</th>
                <th class="p-3 text-left border">Code</th>
                <th class="p-3 text-left border">City</th>
                <th class="p-3 text-left border">Division</th>
                <th class="p-3 text-left border">Status</th>
                <th class="p-3 text-center border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($branches as $branch)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 text-gray-800 border">{{ $branch->branch_name }}</td>
                    <td class="p-3 text-gray-800 border">{{ $branch->branch_code }}</td>
                    <td class="p-3 text-gray-800 border">{{ $branch->city ?? '-' }}</td>
                    <td class="p-3 text-gray-800 border">{{ $branch->division ?? '-' }}</td>
                    <td class="p-3 text-gray-800 border">
                        <span class="px-2 py-1 rounded text-sm font-medium
                            {{ $branch->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $branch->status }}
                        </span>
                    </td>
                    <td class="p-3 text-center space-x-2 border">
                        <button wire:click="openModal({{ $branch->id }})"
                            class="hover:cursor-pointer px-2 py-1 bg-green-800 hover:bg-green-900 text-white"><i class="fas fa-edit"></i></button>
                        
                        <button wire:click="confirmDelete({{ $branch->id }})"
                                class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-4 text-gray-800">No branches found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">
                    {{ $branchId ? 'Edit Branch' : 'Add New Branch' }}
                </h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-800">Branch Name *</label>
                        <input type="text" wire:model="branch_name" class="text-gray-800 w-full border rounded-lg p-2">
                        @error('branch_name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-800">Branch Code *</label>
                        <input type="text" wire:model="branch_code" class="text-gray-800 w-full border rounded-lg p-2">
                        @error('branch_code') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-800">City</label>
                            <input type="text" wire:model="city" class="text-gray-800 w-full border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800">Division</label>
                            <input type="text" wire:model="division" class="text-gray-800 w-full border rounded-lg p-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-800">Address</label>
                        <textarea wire:model="address" class="text-gray-800 w-full border rounded-lg p-2"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-800">Phone</label>
                            <input type="text" wire:model="phone" class="text-gray-800 w-full border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800">Email</label>
                            <input type="email" wire:model="email" class="text-gray-800 w-full border rounded-lg p-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-800">Status</label>
                        <select wire:model="status" class="w-full text-gray-800 border rounded-lg p-2">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-3">
                    <button wire:click="$set('showModal', false)"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 hover:cursor-pointer">Cancel</button>
                    <button wire:click="saveBranch"
                        class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 hover:cursor-pointer">
                        Save
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
