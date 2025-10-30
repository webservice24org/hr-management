<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        {!! ToastMagic::styles() !!}
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            

             <flux:navlist variant="outline">
                <div x-data="{ open: {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="hover:cursor-pointer flex items-center justify-between w-full px-3 py-2 text-left font-medium text-black dark:text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span><i class="fa-solid fa-users-gear"></i></span><span>User Management</span>
                        <svg x-show="!open" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                        <svg x-show="open" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition x-cloak>
                        <flux:navlist.group class="pl-4 mt-1">
                            <!-- Users -->
                            <flux:navlist.item
                                icon="users"
                                :href="route('admin.users.index')"
                                :current="request()->routeIs('admin.users.*')"
                                wire:navigate>
                                {{ __('Users') }}
                            </flux:navlist.item>

                            <!-- User Roles -->
                            <flux:navlist.item
                                icon="bolt"
                                :href="route('admin.roles.index')"
                                :current="request()->routeIs('admin.roles.*')"
                                wire:navigate>
                                {{ __('User Roles') }}
                            </flux:navlist.item> 
                            
                            <flux:navlist.item
                                icon="key"
                                :href="route('admin.permissions.index')"
                                :current="request()->routeIs('admin.permissions.*')"
                                wire:navigate>
                                {{ __('User Permissions') }}
                            </flux:navlist.item>

                        </flux:navlist.group>
                    </div>
                </div>
            </flux:navlist>

            <flux:navlist variant="outline">
                <div x-data="{ open: {{ request()->routeIs('admin.departments.*') || request()->routeIs('admin.subdepartments.*')  ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="hover:cursor-pointer flex items-center justify-between w-full px-3 py-2 text-left font-medium text-black dark:text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span><i class="fa-solid fa-address-card mr-1"></i></span><span>Department Settings</span>
                        <svg x-show="!open" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                        <svg x-show="open" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition x-cloak>
                        <flux:navlist.group class="pl-4 mt-1">
                            <!-- Users -->
                            <flux:navlist.item
                                :href="route('admin.departments.index')"
                                :current="request()->routeIs('admin.departments.*')"
                                wire:navigate
                            >
                                <i class="fas fa-building mr-2 text-gray-500 dark:text-gray-300"></i>
                                {{ __('Main Department') }}
                            </flux:navlist.item>

                           <flux:navlist.item
                                :href="route('admin.subdepartments.index')"
                                :current="request()->routeIs('admin.subdepartments.*')"
                                wire:navigate
                            >
                                <i class="fa-solid fa-building-user mr-2 text-gray-500 dark:text-gray-300"></i>
                                {{ __('Sub Department') }}
                            </flux:navlist.item>


                          


                            

                        </flux:navlist.group>
                    </div>
                </div>
            </flux:navlist>


            <flux:spacer />
           

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        {!! ToastMagic::scripts() !!}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        

    </body>
</html>
