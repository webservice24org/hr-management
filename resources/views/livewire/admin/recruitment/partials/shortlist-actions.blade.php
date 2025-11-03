<div class="flex gap-2">
    <a href="{{ route('admin.candidates.view', $row->candidate_id) }}"
       class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
       View
    </a>



    <button 
        class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
        Delete
    </button>
</div>
