<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">User List</h2>
        <input type="text" wire:model.debounce.300ms="search" placeholder="Search users..."
            class="border rounded px-3 py-1 dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring focus:ring-blue-500">
    </div>

    <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-black">All Users</h2>
            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    + New User
                </button>
            @endif
        </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border border-collapse border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-black text-left ">Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-black text-left ">Photo</th>
                    <th class="border border-gray-300 px-4 py-2 text-black text-left ">Email</th>
                    <th class="border border-gray-300 px-4 py-2 text-black text-left ">Roles</th>
                    <th class="border border-gray-300 px-4 py-2 text-black text-center ">Verification</th>
                    <th class="border border-gray-300 px-4 py-2 text-black text-center ">Status</th>
                    <th class="border border-gray-300 px-4 py-2 text-black text-center ">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2 text-black">{{ $user->name }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-black">
                            @if ($user->profile && $user->profile->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" class="w-10 h-10 rounded-full" alt="{{ $user->name }}">
                            @else
                                <span class=" w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                                    {{ $user->initials() }}
                                </span>
                            @endif

                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-black">{{ $user->email }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($user->roles->count())
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($user->roles as $role)
                                        <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-500 italic">No role</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            @if ($user->hasVerifiedEmail())
                                <span class="px-2 py-1 text-xs bg-green-600 text-white rounded">
                                    Verified
                                </span>
                            @else
                               <span class="px-2 py-1 text-xs bg-red-600 text-white rounded">
                                    need Verified
                                </span>
                            @endif
                        </td>

                        <td class="border border-gray-300 px-4 py-2 text-center">
                            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                                <button wire:click="toggleStatus({{ $user->id }})"
                                        class="px-3 py-1 rounded text-sm 
                                            {{ $user->is_active ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-400 hover:bg-gray-500 text-white' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            @else
                                <span class="text-xs {{ $user->is_active ? 'text-green-700' : 'text-red-500' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            @endif
                        </td>
                        

                        <td class="border border-gray-300 px-4 py-2 text-center">
                            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                                <button wire:click="edit({{ $user->id }})"
                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                                    Edit
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>

    

    {{-- Edit Modal --}}
    @if($showEditModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black/50">
            <div class="bg-white w-full max-w-lg rounded shadow-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-black">Edit User</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-black font-medium mb-1">Name</label>
                        <input type="text" wire:model.defer="name" class="w-full text-black text-blackw-full px-3 py-2 border rounded" />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-black font-medium mb-1">Email</label>
                        <input type="email" wire:model.defer="email" class="w-full text-black text-blackw-full px-3 py-2 border rounded" />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-black font-medium mb-1">Assign Roles</label>
                        <select wire:model="selectedRoles" multiple
                                class="w-full px-3 py-2 border rounded text-black">
                            @foreach($allRoles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button wire:click="resetForm" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button wire:click="updateUser" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Save
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showCreateModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black/50">
            <div class="bg-white w-full max-w-lg rounded shadow-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-black">Add New User</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-black mb-1">Name</label>
                        <input type="text" wire:model.defer="newName" class="w-full px-3 py-2 border rounded text-black">
                        @error('newName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-1">Email</label>
                        <input type="email" wire:model.defer="newEmail" class="w-full px-3 py-2 border rounded text-black">
                        @error('newEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-black mb-1">Password</label>
                            <input type="password" wire:model.defer="newPassword" class="w-full px-3 py-2 border rounded text-black">
                            @error('newPassword') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-black mb-1">Confirm Password</label>
                            <input type="password" wire:model.defer="newPasswordConfirmation" class="w-full px-3 py-2 border rounded text-black">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-1">Assign Roles</label>
                        <select wire:model="newSelectedRoles" multiple class="w-full px-3 py-2 border rounded text-black">
                            @foreach($allRoles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button wire:click="resetForm" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button wire:click="store" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Create
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
  
    window.Livewire.on('toast', ({ type, message }) => {
        showToast(type, message);
    });
</script>
@endpush
