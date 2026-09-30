@extends('layouts.site')
@section('content')
<div class="max-w-xl mx-auto px-4 py-16 text-center">
    <div class="text-6xl mb-4">{{ $appointment->status === 'confirmed' ? '✅' : '⏳' }}</div>
    <h1 class="font-display text-3xl font-bold text-[var(--secondary)] mb-2">
        {{ $appointment->status === 'confirmed' ? 'Appointment Confirmed!' : 'Appointment Requested' }}
    </h1>
    <p class="text-gray-500 mb-8">Reference: <strong class="text-[var(--primary)]">{{ $appointment->reference_code }}</strong>
        @if($appointment->token_no) · Token #{{ $appointment->token_no }} @endif
    </p>
    <div class="bg-white rounded-xl shadow p-6 text-left space-y-2 text-sm border border-gray-100">
        <p><strong>Patient:</strong> {{ $appointment->patient_name }}</p>
        <p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
        <p><strong>Date:</strong> {{ $appointment->appointment_date->format('D, d M Y') }} at {{ substr($appointment->slot_time, 0, 5) }}</p>
        <p><strong>Department:</strong> {{ $appointment->doctor->department->name ?? '' }}</p>
        @if($appointment->status === 'pending')<p class="text-amber-600 font-medium pt-2">Our front desk will confirm shortly by phone.</p>@endif
    </div>
    <a href="{{ route('site.home') }}" class="inline-block mt-8 bg-[var(--primary)] text-white font-semibold px-6 py-3 rounded-lg hover:opacity-90">Back to Home</a>
</div>
@endsection
