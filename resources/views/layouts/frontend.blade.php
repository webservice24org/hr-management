<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Frontend' }}</title>
    @livewireStyles
    @include('partials.head')
</head>
<body class="bg-gray-50 text-gray-900">
    <main class="max-w-6xl mx-auto px-4 py-6">
        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>
