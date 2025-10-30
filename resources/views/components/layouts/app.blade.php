<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        hello world
        {{ $slot }}

    </flux:main>
</x-layouts.app.sidebar>
