@extends('layouts.site')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="font-display text-4xl font-bold text-[var(--secondary)] mb-4">{{ $department->name }}</h1>
    <div class="prose max-w-none mb-12">{!! $department->description ?? $department->short_description !!}</div>
    <h2 class="font-display text-2xl font-bold mb-6">Doctors in this department</h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($doctors as $doc)
        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <h3 class="font-bold">{{ $doc->name }}</h3>
            <p class="text-xs text-gray-500 mb-3">{{ $doc->qualifications }}</p>
            <a href="{{ route('site.book') }}" class="text-sm font-semibold text-[var(--primary)] hover:underline">Book →</a>
        </div>
        @empty <p class="text-gray-500">Doctors will be listed soon.</p> @endforelse
    </div>
</div>
@endsection
