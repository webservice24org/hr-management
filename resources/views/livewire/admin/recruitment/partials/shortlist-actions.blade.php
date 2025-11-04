<div class="flex gap-2">
    <a href="{{ route('admin.interview.manage', $row->candidate_id) }}"
    class="px-2 py-1 bg-green-800 text-white rounded hover:bg-green-900 text-sm">
    Interview
    </a>
 
      
    <a href="{{ route('admin.candidates.view', $row->candidate_id) }}"
       class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 hover:cursor-pointer text-sm">
       <i class="fas fa-eye"></i>
    </a>

    


    <button 
        x-data 
        @click="$dispatch('confirm-candidate-short-list-delete', { id: {{ $row->id }} })"
        class="px-2 py-1 bg-red-800 hover:bg-red-900 text-white rounded shadow">
        <i class="fas fa-trash"></i>
    </button>
</div>
