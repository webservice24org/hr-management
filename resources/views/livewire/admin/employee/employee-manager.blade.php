<div class="space-y-4 bg-white dark:bg-gray-900 shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Employee Manager</h2>

        <a href="{{ route('admin.employees.create') }}"
           class="px-4 py-2 bg-green-800 text-white rounded-lg hover:bg-green-900">
            + Add Employee
        </a>
    </div>

    <!-- Search -->
    <div class="flex items-center mb-3">
        <input type="text"
               wire:model.debounce.300ms="search"
               placeholder="Search by name or NID..."
               class="w-full md:w-1/3 border rounded-lg p-2 focus:ring-green-500 focus:border-green-500">
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow">
        <table class="w-full border text-sm text-left text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-1">#</th>
                    <th class="px-4 py-2 border-1">Employee</th>
                    <th class="px-4 py-2 border-1">National ID</th>
                    <th class="px-4 py-2 border-1">Contact</th>
                    <th class="px-4 py-2 border-1">Employee Type</th>
                    <th class="px-4 py-2 border-1">Department</th>
                    <th class="px-4 py-2 border-1">Picture</th>
                    <th class="px-4 py-2 border-1 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $index => $emp)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="border-1 px-4 py-2">{{ $employees->firstItem() + $index }}</td>
                        <td class="border-1 px-4 py-2">
                            {{ $emp->candidate?->first_name }} {{ $emp->candidate?->last_name }}
                        </td>
                        <td class="border-1 px-4 py-2">{{ $emp->national_id ?? '-' }}</td>
                        <td class="border-1 px-4 py-2">{{ $emp->candidate->phone }}</td>
                        <td class="border-1 px-4 py-2">{{ $emp->employee_type }}</td>
                        <td class="border-1 px-4 py-2">
                            {{ $emp->information && $emp->information->department ? $emp->information->department->department_name : '-' }}
                        </td>

                        <td class="border px-4 py-2 text-center">
                            @if($emp->candidate && $emp->candidate->picture)
                                <img src="{{ asset('storage/' . $emp->candidate->picture) }}" 
                                    alt="Candidate Photo" 
                                    class="w-10 h-10 rounded-full object-cover mx-auto">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" 
                                    alt="No Photo" 
                                    class="w-10 h-10 rounded-full object-cover mx-auto opacity-70">
                            @endif
                        </td>
                        

                        <td class="border-1 px-4 py-2 text-center space-x-2">
                            <a href="{{ route('admin.employees.edit', $emp->id) }}"
                               class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.employee.view', $emp->id) }}"
                               class="px-2 py-1 bg-green-800 text-white rounded hover:bg-green-900 text-xs">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.employee.performance', $emp->id) }}"
                               class="px-2 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 text-xs">
                                <i class="fas fa-chart-line"></i>
                            </a>
                            <button wire:click="confirmDelete({{ $emp->id }})"
                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            No employees found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    @if($confirmingDelete)
        <div class="fixed inset-0 flex items-center justify-center bg-black/70 backdrop-blur-sm z-50">
            <div class="bg-white rounded-lg p-6 w-80 text-center">
                <p class="text-gray-700 mb-4">Are you sure you want to delete this employee?</p>
                <div class="flex justify-center space-x-3">
                    <button wire:click="deleteEmployee" class="bg-red-600 text-white px-4 py-2 rounded">Yes</button>
                    <button wire:click="$set('confirmingDelete', false)" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                </div>
            </div>
        </div>
    @endif
</div>
