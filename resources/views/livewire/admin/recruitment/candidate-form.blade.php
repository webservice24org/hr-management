<div class=" mx-auto bg-white dark:bg-gray-900 shadow-md rounded-xl p-6">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">
        Candidate Registration Form
    </h2>

    {{-- Step Indicator --}}
    <div class="flex justify-between mb-6">
        <div class="flex-1 text-center {{ $step >= 1 ? 'font-bold text-green-700' : 'text-gray-400' }}">
            1️⃣ Basic Info
        </div>
        <div class="flex-1 text-center {{ $step >= 2 ? 'font-bold text-green-700' : 'text-gray-400' }}">
            2️⃣ Education
        </div>
        <div class="flex-1 text-center {{ $step >= 3 ? 'font-bold text-green-700' : 'text-gray-400' }}">
            3️⃣ Experience
        </div>
        <div class="flex-1 text-center {{ $preview ? 'font-bold text-green-700' : 'text-gray-400' }}">
            👁️ Preview
        </div>
    </div>

    {{-- Step 1: Basic Information --}}
    @if ($step === 1 && !$preview)
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>First Name</label>
                    <input type="text" wire:model="first_name" class="w-full border rounded p-2">
                    @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>Last Name</label>
                    <input type="text" wire:model="last_name" class="w-full border rounded p-2">
                    @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>Email</label>
                    <input type="email" wire:model="email" class="w-full border rounded p-2">
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>Phone</label>
                    <input type="text" wire:model="phone" class="w-full border rounded p-2">
                    @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>Alternative Phone</label>
                    <input type="text" wire:model="alternative_phone" class="w-full border rounded p-2">
                </div>

                <div>
                    <label>Position Applying For</label>
                    <select wire:model="position_id" class="w-full border rounded p-2 text-black dark:text-white">
                        <option value="" class="text-black dark:text-white dark:bg-gray-900">Select Position</option>
                        @foreach ($positions as $pos)
                            <option value="{{ $pos->id }}" class="text-black dark:text-white dark:bg-gray-900">{{ $pos->position_name }}</option>
                        @endforeach
                    </select>
                    @error('position_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="text-black dark:text-white dark:bg-gray-900">
                <label>Present Address</label>
                <textarea wire:model="present_address" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="text-black dark:text-white dark:bg-gray-900">
                <label>Permanent Address</label>
                <textarea wire:model="permanent_address" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="text-black dark:text-white dark:bg-gray-900">
                    <label>Division</label>
                    <input type="text" wire:model="division" class="w-full border rounded p-2">
                </div>
                <div class="text-black dark:text-white dark:bg-gray-900">
                    <label>City</label>
                    <input type="text" wire:model="city" class="w-full border rounded p-2">
                </div>
                <div class="text-black dark:text-white dark:bg-gray-900">
                    <label>Post Code</label>
                    <input type="number" wire:model="post_code" class="w-full border rounded p-2">
                </div>
            </div>

            <div>
                <label>Profile Picture</label>
                <input type="file" wire:model="picture" class="border rounded p-2">
                @if ($picture)
                    <img src="{{ $picture->temporaryUrl() }}" alt="Preview" class="mt-2 w-24 h-24 object-cover rounded-full">
                @endif
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button wire:click="nextStep" class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded">Next ➡️</button>
        </div>
    @endif

    {{-- Step 2: Education --}}
    @if ($step === 2 && !$preview)
        <div class="space-y-4">
            <h3 class="text-lg font-semibold">Educational Information</h3>

            @foreach ($educations as $index => $edu)
                <div class="border rounded-lg p-4 relative dark:bg-gray-900 ">
                    <button type="button" class="absolute top-2 right-2 text-red-600" wire:click="removeEducation({{ $index }})">✖</button>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label >Degree</label>
                            <select wire:model="educations.{{ $index }}.degree" class="w-full border rounded p-2 text-black dark:text-white dark:bg-gray-900">
                                <option value="">Select Degree</option>
                                <option value="SSC">SSC</option>
                                <option value="HSC">HSC</option>
                                <option value="Honours">Honours</option>
                                <option value="Masters">Masters</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="text-black dark:text-white ">
                            <label>Institution</label>
                            <input type="text" wire:model="educations.{{ $index }}.institution" class="w-full border rounded p-2">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-2 text-black dark:text-white dark:bg-gray-900">
                        <div>
                            <label>Result</label>
                            <input type="text" wire:model="educations.{{ $index }}.result" class="w-full border rounded p-2">
                        </div>
                        <div class="text-black dark:text-white dark:bg-gray-900">
                            <label>Comments</label>
                            <input type="text" wire:model="educations.{{ $index }}.comments" class="w-full border rounded p-2">
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="button" wire:click="addEducation" class="bg-blue-800 hover:bg-blue-900 text-white px-3 py-1 rounded">+ Add Education</button>
        </div>

        <div class="flex justify-between mt-6">
            <button wire:click="previousStep" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">⬅️ Previous</button>
            <button wire:click="nextStep" class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded">Next ➡️</button>
        </div>
    @endif

    {{-- Step 3: Experience --}}
    @if ($step === 3 && !$preview)
        <div class="space-y-4">
            <h3 class="text-lg font-semibold">Work Experience</h3>

            @foreach ($experiences as $index => $exp)
                <div class="border rounded-lg p-4 relative dark:bg-gray-900 text-black dark:text-white ">
                    <button type="button" class="absolute top-2 right-2 text-red-600" wire:click="removeExperience({{ $index }})">✖</button>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label>Company Name</label>
                            <input type="text" wire:model="experiences.{{ $index }}.company_name" class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label>Working Period</label>
                            <input type="text" wire:model="experiences.{{ $index }}.working_period" class="w-full border rounded p-2" placeholder="e.g. 2019-2023">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div>
                            <label>Duties</label>
                            <input type="text" wire:model="experiences.{{ $index }}.duties" class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label>Supervisor</label>
                            <input type="text" wire:model="experiences.{{ $index }}.supervisor" class="w-full border rounded p-2">
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="button" wire:click="addExperience" class="bg-blue-800 hover:bg-blue-900 text-white px-3 py-1 rounded">+ Add Experience</button>
        </div>

        <div class="flex justify-between mt-6">
            <button wire:click="previousStep" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">⬅️ Previous</button>
            <button wire:click="showPreview" class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded">Preview 👁️</button>
        </div>
    @endif

    {{-- Step 4: Preview --}}
    @if ($preview)
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Preview Candidate Details</h3>

            <div class="border rounded p-4">
                <p><strong>Name:</strong> {{ $first_name }} {{ $last_name }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Phone:</strong> {{ $phone }}</p>
                <p><strong>Position:</strong> {{ optional($positions->find($position_id))->position_name }}</p>
                <p><strong>City:</strong> {{ $city }}</p>
            </div>

            <div>
                <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">Education</h4>
                @foreach ($educations as $edu)
                    <p>- {{ $edu['degree'] ?? '' }} at {{ $edu['institution'] ?? '' }} ({{ $edu['result'] ?? '' }})</p>
                @endforeach
            </div>

            <div>
                <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">Experience</h4>
                @foreach ($experiences as $exp)
                    <p>- {{ $exp['company_name'] ?? '' }} ({{ $exp['working_period'] ?? '' }}) — {{ $exp['duties'] ?? '' }}</p>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button wire:click="editForm" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">✏️ Edit</button>
            <button wire:click="submit" class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded">✅ Submit</button>
        </div>
    @endif
</div>
