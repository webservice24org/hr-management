<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-6">
        <div class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden p-12 space-y-8">
            
            <!-- Header -->
            <x-auth-header 
                :title="__('Create an account')" 
                :description="__('Enter your details below to create your account')" 
                class="text-center"
            />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
                @csrf

                <!-- Name -->
                <flux:input
                    name="name"
                    :label="__('Name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    :placeholder="__('Full name')"
                />

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <!-- Password -->
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                />

                <!-- Confirm Password -->
                <flux:input
                    name="password_confirmation"
                    :label="__('Confirm password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Confirm password')"
                    viewable
                />

                <!-- Submit Button -->
                <div class="flex items-center justify-end">
                    <flux:button type="submit" variant="primary" class="w-full hover:cursor-pointer" data-test="register-user-button">
                        {{ __('Create account') }}
                    </flux:button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400 mt-4">
                <span>{{ __('Already have an account?') }}</span>
                <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
            </div>

        </div>
    </div>
</x-layouts.auth>
