<div class="mx-auto p-6 bg-accent-foreground dark:bg-gray-800">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Candidate Interview</h1>

    {{-- Candidate Info --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 bg-white shadow p-4 rounded-lg mb-6">
        {{-- Left: Candidate Photo + Basic Info (4 columns on large screens) --}}
        <div class="lg:col-span-4 flex flex-col items-center justify-center text-center border-r border-gray-200 lg:pr-4">
            @if($candidate->picture && file_exists(public_path('storage/' . $candidate->picture)))
                <img src="{{ asset('storage/' . $candidate->picture) }}" 
                    alt="Candidate Photo" 
                    class="w-28 h-28 rounded-full object-cover border-2 border-green-600 mb-3">
            @else
                <img src="{{ asset('images/default-avatar.png') }}" 
                    alt="No Photo" 
                    class="w-28 h-28 rounded-full object-cover border-2 border-gray-400 mb-3">
            @endif

            <p class="text-lg font-bold text-gray-800">{{ $candidate_name }}</p>
            <p class="text-gray-600">Position: {{ $position_name }}</p>
        </div>

        {{-- Right: Contact Information (8 columns on large screens) --}}
        <div class="lg:col-span-8 space-y-2">
            <h4 class="font-semibold text-sm uppercase border-b border-blue-700 pb-1 mb-2">Contact Information</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 text-gray-700 text-sm">
                <p><strong>Email:</strong> {{ $candidate->email }}</p>
                <p><strong>Phone:</strong> {{ $candidate->phone }}</p>
                <p><strong>Alt Phone:</strong> {{ $candidate->alternative_phone ?? '-' }}</p>
                <p><strong>City:</strong> {{ $candidate->city }}</p>
                <p><strong>Division:</strong> {{ $candidate->division }}</p>
                <p><strong>Post Code:</strong> {{ $candidate->post_code }}</p>
                <div class="sm:col-span-2">
                    <p><strong>Address:</strong> {{ $candidate->present_address }}</p>
                </div>
            </div>
        </div>
    </div>



    <div class="flex flex-col lg:flex-row gap-6 bg-white shadow mt-2">
        {{-- Education Section --}}
        <div class="w-full lg:w-1/2">
            <h3 class="text-lg font-semibold text-gray-700 border-b-2 border-blue-700 pb-1 mb-3 flex items-center">
                🎓 Education
            </h3>
            @if($candidate->educations->count())
                <table class="min-w-full text-sm border border-gray-300 overflow-hidden">
                    <thead class="bg-blue-900 text-white text-left">
                        <tr>
                            <th class="border py-2 px-3">Degree</th>
                            <th class="border py-2 px-3">Institution</th>
                            <th class="border py-2 px-3">Result</th>
                            <th class="border py-2 px-3">Comments</th>
                        </tr>
                    </thead>
                    <tbody class="divide-gray-200">
                        @foreach($candidate->educations as $edu)
                            <tr>
                                <td class="border py-2 px-3 font-medium text-gray-800">{{ $edu->degree }}</td>
                                <td class="border py-2 px-3 text-gray-800">{{ $edu->institution }}</td>
                                <td class="border py-2 px-3 text-gray-800">{{ $edu->result }}</td>
                                <td class="border py-2 px-3 text-gray-800">{{ $edu->comments ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No education information provided.</p>
            @endif
        </div>

        {{-- Work Experience Section --}}
        <div class="w-full lg:w-1/2">
            <h3 class="text-lg font-semibold text-gray-700 border-b-2 border-green-700 pb-1 mb-3 flex items-center ">
                💼 Work Experience
            </h3>
            @if($candidate->experiences->count())
                <table class="min-w-full text-sm border border-gray-300 overflow-hidden">
                    <thead class="bg-green-800 text-white text-left">
                        <tr>
                            <th class="border py-2 px-3">Company Name</th>
                            <th class="border py-2 px-3">Working Period</th>
                            <th class="border py-2 px-3">Duties</th>
                            <th class="border py-2 px-3">Supervisor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-gray-200">
                        @foreach($candidate->experiences as $exp)
                            <tr>
                                <td class="border py-2 px-3 font-medium text-gray-800">{{ $exp->company_name }}</td>
                                <td class="border py-2 px-3 text-gray-800">{{ $exp->working_period }}</td>
                                <td class="border py-2 px-3 text-gray-800">{{ $exp->duties }}</td>
                                <td class="border py-2 px-3 text-gray-800">{{ $exp->supervisor }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No work experience provided.</p>
            @endif
        </div>
    </div>

    {{-- Form --}}
    <form wire:submit.prevent="saveInterview" class="shadow p-6 space-y-4 mt-2 bg-white">

        <div class="grid grid-cols-3 gap-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Viva Marks *</label>
            <input type="number" wire:model.live="viva_marks" min="0" step="0.01"
                class="w-full text-black p-1 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600">
            @error('viva_marks') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Written Marks</label>
            <input type="number" wire:model.live="written_marks" min="0" step="0.01"
                class="w-full text-black p-1 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">MCQ Marks</label>
            <input type="number" wire:model.live="mcq_marks" min="0" step="0.01"
                class="w-full text-black p-1 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600">
        </div>
    </div>

    <div class="flex justify-end mt-2">
        <p class="text-gray-700 text-sm">
            Total Marks: <span class="font-bold">{{ $total_marks }}</span>
        </p>
    </div>


        <div class="flex gap-4">
            <!-- Interviewer (25%) -->
            <div class="w-1/4">
                <label class="block text-sm font-medium text-gray-800 mb-1">Interviewer</label>
                <select wire:model="interviewer"
                        class="w-full p-1 text-gray-800 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600">
                    <option value="">-- Select Interviewer --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('interviewer') 
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Recommendation Note (75%) -->
            <div class="w-3/4">
                <label class="block text-sm font-medium text-gray-800 mb-1">Recommendation Note</label>
                <textarea wire:model="recommendation_note"
                        class="w-full border border-gray-300 text-black rounded-lg focus:ring-green-600 focus:border-green-600"
                        rows="3"></textarea>
            </div>
        </div>


        <div class="flex gap-4">
            <!-- Selection (25%) -->
            <div class="w-1/4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Selection</label>
                <select wire:model="selection"
                        class="w-full p-1 text-gray-800 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600">
                    <option value="">-- Choose --</option>
                    <option value="Final Selected">Final Selected</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Waiting List">Waiting List</option>
                </select>

            </div>

            <!-- Interviewer Comments (75%) -->
            <div class="w-3/4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Interviewer Comments</label>
                <textarea wire:model="interviewer_comments"
                        class="w-full border border-gray-300 text-black rounded-lg focus:ring-green-600 focus:border-green-600"
                        rows="3"></textarea>
            </div>
        </div>


        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.shortlists.view') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium">
                Cancel
            </a>

            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="saveInterview"
                    class="px-4 py-2 rounded-lg bg-green-700 hover:bg-green-800 text-white font-medium flex items-center justify-center gap-2">
                
                <!-- Spinner -->
                <svg wire:loading wire:target="saveInterview" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>

                <!-- Button text -->
                <span wire:loading.remove wire:target="saveInterview">Save Interview</span>
                <span wire:loading wire:target="saveInterview">Saving...</span>
            </button>

        </div>
    </form>
</div>
