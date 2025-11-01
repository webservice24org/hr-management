<div class="text-center py-10">
    <div class="bg-green-100 border border-green-300 rounded-lg p-6 max-w-lg mx-auto">
        <i class="fa-solid fa-circle-check text-green-700 text-5xl mb-4"></i>
        <h2 class="text-2xl font-bold text-green-800 mb-2">Application Submitted Successfully!</h2>
        <p class="text-gray-700 mb-4">
            Thank you, {{ $candidate->first_name }}! Your application has been received.
        </p>

        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <p><strong>Application ID:</strong> {{ $candidate->candidate_apply_id }}</p>
            <p><strong>Position:</strong> {{ optional($candidate->position)->position_name }}</p>
            <p><strong>Email:</strong> {{ $candidate->email }}</p>
        </div>

        <button
            wire:click="downloadPdf"
            class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded shadow-md">
            <i class="fa-solid fa-file-pdf mr-2"></i> Download Application PDF
        </button>

        <div class="mt-6">
            <a href="/" class="text-blue-700 underline">← Back to Home</a>
        </div>
    </div>
</div>
