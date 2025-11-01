<div>
    <h3 class="text-xl font-semibold mb-4 text-green-800">Step 1: Basic Information</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700">Position Applying For</label>
            <select wire:model="position_id" class="w-full border rounded p-2 mt-1">
                <option value="">-- Select Position --</option>
                @foreach($positions as $pos)
                    <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                @endforeach
            </select>
            @error('position_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" wire:model="first_name" class="w-full border rounded p-2 mt-1">
            @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" wire:model="last_name" class="w-full border rounded p-2 mt-1">
            @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model="email" class="w-full border rounded p-2 mt-1">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" wire:model="phone" class="w-full border rounded p-2 mt-1">
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Alternative Phone</label>
            <input type="text" wire:model="alternative_phone" class="w-full border rounded p-2 mt-1">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Present Address</label>
            <textarea wire:model="present_address" class="w-full border rounded p-2 mt-1"></textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Permanent Address</label>
            <textarea wire:model="permanent_address" class="w-full border rounded p-2 mt-1"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Division</label>
            <input type="text" wire:model="division" class="w-full border rounded p-2 mt-1">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">City</label>
            <input type="text" wire:model="city" class="w-full border rounded p-2 mt-1">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Post Code</label>
            <input type="number" wire:model="post_code" class="w-full border rounded p-2 mt-1">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Upload Picture</label>
            <input type="file" wire:model="picture" class="w-full border rounded p-2 mt-1">
            @if ($picture)
                <img src="{{ $picture->temporaryUrl() }}" class="w-24 h-24 rounded-full mt-2 object-cover">
            @endif
        </div>
    </div>

    <div class="mt-6 text-right">
        <button wire:click="nextStep" class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded">
            Next →
        </button>
    </div>
</div>
