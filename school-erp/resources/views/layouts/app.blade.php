<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'School ERP')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 text-gray-800">
<div class="flex min-h-screen">
    <aside class="w-64 bg-gray-900 text-gray-100 flex-shrink-0">
        <div class="p-4 text-xl font-bold border-b border-gray-700">School ERP</div>
        <nav class="p-4 space-y-1 text-sm">
            @yield('nav')
        </nav>
    </aside>
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow px-6 py-3 flex justify-between items-center">
            <h1 class="text-lg font-semibold">@yield('page-title', 'Dashboard')</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-red-600 hover:underline">লগআউট</button>
                </form>
            </div>
        </header>
        <main class="p-6 flex-1">
            @if (session('status'))
                <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2 text-sm">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
