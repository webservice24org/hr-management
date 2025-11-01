<div>
    <h3 class="text-xl font-semibold mb-4 text-green-800">Step 2: Education Details</h3>

    @foreach ($educations as $index => $edu)
        <div class="border rounded p-4 mb-4 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-semibold text-gray-700">Education #{{ $index + 1 }}</h4>
                @if ($index > 0)
                    <button wire:click="removeEducation({{ $index }})" class="text-red-600 hover:text-red-800">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="text-sm font-medium">Degree</label>
                    <select wire:model="educations.{{ $index }}.degree" class="w-full border rounded p-2 mt-1">
                        <option value="">-- Select Degree --</option>
                        <option>SSC</option>
                        <option>HSC</option>
                        <option>Honours</option>
                        <option>Masters</option>
                        <option>Other Course</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium">Institution</label>
                    <input type="text" wire:model="educations.{{ $index }}.institution" class="w-full border rounded p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Result</label>
                    <input type="text" wire:model="educations.{{ $index }}.result" class="w-full border rounded p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Comments</label>
                    <input type="text" wire:model="educations.{{ $index }}.comments" class="w-full border rounded p-2 mt-1">
                </div>
            </div>
        </div>
    @endforeach

    <div class="flex justify-between mt-4">
        <button wire:click="previousStep" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">← Previous</button>
        <button wire:click="addEducation" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded">
            + Add Education
        </button>
        <button wire:click="nextStep" class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded">Next →</button>
    </div>
</div>
