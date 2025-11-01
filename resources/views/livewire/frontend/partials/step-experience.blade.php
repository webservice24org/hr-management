<div>
    <h3 class="text-xl font-semibold mb-4 text-green-800">Step 3: Work Experience</h3>

    @foreach ($experiences as $index => $exp)
        <div class="border rounded p-4 mb-4 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-semibold text-gray-700">Experience #{{ $index + 1 }}</h4>
                @if ($index > 0)
                    <button wire:click="removeExperience({{ $index }})" class="text-red-600 hover:text-red-800">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="text-sm font-medium">Company Name</label>
                    <input type="text" wire:model="experiences.{{ $index }}.company_name" class="w-full border rounded p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Working Period</label>
                    <input type="text" wire:model="experiences.{{ $index }}.working_period" class="w-full border rounded p-2 mt-1" placeholder="e.g. 2018 - 2022">
                </div>
                <div>
                    <label class="text-sm font-medium">Duties</label>
                    <input type="text" wire:model="experiences.{{ $index }}.duties" class="w-full border rounded p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Supervisor</label>
                    <input type="text" wire:model="experiences.{{ $index }}.supervisor" class="w-full border rounded p-2 mt-1">
                </div>
            </div>
        </div>
    @endforeach

    <div class="flex justify-between mt-4">
        <button wire:click="previousStep" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">← Previous</button>
        <button wire:click="addExperience" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded">
            + Add Experience
        </button>
        <button wire:click="nextStep" class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded">
            Preview →
        </button>
    </div>
</div>
