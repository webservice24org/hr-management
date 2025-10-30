<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center dark:bg-gray-900 p-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
            <!-- Card Header with Gradient -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 flex flex-col items-center space-y-2">
                <!-- Optional Logo/Icon -->
                <div class="bg-white dark:bg-gray-900 p-3 rounded-full shadow-md">
                    <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0L15.09 8H24l-6.545 4.755L18.18 24 12 18.27 5.82 24l1.635-11.245L0 8h8.91L12 0z"/>
                    </svg>
                </div>

                <!-- Header Text -->
                <h2 class="text-white text-2xl font-bold">{{ __('Log in to your account') }}</h2>
                <p class="text-indigo-100 text-sm text-center">{{ __('Enter your email and password below to log in') }}</p>
            </div>

            <!-- Card Body -->
            <div class="p-8 space-y-6">
                <!-- Session Status -->
                <x-auth-session-status class="text-center" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
                    @csrf

                    <!-- Email Address -->
                    <flux:input
                        name="email"
                        :label="__('Email address')"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="email@example.com"
                    />

                    <!-- Password -->
                    <div class="relative">
                        <flux:input
                            name="password"
                            :label="__('Password')"
                            type="password"
                            required
                            autocomplete="current-password"
                            :placeholder="__('Password')"
                            viewable
                        />

                        @if (Route::has('password.request'))
                            <flux:link class="absolute top-0 text-sm end-0 text-blue-600 hover:underline" :href="route('password.request')" wire:navigate>
                                {{ __('Forgot your password?') }}
                            </flux:link>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

                    <!-- Submit Button -->
                    <flux:button 
                        variant="primary" 
                        type="submit" 
                        class="w-full mt-2 bg-blue-600 hover:bg-blue-700 hover:cursor-pointer text-white font-semibold py-3 rounded-xl shadow-md transition-all duration-300 transform hover:scale-105"
                    >
                        {{ __('Log in') }}
                    </flux:button>
                </form>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">
                        <span>{{ __('Don\'t have an account?') }}</span>
                        <flux:link :href="route('register')" class="text-blue-600 hover:underline" wire:navigate>
                            {{ __('Sign up') }}
                        </flux:link>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.auth>
