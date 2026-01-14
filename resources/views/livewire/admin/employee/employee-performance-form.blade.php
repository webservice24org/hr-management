<div class="employee_performance space-y-8">
    <button wire:click="exportPdf"
        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
    Export PDF
</button>

    {{-- ===================== PERFORMANCE GUIDE ===================== --}}

    <div class="performance_guide p-6 rounded-lg shadow bg-white dark:bg-gray-800">
        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">
           Form fillup guide
        </h2>
        

        <table class="w-full border text-sm">
            <thead class="bg-green-800 text-white">
                <tr class="border p-2 text-center">
                    <td class="border p-2 text-center">P</td>
                    <td class="border p-2 text-center">NI</td>
                    <td class="border p-2 text-center">G</td>
                    <td class="border p-2 text-center">VG</td>
                    <td class="border p-2 text-center">E</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2 text-center">Poor</td>
                    <td class="border p-2 text-center">Need Improvement</td>
                    <td class="border p-2 text-center">Good</td>
                    <td class="border p-2 text-center">Very Good</td>
                    <td class="border p-2 text-center">Excellent</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ===================== SECTION A ===================== --}}
    <div class="p-6 rounded-lg shadow bg-white dark:bg-gray-800">
        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">
            A. JOB PERFORMANCE ASSESSMENT
        </h2>

        <table class="w-full border text-sm">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="border p-2 text-left">Criteria</th>
                    <th class="border p-2 text-center">P</th>
                    <th class="border p-2 text-center">NI</th>
                    <th class="border p-2 text-center">G</th>
                    <th class="border p-2 text-center">VG</th>
                    <th class="border p-2 text-center">E</th>
                    <th class="border p-2 text-center">Score</th>
                    <th class="border p-2">Comments & Examples</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sectionA as $key => $item)
                <tr>
                    <td class="border p-2 font-medium">
                        {{ $item['label'] }}
                    </td>

                    {{-- RADIO BUTTONS --}}
                    @foreach(['P','NI','G','VG','E'] as $rate)
                        <td class="border p-2 text-center">
                            <input type="radio"
                                value="{{ $rate }}"
                                wire:model="sectionA.{{ $key }}.rating"
                                class="cursor-pointer"
                                {{ ($is_locked && !$can_edit) ? 'disabled' : '' }}>
                        </td>
                    @endforeach

                    {{-- SCORE (READ ONLY) --}}
                    <td class="border p-2 text-center">
                        <input type="text"
                            readonly
                            wire:model="sectionA.{{ $key }}.score"
                            class="w-16 text-center bg-green-800 text-black border rounded font-semibold">
                    </td>



                    {{-- COMMENTS --}}
                    <td class="border p-2">
                        <input type="text"
                               wire:model="sectionA.{{ $key }}.comments"
                               {{ ($is_locked && !$can_edit) ? 'disabled' : '' }}
                               class="w-full border rounded p-1 text-sm">
                    </td>
                </tr>
                @endforeach

                {{-- SECTION A TOTAL --}}
                <tr class="bg-green-800 font-bold">
                    <td colspan="6" class="border p-2 text-right">
                        Section A Total (Max 60)
                    </td>
                    <td class="border p-2 text-center">
                        {{ $this->sectionATotal }}
                    </td>
                    <td class="border"></td>
                </tr>
            </tbody>
        </table>
    </div>



    {{-- ===================== SECTION B ===================== --}}
    <div class="p-6 rounded-lg shadow bg-white dark:bg-gray-800">
        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">
            B. OTHER PERFORMANCE STANDARDS
        </h2>


        <table class="w-full border text-sm">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="border p-2 text-left">Criteria</th>
                    <th class="border p-2 text-center">P</th>
                    <th class="border p-2 text-center">NI</th>
                    <th class="border p-2 text-center">G</th>
                    <th class="border p-2 text-center">VG</th>
                    <th class="border p-2 text-center">E</th>
                    <th class="border p-2 text-center">Score</th>
                    <th class="border p-2">Comments & Examples</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sectionB as $key => $item)
                <tr>
                    <td class="border p-2 font-medium">
                        {{ $item['label'] }}
                    </td>

                    {{-- RADIO BUTTONS --}}
                    @foreach(['P','NI','G','VG','E'] as $rate)
                        <td class="border p-2 text-center">
                            <input type="radio"
                                value="{{ $rate }}"
                                wire:model="sectionB.{{ $key }}.rating"
                                class="cursor-pointer"
                                {{ ($is_locked && !$can_edit) ? 'disabled' : '' }}>
                        </td>
                    @endforeach

                    {{-- SCORE (READ ONLY) --}}
                    <td class="border p-2 text-center">
                        <input type="text"
                            readonly
                            wire:model="sectionB.{{ $key }}.score"
                            class="w-16 text-center bg-green-800 text-black border rounded font-semibold">
                    </td>


                    

                    {{-- COMMENTS --}}
                    <td class="border p-2">
                        <input type="text"
                               wire:model="sectionB.{{ $key }}.comments"
                               {{ ($is_locked && !$can_edit) ? 'disabled' : '' }}
                               class="w-full border rounded p-1 text-sm">
                    </td>
                </tr>
                @endforeach

                {{-- SECTION B TOTAL --}}
                <tr class="bg-green-800 font-bold">
                    <td colspan="6" class="border p-2 text-right">
                        Section B Total
                    </td>
                    <td class="border p-2 text-center">
                        {{ $this->sectionBTotal }}
                    </td>
                    <td class="border"></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ===================== FINAL SUMMARY ===================== --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- OVERALL COMMENT --}}
        <div>
            <label class="font-semibold block mb-1">Overall Comment</label>
            <textarea wire:model="overall_comment"
                      {{ ($is_locked && !$can_edit) ? 'disabled' : '' }}
                      class="w-full border rounded p-2 text-sm"
                      rows="4"></textarea>
        </div>

        {{-- TOTAL + ACTION --}}
        <div class="flex flex-col justify-between">
            <div class="text-xl font-bold text-gray-800 dark:text-white">
                Total Score: {{ $this->totalScore }}
            </div>

            <button wire:click="save"
                {{ ($is_locked && !$can_edit) ? 'disabled' : '' }}
                class="mt-4 bg-green-600 text-white px-6 py-2 rounded
                    hover:bg-green-700 disabled:bg-gray-400">
            {{ $is_locked && !$can_edit ? 'Performance Locked' : 'Save Performance Review' }}
        </button>

        </div>
    </div>

</div>
