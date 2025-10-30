<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 space-y-6">
            
            <!-- Header -->
            <x-auth-header 
                :title="__('Confirm Password')" 
                :description="__('Please confirm your password before continuing.')" 
                class="text-center"
            />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Confirm Password Form -->
            <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-6">
                @csrf

                <!-- Password -->
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                <!-- Submit Button -->
                <div class="flex items-center justify-end">
                    <flux:button type="submit" variant="primary" class="w-full hover:cursor-pointer">
                        {{ __('Confirm Password') }}
                    </flux:button>
                </div>
            </form>

            <!-- Forgot Password Link -->
            @if (Route::has('password.request'))
                <div class="text-center text-sm text-zinc-600 dark:text-zinc-400 mt-4">
                    <flux:link :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                </div>
            @endif

        </div>
    </div>
</x-layouts.auth>
