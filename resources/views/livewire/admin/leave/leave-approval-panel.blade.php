<div class="p-6 bg-white rounded shadow">

    <h2 class="text-xl font-bold mb-4">Leave Approval Panel</h2>

    <table class="w-full border text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="border p-2">Employee</th>
                <th class="border p-2">Leave Type</th>
                <th class="border p-2">Dates</th>
                <th class="border p-2">Days</th>
                <th class="border p-2">Reason</th>
                <th class="border p-2">Attachment</th>
                <th class="border p-2">Status</th>
                <th class="border p-2 text-center">Action</th>
            </tr>
        </thead>

        <tbody>
        @forelse($leaves as $leave)
            <tr>
                <td class="border p-2">
                    {{ $leave->employee->candidate->first_name }}
                    {{ $leave->employee->candidate->last_name }}
                </td>

                <td class="border p-2">{{ $leave->leaveType->name }}</td>

                <td class="border p-2">
                    {{ $leave->from_date }} → {{ $leave->end_date }}
                </td>

                <td class="border p-2 text-center">
                    {{ $leave->total_days }}
                </td>

                <td class="border p-2">{{ $leave->reason }}</td>

                <td class="border p-2 text-center">
                    @if($leave->application_hard_copy)
                        <a href="{{ asset('storage/'.$leave->application_hard_copy) }}"
                           target="_blank"
                           class="text-blue-600 underline">
                           View
                        </a>
                    @else
                        —
                    @endif
                </td>

                <td class="border p-2 font-semibold">
                    <span class="
                        {{ $leave->status === 'approved' ? 'text-green-600' : '' }}
                        {{ $leave->status === 'rejected' ? 'text-red-600' : '' }}
                        {{ $leave->status === 'pending' ? 'text-yellow-600' : '' }}
                    ">
                        {{ ucfirst($leave->status) }}
                    </span>
                </td>

                <td class="border p-2 text-center space-x-2">
                    @if($leave->status === 'pending')
                        <button wire:click="approve({{ $leave->id }})"
                                class="bg-green-600 text-white px-3 py-1 rounded">
                            Approve
                        </button>

                        <button wire:click="reject({{ $leave->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded">
                            Reject
                        </button>
                    @else
                        —
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center p-4">
                    No leave applications found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
