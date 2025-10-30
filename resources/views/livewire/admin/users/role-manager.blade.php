<div class="container mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <div >
        <div class="px-6 py-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ __('Role Manager') }}</h2>
        </div>

        <div class="p-6 space-y-4">

        
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
                <div>
                    <input type="text" wire:model="name"
                           class="w-full px-4 py-2 border text-black dark:text-white border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500"
                           placeholder="Role name">
                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                @if($isEdit)
                <div class="mb-3">
                    <label class="text-black dark:text-white block text-md font-semibold mb-2">Permissions</label>

                    
                    <div class="mb-2">
                        <label class="text-black dark:text-white inline-flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox"
                                wire:click="toggleSelectAll"
                                :checked="allPermissionsSelected()"
                                class="rounded border-gray-300">
                            <span class="text-sm">Select All</span>
                        </label>
                    </div>

                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($permissions as $permission)
                            <label class="text-black dark:text-white flex items-center space-x-2">
                                <input type="checkbox"
                                    value="{{ $permission->id }}"
                                    wire:model="selectedPermissions"
                                    class="rounded border-gray-300 dark:text-white">
                                <span>{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif


                <div class="flex items-center space-x-2">
                    <button type="submit"
                            class="px-4 py-2 rounded text-white {{ $isEdit ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }}">
                        {{ $isEdit ? 'Update Role' : 'Add Role' }}
                    </button>

                    @if($isEdit)
                        <button type="button"
                                wire:click="resetForm"
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
            
            <hr class="border-t border-gray-300" />
            

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2 text-black border border-gray-300">Role</th>
                            <th class="px-4 py-2 text-black border border-gray-300">Permissions</th>
                            <th class="px-4 py-2 text-black border border-gray-300 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr class="">
                                <td class="px-4 py-2 text-black dark:text-white border border-gray-300 w-24">
                                    {{ $role->name }}
                                </td>

                                
                                <td class="px-4 py-2 text-sm border border-gray-300 w-70">
                                    @php
                                        $visiblePermissions = $role->permissions->take(3);
                                        $remainingCount = $role->permissions->count() - $visiblePermissions->count();
                                    @endphp

                                    @if ($role->permissions->count())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($visiblePermissions as $permission)
                                                <span class="inline-block px-2 py-1 text-xs bg-sky-800 dark:text-white text-blue-800 rounded">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach

                                            @if ($remainingCount > 0)
                                                <span class="inline-block px-2 py-1 text-xs bg-gray-200 dark:text-white text-gray-700 rounded">
                                                    +{{ $remainingCount }} more
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-500 italic">No permissions</span>
                                    @endif
                                </td>

                               
                                <td class="px-4 py-2 border border-gray-300 space-x-2 w-24 text-right">
                                    <button wire:click="edit({{ $role->id }})"
                                            class="px-3 py-1 bg-green-800 hover:bg-green-600 hover:cursor-pointer dark:text-white text-white rounded text-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $role->id }})"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>


                                </td>
                               
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>

        </div>
    </div>
</div>


