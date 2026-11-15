<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TaskBoard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <header class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="{{ route('tasks.index') }}" class="text-xl font-bold text-indigo-600">TaskBoard</a>
            <a href="{{ route('tasks.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">+ タスク追加</a>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-6">
        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800" role="status">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
