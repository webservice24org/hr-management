<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">User List</h2>
        <input type="text" wire:model.debounce.300ms="search" placeholder="Search users..."
            class="border rounded px-3 py-1 dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring focus:ring-blue-500">
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border-tborder-collapse border border-gray-400">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 border border-gray-300 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Name</th>
                    <th class="px-4 border border-gray-300 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Email</th>
                    <th class="px-4 border border-gray-300 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Role</th>
                    <th class="px-4 border border-gray-300 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Created At</th>
                    <th class="px-4 border border-gray-300 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 border border-gray-300 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                        <td class="px-4 border border-gray-300 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</td>
                        <td class="px-4 border border-gray-300 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $user->role ?? 'N/A' }}</td>
                        <td class="px-4 border border-gray-300 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-4 border border-gray-300 py-2 text-sm text-gray-900 dark:text-gray-100 flex gap-2">
                            <button wire:click=""
                                    class="px-3 py-1 bg-green-800 hover:bg-green-600 hover:cursor-pointer dark:text-white text-white rounded text-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click=""
                                    class="px-3 py-1 bg-red-600 hover:bg-red-700 dark:text-white hover:cursor-pointer text-white rounded text-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500 dark:text-gray-300">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
