<div class="border-1 shadow-sm p-4 bg-white dark:bg-gray-800">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-md font-semibold text-gray-900 dark:text-gray-100">Sub Department List</h3>
        <button wire:click="create" class="px-3 py-1 bg-green-800 text-white rounded-md hover:bg-green-900 shadow">
            <i class="fa-solid fa-circle-plus"></i> Add Sub Department
        </button>
    </div>

    <!-- Datatable -->
     <div class="data_table_wrapper">

         <livewire:sub-department-table />
     </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-start justify-center pt-20 bg-black/60 backdrop-blur-sm transition-opacity duration-300">
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-1/3 p-6 transform transition-all duration-300 ease-out scale-100">
                <!-- Close -->
                <button wire:click="$set('showModal', false)" 
                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-xl">
                    &times;
                </button>

                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                    {{ $sub_departmentId ? 'Edit Sub Department' : 'Add Sub Department' }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Department</label>
                        <select wire:model="department_id" class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-100">
                            <option value="">-- Choose Department --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sub Department Name</label>
                        <input type="text" wire:model.defer="sub_department_name"
                               class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-100">
                        @error('sub_department_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-2 space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" wire:model="status" value="active" class="text-green-600">
                            <span class="ml-2">Active</span>
                        </label>

                        <label class="inline-flex items-center">
                            <input type="radio" wire:model="status" value="inactive" class="text-red-600">
                            <span class="ml-2">Inactive</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button wire:click="$set('showModal', false)"
                            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                        Cancel
                    </button>
                    <button wire:click="save"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Save
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
