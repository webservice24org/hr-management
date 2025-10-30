<div class="flex space-x-2">
    <!-- Edit Button -->
    <button 
        class="hover:cursor-pointer px-2 py-1 bg-green-800 hover:bg-green-900 text-white rounded "
        @click="$dispatch('edit-sub-department', { id: {{ $subDepartment->id }} })">
        <i class="fas fa-edit"></i>
    </button>

    <!-- Delete Button -->
    <button 
        class="hover:cursor-pointer px-2 py-1 bg-red-800 hover:bg-red-900 text-white rounded"
        @click="$dispatch('confirm-sub-department-delete', { id: {{ $subDepartment->id }}, eventName: 'deleteConfirmed' })">
        <i class="fas fa-trash"></i>
    </button>
</div>
