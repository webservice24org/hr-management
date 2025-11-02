<div class="text-center py-10">
    <div class="bg-green-50 border border-green-200 rounded-md p-8 max-w-2xl mx-auto shadow">
        <i class="fa-solid fa-circle-check text-green-700 text-5xl mb-4"></i>
        <h1 class="text-2xl font-semibold text-green-800 mb-2">Application Submitted Successfully!</h1>

        <p class="text-gray-700 mb-2">
            Thank you <strong>{{ $candidate->first_name }} {{ $candidate->last_name }}</strong> for applying.
        </p>
        <p class="text-gray-700 mb-4">
            <strong>Application ID:</strong> {{ $candidate->candidate_apply_id }}<br>
            <strong>Position:</strong> {{ $candidate->position->position_name ?? '-' }}
        </p>

        <button wire:click="downloadPdf"
            class="bg-green-700 hover:bg-green-800 hover:cursor-pointer text-white px-5 py-2 rounded shadow transition">
            <i class="fa-solid fa-file-pdf"></i> Download Application (PDF)
        </button>

        <div class="mt-6">
            <a href="{{ route('frontend.candidate.apply') }}"
               class="text-blue-700 hover:underline text-sm">
               ← Apply for another position
            </a>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="mt-4 text-red-600">{{ session('error') }}</div>
    @endif
</div>
