<div class="p-6">
    <div class="flex justify-between items-center mb-4 border-b pb-2">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
            Shortlisted Candidates
        </h2>

        <a href="{{ route('admin.candidates.index') }}"
           class="px-3 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded">
           Back to Candidates
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow data_table_wrapper">
        <livewire:candidate-short-list-table />
    </div>

    
       
</div>