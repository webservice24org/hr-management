<div class="p-6 space-y-6 bg-gray-100 min-h-screen text-black">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Employee Full Profile</h1>
        <a href="{{ route('admin.employee.manager') }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">Back to Employees</a>
    </div>

    {{-- Candidate Information --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Candidate Information</h2>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <strong>Candidate Apply ID:</strong> {{ $employee->candidate->candidate_apply_id ?? '-' }}
            </div>
            <div>
                <strong>Position:</strong> {{ $employee->candidate->position->position_name ?? '-' }}
            </div>
            <div>
                <strong>Full Name:</strong> {{ $employee->candidate->first_name }} {{ $employee->candidate->last_name }}
            </div>
            <div>
                <strong>Email:</strong> {{ $employee->candidate->email }}
            </div>
            <div>
                <strong>Phone:</strong> {{ $employee->candidate->phone }}</div>
            <div>
                <strong>Alternative Phone:</strong> {{ $employee->candidate->alternative_phone ?? '-' }}
            </div>
            <div>
                <strong>Present Address:</strong> {{ $employee->candidate->present_address ?? '-' }}
            </div>
            <div>
                <strong>Permanent Address:</strong> {{ $employee->candidate->permanent_address ?? '-' }}
            </div>
            <div>
                <strong>Division:</strong> {{ $employee->candidate->division ?? '-' }}
            </div>
            <div>
                <strong>City:</strong> {{ $employee->candidate->city ?? '-' }}
            </div>
            <div>
                <strong>Post Code:</strong> {{ $employee->candidate->post_code ?? '-' }}
            </div>
            <div class="col-span-2">
                <strong>Status:</strong> {{ $employee->candidate->status ?? '-' }}
            </div>
            <div class="col-span-2">
                @if($employee->candidate->picture)
                    <img src="{{ asset('storage/' . $employee->candidate->picture) }}" alt="Candidate Picture" class="w-40 h-40 object-cover rounded-lg border">
                @endif
            </div>
        </div>
    </div>

    {{-- Candidate Education --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Education</h2>
        @if($employee->candidate->educations && $employee->candidate->educations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y border divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border-1 px-4 py-2 text-left text-sm font-medium text-gray-700">Degree</th>
                            <th class="border-1 px-4 py-2 text-left text-sm font-medium text-gray-700">Institution</th>
                            <th class="border-1 px-4 py-2 text-left text-sm font-medium text-gray-700">Result</th>
                            <th class="border-1 px-4 py-2 text-left text-sm font-medium text-gray-700">Comments</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employee->candidate->educations as $edu)
                            <tr>
                                <td class="border-1 px-4 py-2 text-sm text-gray-800">{{ $edu->degree }}</td>
                                <td class="border-1 px-4 py-2 text-sm text-gray-800">{{ $edu->institution }}</td>
                                <td class="border-1 px-4 py-2 text-sm text-gray-800">{{ $edu->result }}</td>
                                <td class="border-1 px-4 py-2 text-sm text-gray-800">{{ $edu->comments ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No education records found.</p>
        @endif
    </div>

    {{-- Work Experience --}}
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Work Experience</h2>

        @if($employee->candidate->workExperiences && $employee->candidate->workExperiences->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border-1 px-4 py-2 text-left text-sm font-medium text-gray-700">Company</th>
                            <th class="border-1 px-4 py-2 text-left text-sm font-medium text-gray-700">Working Period</th>
                            <th class="border-1 px-4 py-2 text-left text-sm font-medium text-gray-700">Supervisor</th>
                            <th class="border-1 px-4 py-2 text-left text-sm font-medium text-gray-700">Duties</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employee->candidate->workExperiences as $work)
                            <tr>
                                <td class="border-1 px-4 py-2 text-sm text-gray-800">{{ $work->company_name }}</td>
                                <td class="border-1 px-4 py-2 text-sm text-gray-800">{{ $work->working_period }}</td>
                                <td class="border-1 px-4 py-2 text-sm text-gray-800">{{ $work->supervisor }}</td>
                                <td class="border-1 px-4 py-2 text-sm text-gray-800">{{ $work->duties }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No work experience records found.</p>
        @endif
    </div>


    {{-- Interview Details --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Interview Details</h2>
        @forelse($employee->candidate->interviews ?? [] as $interview)
            <div class="grid grid-cols-3 gap-4 mb-3 border-b pb-2">
                <div><strong>Interviewer:</strong> {{ $interview->interviewer }}</div>
                <div><strong>Position:</strong> {{ $interview->position_id }}</div>
                <div><strong>Date:</strong> {{ $interview->interview_date }}</div>
                <div><strong>Viva Marks:</strong> {{ $interview->viva_marks }}</div>
                <div><strong>Written Marks:</strong> {{ $interview->written_marks }}</div>
                <div><strong>MCQ Marks:</strong> {{ $interview->mcq_marks }}</div>
                <div><strong>Total Marks:</strong> {{ $interview->total_marks }}</div>
                <div><strong>Selection:</strong> {{ $interview->selection }}</div>
                <div class="col-span-3"><strong>Recommendation Note:</strong> {{ $interview->recommendation_note }}</div>
                <div class="col-span-3"><strong>Interviewer Comments:</strong> {{ $interview->interviewer_comments }}</div>
            </div>
        @empty
            <p>No interview records found.</p>
        @endforelse
    </div>

    {{-- Employee Information --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Employee Information</h2>
        <div class="grid grid-cols-2 gap-4">
            <div><strong>Department:</strong> {{ $employee->information->department->department_name ?? '-' }}</div>
            <div><strong>Sub Department:</strong> {{ $employee->information->subDepartment->sub_department_name ?? '-' }}</div>
            <div><strong>Joining Date:</strong> {{ $employee->information->joining_date ?? '-' }}</div>
            <div><strong>Hire Date:</strong> {{ $employee->information->hire_date ?? '-' }}</div>
            <div><strong>Rehire Date:</strong> {{ $employee->information->rehire_date ?? '-' }}</div>
            <div><strong>ID Card No:</strong> {{ $employee->information->id_card_no ?? '-' }}</div>
            <div><strong>Daily Working Hours:</strong> {{ $employee->information->daily_working_hours ?? '-' }}</div>
            <div><strong>Pay Review:</strong> {{ ucfirst($employee->information->pay_review ?? '-') }}</div>
            <div class="col-span-2"><strong>Pay Review Note:</strong> {{ $employee->information->pay_review_note ?? '-' }}</div>
        </div>
    </div>

    {{-- Salary Details --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Salary Details</h2>
        <div class="grid grid-cols-2 gap-4">
            <div><strong>Basic Salary:</strong> {{ $employee->salary->basic_salary ?? '-' }}</div>
            <div><strong>Transport Allowance:</strong> {{ $employee->salary->transport_allowance ?? '-' }}</div>
            <div><strong>Medical Allowance:</strong> {{ $employee->salary->medical_allowance ?? '-' }}</div>
            <div><strong>House Rent:</strong> {{ $employee->salary->house_rent ?? '-' }}</div>
            <div><strong>Gross Salary:</strong> {{ $employee->salary->gross_salary ?? '-' }}</div>
            <div><strong>Bank Name:</strong> {{ $employee->salary->bank_name ?? '-' }}</div>
            <div><strong>Bank Branch:</strong> {{ $employee->salary->bank_branch ?? '-' }}</div>
            <div><strong>Account No:</strong> {{ $employee->salary->account_no ?? '-' }}</div>
            <div><strong>Routing No:</strong> {{ $employee->salary->routing_no ?? '-' }}</div>
            <div><strong>TIN No:</strong> {{ $employee->salary->tin_no ?? '-' }}</div>
        </div>
    </div>
</div>
