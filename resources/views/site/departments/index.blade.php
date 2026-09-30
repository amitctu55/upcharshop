@extends('layouts.site')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="font-display text-4xl font-bold text-[var(--secondary)] mb-8">Our Departments</h1>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($departments as $d)
        <a href="/departments/{{ $d->slug }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition border border-gray-100">
            <div class="text-3xl mb-3">{{ $d->icon ?? '🏥' }}</div>
            <h2 class="font-display font-bold text-lg">{{ $d->name }}</h2>
            <p class="text-sm text-gray-500 mb-3">{{ $d->short_description }}</p>
            <span class="text-xs font-semibold text-[var(--primary)]">{{ $d->doctors_count }} doctors →</span>
        </a>
        @endforeach
    </div>
</div>
@endsection
