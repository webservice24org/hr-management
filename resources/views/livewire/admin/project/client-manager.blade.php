<div class="space-y-6">

    {{-- FORM --}}
    @if($showModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 w-full max-w-2xl rounded-lg shadow-lg p-6">

            <h3 class="text-lg font-bold mb-4">
                {{ $client_id ? 'Edit Client' : 'Add Client' }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input wire:model="client_name" class="border p-2 rounded" placeholder="Client Name">
                <input wire:model="company_name" class="border p-2 rounded" placeholder="Company Name">
                <input wire:model="email" class="border p-2 rounded" placeholder="Email">
                <input wire:model="mobile" class="border p-2 rounded" placeholder="Mobile">
                <input wire:model="country" class="border p-2 rounded" placeholder="Country">
                <textarea wire:model="address"
                    class="border p-2 rounded md:col-span-2"
                    placeholder="Address"></textarea>
            </div>

            <div class="flex items-center gap-4 mt-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="status">
                    Active
                </label>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button wire:click="closeModal"
                    class="px-4 py-2 bg-gray-500 text-white rounded">
                    Cancel
                </button>

                <button wire:click="save"
                    class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Save
                </button>
            </div>
        </div>
    </div>
    @endif


    {{-- LIST --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Clients</h2>

            <button wire:click="openModal"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Add Client
            </button>
        </div>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Company</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td class="border p-2">{{ $client->client_name }}</td>
                        <td class="border p-2">{{ $client->company_name }}</td>
                        <td class="border p-2">{{ $client->email }}</td>
                        <td class="border p-2 text-center">
                            <button wire:click="toggleStatus({{ $client->id }})"
                                class="px-2 py-1 rounded text-white
                                {{ $client->status ? 'bg-green-600' : 'bg-red-600' }}">
                                {{ $client->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="border p-2 text-center space-x-2">
                            <button wire:click="edit({{ $client->id }})"
                                class="text-blue-600">Edit</button>

                            <button wire:click="delete({{ $client->id }})"
                                class="text-red-600">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
