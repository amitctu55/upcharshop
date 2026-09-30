<!DOCTYPE html>
<html><head><title>{{ $hospital->name }}</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-50 grid place-items-center min-h-screen text-center p-6">
    <div><div class="text-5xl mb-4">🏥</div>
    <h1 class="text-2xl font-bold">{{ $hospital->name }}</h1>
    <p class="text-gray-500 mt-2">We're temporarily unavailable. Please call {{ $hospital->phone }}.</p></div>
</body></html>
