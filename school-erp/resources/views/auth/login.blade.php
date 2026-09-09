<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-sm">
        <h1 class="text-2xl font-bold text-center mb-1">School ERP</h1>
        <p class="text-center text-gray-500 text-sm mb-6">Admin / Teacher / Student / Staff লগইন</p>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">ইমেইল</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">পাসওয়ার্ড</label>
                <input type="password" name="password" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> মনে রাখুন
            </label>
            <button type="submit" class="w-full bg-indigo-600 text-white rounded py-2 font-medium hover:bg-indigo-700">
                লগইন
            </button>
        </form>
    </div>
</body>
</html>
