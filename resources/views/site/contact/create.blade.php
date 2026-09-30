@extends('layouts.site')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-10">
    <div>
        <h1 class="font-display text-4xl font-bold text-[var(--secondary)] mb-6">Contact Us</h1>
        @if(session('success'))<div class="bg-green-100 text-green-800 rounded-lg p-4 mb-4 text-sm font-medium">{{ session('success') }}</div>@endif
        <form method="POST" class="space-y-4">
            @csrf
            <input name="name" placeholder="Your name *" class="w-full border rounded-lg px-4 py-2.5" required>
            <input name="phone" placeholder="Phone *" class="w-full border rounded-lg px-4 py-2.5" required>
            <input name="email" type="email" placeholder="Email" class="w-full border rounded-lg px-4 py-2.5">
            <input name="subject" placeholder="Subject" class="w-full border rounded-lg px-4 py-2.5">
            <textarea name="message" rows="5" placeholder="Message *" class="w-full border rounded-lg px-4 py-2.5" required></textarea>
            <button class="bg-[var(--primary)] text-white font-semibold px-6 py-3 rounded-lg hover:opacity-90">Send Message</button>
        </form>
    </div>
    <div class="space-y-4 text-sm">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100"><strong>Address</strong><br>{{ $hospital->address }}, {{ $hospital->city }}</div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100"><strong>Phone</strong><br>{{ $hospital->phone }} · Emergency: {{ $hospital->emergency_phone }}</div>
        @if($hospital->map_embed)<div class="rounded-xl overflow-hidden shadow-sm">{!! $hospital->map_embed !!}</div>@endif
    </div>
</div>
@endsection
