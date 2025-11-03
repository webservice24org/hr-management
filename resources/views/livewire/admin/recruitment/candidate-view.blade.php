<div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
    <div class="flex justify-between items-center border-b pb-3 mb-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Candidate Profile — {{ $candidate->first_name }} {{ $candidate->last_name }}
        </h2>

        <div class="flex gap-2">
            <!-- Download PDF -->
            <button wire:click="downloadPdf"
                class="bg-green-700 hover:bg-green-800 hover:cursor-pointer text-white px-5 py-2 rounded shadow transition">
                <i class="fa-solid fa-file-pdf"></i> Download Application (PDF)
            </button>

            <!-- Shortlist -->
            <button wire:click="openShortlistModal"
                class="bg-blue-700 hover:bg-blue-800 hover:cursor-pointer text-white px-5 py-2 rounded shadow transition">
                <i class="fa-solid fa-check"></i> Select to Shortlist
            </button>

            <!-- Reject -->
            <button wire:click="openRejectModal" class="bg-red-700 hover:bg-red-800 hover:cursor-pointer text-white px-5 py-2 rounded shadow">
                <i class="fa-solid fa-xmark"></i> Reject Candidate
            </button>


            <!-- Back -->
            <a href="{{ route('admin.candidates.index') }}" 
            class="px-3 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded">
            Back to List
            </a>
        </div>
    </div>


    <div class="grid grid-cols-3 gap-6">
        <!-- Sidebar -->
        <div class="col-span-1 bg-blue-900 text-white rounded-lg p-4">
            <div class="text-center">
                @if($candidate->picture && file_exists(public_path('storage/' . $candidate->picture)))
                    <img src="{{ asset('storage/' . $candidate->picture) }}" 
                         alt="Candidate Photo" 
                         class="w-28 h-28 rounded-full mx-auto mb-3 object-cover border-2 border-white">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" 
                         alt="No Photo" 
                         class="w-28 h-28 rounded-full mx-auto mb-3 object-cover border-2 border-white">
                @endif

                <h3 class="text-lg font-bold">{{ $candidate->first_name }} {{ $candidate->last_name }}</h3>
                <p class="text-sm text-blue-100">
                    Applied for: {{ $candidate->position->position_name ?? 'N/A' }}
                </p>
            </div>

            <div class="mt-5 border-t border-blue-700 pt-3">
                <h4 class="font-semibold text-sm uppercase mb-2">Contact</h4>
                <p><strong>Email:</strong> {{ $candidate->email }}</p>
                <p><strong>Phone:</strong> {{ $candidate->phone }}</p>
                <p><strong>Alt Phone:</strong> {{ $candidate->alternative_phone ?? '-' }}</p>
                <p><strong>Address:</strong> {{ $candidate->present_address }}</p>
                <p><strong>City:</strong> {{ $candidate->city }}</p>
                <p><strong>Division:</strong> {{ $candidate->division }}</p>
                <p><strong>Post Code:</strong> {{ $candidate->post_code }}</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-span-2 space-y-8">
            {{-- Education Section --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 border-b-2 border-blue-700 pb-1 mb-3 flex items-center dark:text-white">
                    🎓 Education
                </h3>
                @if($candidate->educations->count())
                    <table class="min-w-full text-sm border border-gray-300  overflow-hidden">
                        <thead class="bg-blue-900 text-white text-left">
                            <tr>
                                <th class="border py-2 px-3">Degree</th>
                                <th class="border py-2 px-3">Institution</th>
                                <th class="border py-2 px-3">Result</th>
                                <th class="border py-2 px-3">Comments</th>
                            </tr>
                        </thead>
                        <tbody class=" divide-gray-200">
                            @foreach($candidate->educations as $edu)
                                <tr>
                                    <td class="border py-2 px-3 font-medium text-gray-800 dark:text-white">{{ $edu->degree }}</td>
                                    <td class="border py-2 px-3">{{ $edu->institution }}</td>
                                    <td class="border py-2 px-3">{{ $edu->result }}</td>
                                    <td class="border py-2 px-3">{{ $edu->comments ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">No education information provided.</p>
                @endif
            </div>

            {{-- Work Experience Section --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 border-b-2 border-green-700 pb-1 mb-3 flex items-center dark:text-white">
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
                                    <td class="border py-2 px-3 font-medium text-gray-800 dark:text-white">{{ $exp->company_name }}</td>
                                    <td class="border py-2 px-3">{{ $exp->working_period }}</td>
                                    <td class="border py-2 px-3">{{ $exp->duties }}</td>
                                    <td class="border py-2 px-3">{{ $exp->supervisor }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">No work experience provided.</p>
                @endif
            </div>
        </div>

    </div>

    {{-- Shortlist Modal --}}
    <div
        x-data="{ open: @entangle('showShortlistModal'), success: false }"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div @click.away="if (!success) open = false"
            class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 dark:bg-gray-800 transition-all transform"
            x-transition.scale>
            
            <!-- Success state -->
            <div x-show="success" x-transition>
                <div class="text-center py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-16 h-16 mx-auto text-green-500" 
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-semibold text-gray-800 dark:text-white">
                        Candidate Shortlisted!
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">
                        The candidate has been successfully shortlisted.
                    </p>
                </div>
                <div class="mt-5 flex justify-center">
                    <button @click="open = false; success = false"
                            class="px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded">
                        Done
                    </button>
                </div>
            </div>

            <!-- Form state -->
            <div x-show="!success" x-transition>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                    Shortlist Candidate
                </h3>

                <p><strong>Name:</strong> {{ $candidate->first_name }} {{ $candidate->last_name }}</p>
                <p><strong>Position:</strong> {{ $candidate->position->position_name ?? '-' }}</p>

                <div class="mt-3">
                    <label for="interview_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Interview Date
                    </label>
                    <input type="date"
                        id="interview_date"
                        wire:model="interview_date"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm">
                    @error('interview_date')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-5 flex justify-end space-x-2">
                    <button @click="open = false"
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
                        Cancel
                    </button>
                    <button wire:click="saveShortlist"
                            class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded"
                            wire:loading.attr="disabled"
                            wire:target="saveShortlist">
                        <span wire:loading.remove wire:target="saveShortlist">Save Shortlist</span>
                        <span wire:loading wire:target="saveShortlist">Saving...</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Trigger success animation -->
        <script>
            window.addEventListener('shortlist-saved', () => {
                const modal = document.querySelector('[x-data]');
                if (modal && modal.__x) {
                    modal.__x.$data.success = true;
                }
            });
        </script>
    </div>

    <!-- Reject Candidate Modal -->
    <div x-data="{ open: @entangle('showRejectModal') }" 
        x-show="open" 
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        
        <div x-show="open" x-transition.scale class="bg-white rounded shadow-lg w-96 p-5">
            <h2 class="text-lg font-semibold mb-3">Reject Candidate</h2>
            <p>Are you sure you want to reject <strong>{{ $candidate->first_name }} {{ $candidate->last_name }}</strong>?</p>
            <p class="text-sm text-gray-500 mt-1">An email will be sent to notify the candidate politely.</p>

            <div class="mt-4 flex justify-end gap-2">
                <button @click="open=false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>

                <button wire:click="rejectCandidate"
                        wire:loading.attr="disabled"
                        wire:target="rejectCandidate"
                        class="px-4 py-2 bg-red-700 text-white rounded flex items-center gap-2">
                    <span wire:loading.remove wire:target="rejectCandidate">Confirm Reject</span>
                    <svg wire:loading wire:target="rejectCandidate" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>




</div>
