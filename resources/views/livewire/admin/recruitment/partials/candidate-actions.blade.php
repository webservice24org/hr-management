<div class="flex space-x-2">
    
    <a href="{{ route('admin.candidates.view', $candidate->id) }}" 
        class="px-2 py-1 bg-blue-800 hover:bg-blue-900 text-white rounded shadow">
        <i class="fas fa-eye"></i>
    </a>
    

    <button 
        x-data 
        @click="$dispatch('confirm-candidate-delete', { id: {{ $candidate->id }} })"
        class="px-2 py-1 bg-red-800 hover:bg-red-900 text-white rounded shadow">
        <i class="fas fa-trash"></i>
    </button>

</div>
