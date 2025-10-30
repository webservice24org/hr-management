<div class="space-y-4">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 space-y-2 md:space-y-0">
        <!-- Left: Title -->
        <div>
            <h3 class="text-md font-semibold text-gray-800 dark:text-gray-100">Position List</h3>
        </div>

        <!-- Middle: Excel Upload + Template Download -->
        <div class="flex items-center gap-2">
            <input type="file" wire:model="excelFile" class="border p-1 rounded" />

            <button wire:click="importExcel"
                    wire:loading.attr="disabled"
                    wire:target="excelFile"
                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 shadow flex items-center gap-2 transition">
                <span wire:loading.remove wire:target="excelFile">Import Excel</span>
                <span wire:loading wire:target="excelFile">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </button>

            <button wire:click="downloadTemplate" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 shadow">
                Download Template
            </button>
        </div>

        <!-- Right: Add Position -->
        <div>
            <button wire:click="create"
                class="px-3 py-1 bg-green-800 text-white rounded-md hover:bg-green-900 shadow flex items-center gap-1">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Add Position</span>
            </button>
        </div>
    </div>

    <!-- Position Table -->
    <div class="data_table_wrapper">
        <livewire:position-table />
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div 
            x-data="{ show: @entangle('showModal') }" 
            x-show="show"
            x-transition
            class="fixed inset-0 z-50 flex items-start justify-center pt-20 bg-black/70 backdrop-blur-sm"
        >
            <div 
                x-show="show"
                x-transition
                @click.away="show = false"
                class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-1/3 p-6"
            >
                <button wire:click="$set('showModal', false)" 
                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-2xl font-bold">
                    &times;
                </button>

                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                    {{ $positionId ? 'Edit Position' : 'Add Position' }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position Name</label>
                        <input type="text" wire:model.defer="position_name"
                               class="mt-1 block w-full p-3 border border-gray-500 dark:border-gray-600 focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-gray-100">
                        @error('position_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position Details</label>
                        <textarea wire:model.defer="position_details"
                                  class="mt-1 block w-full p-3 border border-gray-500 dark:border-gray-600 focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-gray-100"></textarea>
                    </div>

                    <div class="mt-2 space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" wire:model="status" value="active" class="form-radio text-blue-600">
                            <span class="ml-2">Active</span>
                        </label>

                        <label class="inline-flex items-center">
                            <input type="radio" wire:model="status" value="inactive" class="form-radio text-red-600">
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
