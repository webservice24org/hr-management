
<!-- resources/views/livewire/admin/department/department-actions.blade.php -->
<div class="flex items-center gap-2 justify-center">
    <button 
        x-data 
        @click="$dispatch('edit-position', { id: {{ $position->id }} })"
        class="px-2 py-1 bg-green-800 hover:bg-green-900 hover:cursor-pointer text-white rounded shadow">
        <i class="fas fa-edit"></i>
    </button>
     
    <button 
        x-data 
       @click="$dispatch('confirm-position-delete', { id: {{ $position->id }} })"
        class="px-2 py-1 bg-red-800 hover:bg-red-900 hover:cursor-pointer text-white rounded shadow">
        <i class="fas fa-trash"></i>
    </button>

</div>


