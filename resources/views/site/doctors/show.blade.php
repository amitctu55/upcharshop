@extends('layouts.site')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 grid md:grid-cols-3 gap-8">
    <div>
        @if($doctor->photo)
            <img src="{{ asset('storage/'.$doctor->photo) }}" class="rounded-xl w-full shadow" alt="{{ $doctor->name }}">
        @else
            <div class="bg-gray-100 rounded-xl h-64 grid place-items-center text-6xl">👨‍⚕️</div>
        @endif
    </div>
    <div class="md:col-span-2">
        <h1 class="font-display text-3xl font-bold text-[var(--secondary)]">{{ $doctor->name }}</h1>
        <p class="text-gray-500">{{ $doctor->designation }} · {{ $doctor->department->name ?? '' }}</p>
        <p class="text-sm mt-1">{{ $doctor->qualifications }} @if($doctor->experience_years) · {{ $doctor->experience_years }} yrs experience @endif</p>
        @if($doctor->bio)<div class="prose mt-4 text-gray-700">{!! $doctor->bio !!}</div>@endif
        <h3 class="font-bold mt-6 mb-2">Weekly Schedule</h3>
        <div class="grid grid-cols-2 gap-2 text-sm">
            @foreach($doctor->schedules->sortBy('day_of_week') as $s)
            <div class="bg-gray-100 rounded px-3 py-2 font-medium">{{ ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][$s->day_of_week] }}:
                {{ substr($s->start_time,0,5) }} – {{ substr($s->end_time,0,5) }}</div>
            @endforeach
        </div>
        <a href="{{ route('site.book') }}" class="inline-block mt-6 bg-[var(--primary)] text-white font-semibold px-6 py-3 rounded-lg hover:opacity-90">Book Appointment</a>
    </div>
</div>
@endsection
