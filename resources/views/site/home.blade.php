@extends('layouts.site')
@section('content')

{{-- Hero --}}
<section class="relative bg-[var(--secondary)] text-white">
    <div class="max-w-6xl mx-auto px-4 py-20 md:py-28 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h1 class="font-display text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                {{ $banners->first()->heading ?? 'Your Health, Our Mission' }}
            </h1>
            <p class="text-white/80 mb-8">{{ $banners->first()->sub_heading ?? $hospital->tagline }}</p>
            <div class="flex gap-3">
                <a href="{{ route('site.book') }}" class="bg-[var(--primary)] hover:opacity-90 text-white font-semibold px-6 py-3 rounded-lg">Book Appointment</a>
                <a href="/departments" class="border border-white/40 hover:bg-white/10 px-6 py-3 rounded-lg font-semibold">Our Departments</a>
            </div>
        </div>
        @if($banners->first()?->image)
            <img src="{{ asset('storage/'.$banners->first()->image) }}" class="rounded-2xl shadow-2xl" alt="Hospital">
        @endif
    </div>
</section>

{{-- Stats --}}
@if($stats->count())
<section class="max-w-6xl mx-auto px-4 -mt-8">
    <div class="bg-white rounded-2xl shadow-lg grid grid-cols-2 md:grid-cols-4">
        @foreach($stats as $s)
        <div class="p-6 text-center">
            <div class="font-display text-3xl font-extrabold text-[var(--primary)]">{{ $s->value }}</div>
            <div class="text-sm text-gray-500">{{ $s->label }}</div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- Departments --}}
<section class="max-w-6xl mx-auto px-4 py-16">
    <h2 class="font-display text-3xl font-bold text-[var(--secondary)] mb-8 text-center">Our Departments</h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($departments as $d)
        <a href="/departments/{{ $d->slug }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition border border-gray-100">
            <div class="text-3xl mb-3">{{ $d->icon ?? '🏥' }}</div>
            <h3 class="font-display font-bold text-lg mb-1">{{ $d->name }}</h3>
            <p class="text-sm text-gray-500">{{ $d->short_description }}</p>
        </a>
        @endforeach
    </div>
</section>

{{-- Doctors --}}
@if($doctors->count())
<section class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="font-display text-3xl font-bold text-[var(--secondary)] mb-8 text-center">Meet Our Doctors</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($doctors as $doc)
            <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-lg transition">
                @if($doc->photo)<img src="{{ asset('storage/'.$doc->photo) }}" class="h-52 w-full object-cover" alt="{{ $doc->name }}">
                @else <div class="h-52 bg-gray-100 grid place-items-center text-5xl">👨‍⚕️</div>@endif
                <div class="p-4">
                    <h3 class="font-bold">{{ $doc->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $doc->department->name ?? '' }}</p>
                    <a href="{{ route('site.book') }}" class="inline-block mt-3 text-sm font-semibold text-[var(--primary)]">Book →</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Services --}}
@if($services->count())
<section class="max-w-6xl mx-auto px-4 py-16">
    <h2 class="font-display text-3xl font-bold text-[var(--secondary)] mb-8 text-center">Facilities & Services</h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @foreach($services as $s)
        <div class="bg-white rounded-xl p-5 text-center shadow-sm">
            <div class="text-3xl mb-2">{{ $s->icon }}</div>
            <div class="font-semibold text-sm">{{ $s->name }}</div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- CTA --}}
<section class="bg-[var(--primary)] text-white text-center py-14">
    <h2 class="font-display text-3xl font-bold mb-3">Need a consultation?</h2>
    <p class="mb-6 opacity-90">Book an appointment with our specialists in under a minute.</p>
    <a href="{{ route('site.book') }}" class="bg-white text-[var(--primary)] font-bold px-8 py-3 rounded-lg hover:bg-gray-100">Book Now</a>
</section>

{{-- Testimonials --}}
@if($testimonials->count())
<section class="max-w-6xl mx-auto px-4 py-16">
    <h2 class="font-display text-3xl font-bold text-[var(--secondary)] mb-8 text-center">Patient Stories</h2>
    <div class="grid md:grid-cols-3 gap-6">
        @foreach($testimonials as $t)
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <div class="text-amber-400 mb-2">{{ str_repeat('★', $t->rating) }}</div>
            <p class="text-sm text-gray-600 mb-4">“{{ $t->text }}”</p>
            <div class="font-semibold text-sm">{{ $t->patient_name }}</div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- Gallery strip --}}
@if($galleries->count())
<section class="max-w-6xl mx-auto px-4 pb-16">
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-display text-3xl font-bold text-[var(--secondary)]">Our Gallery</h2>
        <a href="/gallery" class="text-sm font-semibold text-[var(--primary)]">View all →</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
        @foreach($galleries as $g)
        <img src="{{ asset('storage/'.$g->image) }}" alt="{{ $g->alt_text ?? $g->title }}" class="rounded-lg h-32 w-full object-cover hover:opacity-80 transition">
        @endforeach
    </div>
</section>
@endif

@endsection
