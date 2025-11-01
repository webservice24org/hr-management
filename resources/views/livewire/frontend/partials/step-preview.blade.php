<div>
    <h3 class="text-xl font-semibold mb-4 text-green-800">Step 4: Review & Submit</h3>

    <div class="bg-gray-50 rounded p-4 mb-6">
        <h4 class="font-semibold text-lg mb-2 text-gray-700">Basic Information</h4>
        <p><strong>Name:</strong> {{ $first_name }} {{ $last_name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Phone:</strong> {{ $phone }}</p>
        <p><strong>Position:</strong> {{ optional($positions->find($position_id))->position_name }}</p>
    </div>

    <div class="bg-gray-50 rounded p-4 mb-6">
        <h4 class="font-semibold text-lg mb-2 text-gray-700">Education</h4>
        <ul class="list-disc ml-6">
            @foreach ($educations as $edu)
                <li>{{ $edu['degree'] }} - {{ $edu['institution'] }} ({{ $edu['result'] }})</li>
            @endforeach
        </ul>
    </div>

    <div class="bg-gray-50 rounded p-4 mb-6">
        <h4 class="font-semibold text-lg mb-2 text-gray-700">Work Experience</h4>
        <ul class="list-disc ml-6">
            @foreach ($experiences as $exp)
                <li>{{ $exp['company_name'] }} - {{ $exp['working_period'] }} ({{ $exp['duties'] }})</li>
            @endforeach
        </ul>
    </div>

    <div class="flex justify-between">
        <button wire:click="previousStep" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">← Edit</button>
        <button wire:click="submit" class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded">
            Submit Application
        </button>
    </div>
</div>
