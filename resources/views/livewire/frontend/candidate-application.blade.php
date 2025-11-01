<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6">

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-2xl font-semibold text-center text-green-800 mb-6">
        Candidate Application Form
    </h2>

    {{-- Step Indicator --}}
    <div class="flex justify-center mb-6">
        <div class="flex space-x-3">
            @for ($i = 1; $i <= 3; $i++)
                <div class="w-8 h-8 flex items-center justify-center rounded-full 
                    {{ $step === $i ? 'bg-green-800 text-white' : 'bg-gray-300 text-gray-700' }}">
                    {{ $i }}
                </div>
            @endfor
        </div>
    </div>

    {{-- Step 1: Basic Info --}}
    @if ($step === 1)
        @include('livewire.frontend.partials.step-basic-info')
    @endif

    {{-- Step 2: Education --}}
    @if ($step === 2)
        @include('livewire.frontend.partials.step-education')
    @endif

    {{-- Step 3: Experience --}}
    @if ($step === 3)
        @include('livewire.frontend.partials.step-experience')
    @endif

    {{-- Preview --}}
    @if ($showPreview)
        @include('livewire.frontend.partials.step-preview')
    @endif
</div>
