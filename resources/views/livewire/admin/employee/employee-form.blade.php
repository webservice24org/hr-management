<div class="mx-auto mt-8 bg-white shadow-lg p-6">

    <!-- Progress Bar -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex-1">
            <div class="flex justify-between mb-2">
                <span class="text-sm font-semibold {{ $step >= 1 ? 'text-green-700' : 'text-gray-500' }}">Employee</span>
                <span class="text-sm font-semibold {{ $step >= 2 ? 'text-green-700' : 'text-gray-500' }}">Information</span>
                <span class="text-sm font-semibold {{ $step >= 3 ? 'text-green-700' : 'text-gray-500' }}">Salary</span>
            </div>

            <div class="h-2 w-full bg-gray-200 rounded-full">
                <div class="h-2 bg-green-600 rounded-full transition-all duration-300"
                     style="width: {{ ($step / 3) * 100 }}%"></div>
            </div>
        </div>
    </div>

    <!-- Step 1: Employee -->
    @if ($step === 1)
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Employee Details</h2>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Select Candidate *</label>
                <select wire:model="candidate_id" class="w-full border-1 text-gray-800 rounded-lg p-2">
                    <option value="">-- Select Candidate --</option>
                    @foreach($candidates as $candidate)
                        <option value="{{ $candidate->id }}">
                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('candidate_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-800">National ID *</label>
                <input type="text" wire:model="national_id" class="w-full border-1 rounded-lg p-2 text-gray-800">
                @error('national_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-800">Passport No</label>
                <input type="text" wire:model="passport_no" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-800">Driving License</label>
                <input type="text" wire:model="driving_license" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-800">Employee Type *</label>
                <select wire:model="employee_type" class="w-full border-1 rounded-lg p-2 text-gray-800">
                    <option value="">-- Choose Type --</option>
                    <option value="Full time">Full time</option>
                    <option value="Part time">Part time</option>
                    <option value="Contractual">Contractual</option>
                    <option value="Daily worker">Daily worker</option>
                </select>
                @error('employee_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button wire:click="nextStep"
                    class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg hover:cursor-pointer">
                Next →
            </button>
        </div>
    </div>
    @endif

    <!-- Step 2: Employee Information -->
    @if ($step === 2)
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Employee Information</h2>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select wire:model="department_id"
                        class="w-full border rounded-lg p-2 text-gray-800 focus:ring-green-600 focus:border-green-600">
                    <option value="">-- Select Department --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                    @endforeach
                </select>
                @error('department_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sub Department</label>
                <select wire:model="sub_department_id"
                        class="w-full border rounded-lg p-2 text-gray-800 focus:ring-green-600 focus:border-green-600"
                        {{ empty($department_id) ? 'disabled' : '' }}>
                    <option value="">-- Select Sub Department --</option>
                    @foreach($subDepartments as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->sub_department_name }}</option>
                    @endforeach
                </select>
                @error('sub_department_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>





            <div>
                <label class="block text-sm font-medium text-gray-700">Joining Date *</label>
                <input type="date" wire:model="joining_date" class="w-full border-1 rounded-lg p-2 text-gray-800">
                @error('joining_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hire Date *</label>
                <input type="date" wire:model="hire_date" class="w-full border-1 rounded-lg p-2 text-gray-800">
                @error('hire_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Rehire Date</label>
                <input type="date" wire:model="rehire_date" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">ID Card No</label>
                <input type="text" wire:model="id_card_no" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Daily Working Hours</label>
                <input type="number" wire:model="daily_working_hours" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Pay Review</label>
                <select wire:model="pay_review" class="w-full border-1 rounded-lg p-2 text-gray-800">
                    <option value="">-- Select Review Period --</option>
                    <option value="six month">Six Month</option>
                    <option value="one year">One Year</option>
                    <option value="two year">Two Year</option>
                </select>

            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Pay Review Note</label>
                <textarea wire:model="pay_review_note" rows="3"
                    class="w-full border-1 rounded-lg p-2 text-gray-800"></textarea>
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button wire:click="previousStep"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                ← Previous
            </button>

            <button wire:click="nextStep"
                    class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg">
                Next →
            </button>
        </div>
    </div>
    @endif

    <!-- Step 3: Employee Salary -->
    @if ($step === 3)
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Employee Salary</h2>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Basic Salary *</label>
                <input type="number" wire:model.live="basic_salary" class="w-full border-1 rounded-lg p-2 text-gray-800">
                @error('basic_salary') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Transport Allowance</label>
                <input type="number" wire:model.live="transport_allowance" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Medical Allowance</label>
                <input type="number" wire:model.live="medical_allowance" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">House Rent</label>
                <input type="number" wire:model.live="house_rent" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>
        </div>

        <div class="mt-3">
            <p class="text-sm text-gray-700">Gross Salary: <span class="font-bold">{{ number_format($gross_salary, 2) }}</span></p>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Account No</label>
                <input type="text" wire:model="account_no" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Bank Name</label>
                <input type="text" wire:model="bank_name" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Bank Branch</label>
                <input type="text" wire:model="bank_branch" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Routing No</label>
                <input type="text" wire:model="routing_no" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">TIN No</label>
                <input type="text" wire:model="tin_no" class="w-full border-1 rounded-lg p-2 text-gray-800">
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button wire:click="previousStep"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                ← Previous
            </button>

            <button wire:click="save"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg flex items-center gap-2">
                <span wire:loading.remove>Save Employee</span>
                <span wire:loading class="animate-spin border-2 border-white border-t-transparent rounded-full w-4 h-4"></span>
            </button>
        </div>
    </div>
    @endif

</div>
