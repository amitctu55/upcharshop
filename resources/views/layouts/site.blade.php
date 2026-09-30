<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', $hospital->seo['title'] ?? $hospital->name)</title>
<meta name="description" content="{{ $hospital->seo['description'] ?? $hospital->tagline }}">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $hospital->font_heading ?? 'Bricolage Grotesque') }}:wght@600;700;800&family={{ str_replace(' ', '+', $hospital->font_body ?? 'Public Sans') }}:wght@400;500;600;700&display=swap" rel="stylesheet">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
[x-cloak] { display: none !important; }
:root { --primary: {{ $hospital->primary_color ?? '#0E7C6B' }}; --secondary: {{ $hospital->secondary_color ?? '#093B33' }}; }
body { font-family: '{{ $hospital->font_body ?? 'Public Sans' }}', sans-serif; }
h1,h2,h3,h4,.font-display { font-family: '{{ $hospital->font_heading ?? 'Bricolage Grotesque' }}', sans-serif; }
</style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="bg-[var(--secondary)] text-white text-sm">
    <div class="max-w-6xl mx-auto px-4 py-2 flex flex-wrap justify-between gap-2">
        <span>📞 {{ $hospital->phone }} &nbsp;·&nbsp; ✉ {{ $hospital->email }}</span>
        <span class="font-semibold">🚑 Emergency: <a class="underline" href="tel:{{ $hospital->emergency_phone }}">{{ $hospital->emergency_phone ?? '108' }}</a></span>
    </div>
</div>

<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <a href="{{ route('site.home') }}" class="flex items-center gap-3">
            @if($hospital->logo)
                <img src="{{ asset('storage/'.$hospital->logo) }}" class="h-12" alt="{{ $hospital->name }}">
            @else
                <span class="w-11 h-11 rounded-xl bg-[var(--primary)] text-white grid place-items-center text-xl font-bold">＋</span>
            @endif
            <span>
                <span class="font-display font-bold text-lg text-[var(--secondary)] leading-tight block">{{ $hospital->name }}</span>
                <span class="text-xs text-gray-500">{{ $hospital->tagline }}</span>
            </span>
        </a>
        <nav class="hidden lg:flex items-center gap-6 text-sm font-medium">
            <a href="{{ route('site.home') }}" class="hover:text-[var(--primary)]">Home</a>
            <a href="/departments" class="hover:text-[var(--primary)]">Departments</a>
            <a href="/doctors" class="hover:text-[var(--primary)]">Doctors</a>
            <a href="/gallery" class="hover:text-[var(--primary)]">Gallery</a>
            <a href="/news" class="hover:text-[var(--primary)]">News</a>
            <a href="/contact" class="hover:text-[var(--primary)]">Contact</a>
            @foreach(\App\Models\Page::where('show_in_menu', true)->where('status', true)->get() as $p)
                <a href="/page/{{ $p->slug }}" class="hover:text-[var(--primary)]">{{ $p->title }}</a>
            @endforeach
        </nav>
        <a href="{{ route('site.book') }}" class="bg-[var(--primary)] hover:opacity-90 text-white font-semibold px-5 py-2.5 rounded-lg text-sm whitespace-nowrap">Book Appointment</a>
    </div>
</header>

<main>@yield('content')</main>

<footer class="bg-[var(--secondary)] text-gray-300 mt-20">
    <div class="max-w-6xl mx-auto px-4 py-12 grid md:grid-cols-4 gap-8 text-sm">
        <div>
            <div class="font-display font-bold text-white text-lg mb-3">{{ $hospital->name }}</div>
            <p>{{ $hospital->tagline }}</p>
        </div>
        <div>
            <div class="font-semibold text-white mb-3">Contact</div>
            <p>{{ $hospital->address }}, {{ $hospital->city }}</p>
            <p>📞 {{ $hospital->phone }}</p>
            <p>✉ {{ $hospital->email }}</p>
        </div>
        <div>
            <div class="font-semibold text-white mb-3">Quick Links</div>
            <a class="block mb-1 hover:text-white" href="/departments">Departments</a>
            <a class="block mb-1 hover:text-white" href="/doctors">Our Doctors</a>
            <a class="block mb-1 hover:text-white" href="{{ route('site.book') }}">Book Appointment</a>
            <a class="block mb-1 hover:text-white" href="/contact">Contact Us</a>
        </div>
        <div>
            <div class="font-semibold text-white mb-3">Working Hours</div>
            @foreach(($hospital->working_hours ?? ['Mon – Sat' => '9:00 AM – 8:00 PM', 'Emergency' => '24 × 7']) as $d => $h)
                <p>{{ $d }}: {{ $h }}</p>
            @endforeach
        </div>
    </div>
    <div class="border-t border-white/10 text-center py-4 text-xs">© {{ date('Y') }} {{ $hospital->name }}. All rights reserved.</div>
</footer>

@if($hospital->whatsapp)
<a href="https://wa.me/{{ preg_replace('/\D/', '', $hospital->whatsapp) }}" target="_blank"
   class="fixed bottom-5 right-5 bg-green-500 hover:bg-green-600 text-white rounded-full w-14 h-14 grid place-items-center text-2xl shadow-lg z-50">💬</a>
@endif
</body>
</html>
