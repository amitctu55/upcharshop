@extends('layouts.site')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="font-display text-4xl font-bold text-[var(--secondary)] mb-8">Our Doctors</h1>
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="/doctors" class="px-4 py-1.5 rounded-full text-sm border {{ !request('department') ? 'bg-[var(--primary)] text-white' : 'bg-white hover:bg-gray-100' }}">All</a>
        @foreach($departments as $d)
        <a href="/doctors?department={{ $d->slug }}" class="px-4 py-1.5 rounded-full text-sm border {{ request('department') === $d->slug ? 'bg-[var(--primary)] text-white' : 'bg-white hover:bg-gray-100' }}">{{ $d->name }}</a>
        @endforeach
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($doctors as $doc)
        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-lg transition">
            @if($doc->photo)<img src="{{ asset('storage/'.$doc->photo) }}" class="h-52 w-full object-cover" alt="{{ $doc->name }}">
            @else <div class="h-52 bg-gray-100 grid place-items-center text-5xl">👨‍⚕️</div>@endif
            <div class="p-4">
                <h2 class="font-bold">{{ $doc->name }}</h2>
                <p class="text-xs text-gray-500">{{ $doc->department->name ?? '' }} · {{ $doc->qualifications }}</p>
                <div class="flex justify-between mt-3 items-center">
                    <span class="text-sm font-semibold text-[var(--primary)]">Fee: ₹{{ $doc->consultation_fee }}</span>
                    <a href="/doctors/{{ $doc->slug }}" class="text-sm font-semibold text-gray-700 hover:text-[var(--primary)]">Profile →</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
