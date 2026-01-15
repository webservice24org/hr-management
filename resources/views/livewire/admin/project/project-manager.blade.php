<div class="space-y-6">
    <div class="flex justify-between mb-4">
        <h2 class="text-lg font-bold">Projects</h2>

        <button wire:click="openModal"
            class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Project
        </button>
    </div>

    @if($showModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex justify-center items-center z-50">
        <div class="bg-white dark:bg-gray-800 w-full max-w-3xl rounded p-6">

            <h3 class="font-bold text-lg mb-4">
                {{ $project_id ? 'Edit Project' : 'Add Project' }}
            </h3>

            <div class="grid grid-cols-2 gap-4">

            <select wire:model="client_id" class="border p-2 rounded">
                <option value="">Select Client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                @endforeach
            </select>

            <input wire:model="project_name" class="border p-2 rounded" placeholder="Project Name">

            <input wire:model="project_code" class="border p-2 rounded" placeholder="Project Code">

            <select wire:model="team_leader_id" class="border p-2 rounded">
                <option value="">Select Team Leader</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <div class="col-span-2">
                <label class="font-semibold mb-1 block">Team Members</label>

                <select wire:model="team_members" multiple
                    class="border p-2 rounded w-full h-32">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            

            <input type="date" wire:model="start_date" class="border p-2 rounded">
            <input type="date" wire:model="end_date" class="border p-2 rounded">

            <textarea wire:model="description"
                class="border p-2 rounded col-span-2"
                placeholder="Project Description"></textarea>

            </div>

            <select wire:model="status" class="border p-2 rounded">
                <option value="pending">Pending</option>
                <option value="ongoing">Ongoing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <div class="flex justify-end gap-3 mt-6">
                <button wire:click="closeModal" class="bg-gray-500 px-4 py-2 text-white rounded">
                    Cancel
                </button>
                <button wire:click="save" class="bg-green-600 px-6 py-2 text-white rounded">
                    Save
                </button>
            </div>

        </div>
    </div>
    @endif

    <table class="w-full border mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-1">Project</th>
                <th class="border p-1">Client</th>
                <th class="border p-1">Team Leader</th>
                <th class="border p-1">Team Members</th>
                <th class="border p-1">Dates</th>
                <th class="border p-1">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr class="border-t text-center">
                <td class="border p-1">{{ $project->project_name }}</td>
                <td class="border p-1">{{ $project->client->client_name }}</td>
                <td class="border p-1">
                    {{ $project->teamLeader->name ?? '-' }}
                </td>

                <td class="border p-1">
                    @foreach($project->members as $member)
                        <span class="inline-block bg-gray-200 px-2 py-1 text-xs rounded">
                            {{ $member->user->name }}
                        </span>
                    @endforeach
                </td>

                <td class="border p-1">{{ $project->start_date }} → {{ $project->end_date }}</td>
                <td class="border p-1">{{ ucfirst($project->status) }}</td>
                <td class="border text-center space-x-2">
                    <button wire:click="edit({{ $project->id }})" class="text-blue-600"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button wire:click="delete({{ $project->id }})" class="text-red-600"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


</div>
