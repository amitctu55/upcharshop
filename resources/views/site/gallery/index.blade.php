@extends('layouts.site')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="font-display text-4xl font-bold text-[var(--secondary)] mb-8">Gallery</h1>
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="/gallery" class="px-4 py-1.5 rounded-full text-sm border {{ !$active ? 'bg-[var(--primary)] text-white' : 'bg-white hover:bg-gray-100' }}">All</a>
        @foreach($categories as $c)
        <a href="/gallery?category={{ $c->slug }}" class="px-4 py-1.5 rounded-full text-sm border {{ $active === $c->slug ? 'bg-[var(--primary)] text-white' : 'bg-white hover:bg-gray-100' }}">{{ $c->name }}</a>
        @endforeach
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($items as $g)
        <figure class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
            <img src="{{ asset('storage/'.$g->image) }}" alt="{{ $g->alt_text ?? $g->title }}" class="h-48 w-full object-cover">
            <figcaption class="p-3 text-sm font-medium">{{ $g->title }}</figcaption>
        </figure>
        @endforeach
    </div>
</div>
@endsection
