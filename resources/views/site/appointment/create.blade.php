@extends('layouts.site')
@section('title', 'Book Appointment — '.$hospital->name)
@section('content')
<div class="max-w-3xl mx-auto px-4 py-12" x-data="booking()" x-cloak>
    <div class="text-center mb-8">
        <h1 class="font-display text-3xl sm:text-4xl font-extrabold text-[var(--secondary)] mb-2">Book an Appointment</h1>
        <p class="text-sm text-gray-500">Quick, seamless scheduling with our certified clinical specialists</p>
    </div>

    {{-- Progress Steps Bar --}}
    <div class="grid grid-cols-4 gap-2 mb-8 text-xs font-bold">
        <template x-for="(s, i) in ['1. Department', '2. Doctor', '3. Date & Time', '4. Your Details']">
            <div class="py-2.5 px-1 text-center rounded-lg transition-all duration-200"
                 :class="step === i + 1 
                    ? 'bg-[var(--primary)] text-white shadow-sm ring-2 ring-[var(--primary)]/30' 
                    : (step > i + 1 ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-400')"
                 x-text="s"></div>
        </template>
    </div>

    {{-- Validation Errors Display --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-start gap-3">
            <span class="text-xl">⚠️</span>
            <div>
                <div class="font-bold mb-1">Please correct the following:</div>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('site.book.store') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
        @csrf

        {{-- Hidden fields to guarantee values are submitted even when previous step divs are hidden --}}
        <input type="hidden" name="doctor_id" :value="doctorId">
        <input type="hidden" name="date" :value="date">
        <input type="hidden" name="time" :value="time">

        {{-- STEP 1: Choose Department --}}
        <div x-show="step === 1" class="space-y-4">
            <div class="flex items-center justify-between border-b pb-3 mb-2">
                <h2 class="text-base font-bold text-gray-800">Select Specialty Department</h2>
                <span class="text-xs text-gray-500">Step 1 of 4</span>
            </div>
            <div class="grid sm:grid-cols-2 gap-3">
                @foreach($departments as $d)
                <label class="border-2 rounded-xl p-4 cursor-pointer transition-all flex items-center justify-between"
                       :class="deptId == {{ $d->id }} 
                            ? 'border-[var(--primary)] bg-teal-50/40 ring-1 ring-[var(--primary)]' 
                            : 'border-gray-100 bg-gray-50/50 hover:border-gray-300 hover:bg-white'">
                    <div class="flex items-center gap-3">
                        <input type="radio" x-model="deptId" value="{{ $d->id }}" 
                               @change="doctorId = null; time = ''; slots = []"
                               class="accent-[var(--primary)] w-4 h-4">
                        <span class="font-semibold text-gray-800 text-sm">{{ $d->name }}</span>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">{{ $d->doctors->count() }} Doctors</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- STEP 2: Choose Doctor --}}
        <div x-show="step === 2" x-cloak class="space-y-4">
            <div class="flex items-center justify-between border-b pb-3 mb-2">
                <h2 class="text-base font-bold text-gray-800">Select Doctor</h2>
                <span class="text-xs text-gray-500">Step 2 of 4</span>
            </div>
            
            <div x-show="doctorsForDept().length === 0" class="text-center py-8 text-gray-500 text-sm">
                No doctors currently listed under this department. Please click "Back" to choose another department.
            </div>

            <div class="grid sm:grid-cols-2 gap-3" x-show="doctorsForDept().length > 0">
                <template x-for="doc in doctorsForDept()" :key="doc.id">
                    <label class="border-2 rounded-xl p-4 cursor-pointer transition-all flex items-start gap-3"
                           :class="doctorId == doc.id 
                                ? 'border-[var(--primary)] bg-teal-50/40 ring-1 ring-[var(--primary)]' 
                                : 'border-gray-100 bg-gray-50/50 hover:border-gray-300 hover:bg-white'">
                        <input type="radio" :value="doc.id" x-model="doctorId" 
                               @change="time = ''; loadSlots()"
                               class="accent-[var(--primary)] mt-1 w-4 h-4">
                        <div>
                            <span class="font-bold text-gray-900 block text-sm" x-text="doc.name"></span>
                            <span class="block text-xs text-gray-500 mt-0.5" x-text="doc.specialization || 'Clinical Specialist'"></span>
                        </div>
                    </label>
                </template>
            </div>
        </div>

        {{-- STEP 3: Choose Date & Time Slot --}}
        <div x-show="step === 3" x-cloak class="space-y-5">
            <div class="flex items-center justify-between border-b pb-3 mb-2">
                <h2 class="text-base font-bold text-gray-800">Select Date & Available Slot</h2>
                <span class="text-xs text-gray-500">Step 3 of 4</span>
            </div>

            {{-- Date selector with quick helpers --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Select Appointment Date</label>
                <div class="flex flex-wrap items-center gap-3">
                    <input type="date" x-model="date" :min="today" :max="maxDate"
                           @change="loadSlots()" @input="loadSlots()" 
                           class="border border-gray-200 rounded-xl px-4 py-2.5 w-full sm:w-64 font-medium text-gray-800 focus:outline-none focus:border-[var(--primary)]">
                    
                    {{-- Quick Date Chips --}}
                    <div class="flex items-center gap-2">
                        <button type="button" @click="setDateOffset(0)" 
                                class="px-3 py-1.5 rounded-lg border text-xs font-semibold transition"
                                :class="date === today ? 'border-[var(--primary)] bg-teal-50 text-[var(--primary)]' : 'border-gray-200 text-gray-600 hover:bg-gray-50'">
                            Today
                        </button>
                        <button type="button" @click="setDateOffset(1)" 
                                class="px-3 py-1.5 rounded-lg border text-xs font-semibold transition"
                                :class="date === getDateOffset(1) ? 'border-[var(--primary)] bg-teal-50 text-[var(--primary)]' : 'border-gray-200 text-gray-600 hover:bg-gray-50'">
                            Tomorrow
                        </button>
                        <button type="button" @click="setDateOffset(2)" 
                                class="px-3 py-1.5 rounded-lg border text-xs font-semibold transition"
                                :class="date === getDateOffset(2) ? 'border-[var(--primary)] bg-teal-50 text-[var(--primary)]' : 'border-gray-200 text-gray-600 hover:bg-gray-50'">
                            +2 Days
                        </button>
                    </div>
                </div>
            </div>

            {{-- Slots Area --}}
            <div class="pt-2">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Available Time Slots</label>
                
                {{-- Loading Spinner --}}
                <div x-show="loading" class="flex items-center gap-2 text-sm text-gray-500 py-6 justify-center">
                    <svg class="animate-spin h-5 w-5 text-[var(--primary)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Checking doctor schedules & real-time slots…</span>
                </div>

                {{-- Slots Grid --}}
                <div x-show="!loading && slots.length > 0" class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-6 gap-2.5">
                    <template x-for="t in slots" :key="t">
                        <label class="border-2 rounded-xl py-2.5 px-2 text-center text-sm font-semibold cursor-pointer transition-all"
                               :class="time === t 
                                    ? 'bg-[var(--primary)] text-white border-[var(--primary)] shadow-sm' 
                                    : 'border-gray-100 bg-gray-50/50 hover:border-gray-300 hover:bg-white text-gray-700'">
                            <input type="radio" :value="t" x-model="time" class="sr-only">
                            <span x-text="t"></span>
                        </label>
                    </template>
                </div>

                {{-- Empty Slots Alert --}}
                <div x-show="!loading && date && slots.length === 0" class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm">
                    No open consultation slots on <span class="font-bold" x-text="date"></span>. Please pick another date or check doctor availability.
                </div>
            </div>
        </div>

        {{-- STEP 4: Patient Details & Confirm --}}
        <div x-show="step === 4" x-cloak class="space-y-5">
            <div class="flex items-center justify-between border-b pb-3 mb-2">
                <h2 class="text-base font-bold text-gray-800">Patient Details</h2>
                <span class="text-xs text-gray-500">Step 4 of 4</span>
            </div>

            {{-- Booking Summary Badge --}}
            <div class="bg-teal-50/70 border border-teal-200 rounded-xl p-4 flex flex-wrap items-center justify-between gap-3 text-sm">
                <div>
                    <span class="text-xs text-teal-700 uppercase font-bold tracking-wider block">Booking With</span>
                    <span class="font-bold text-gray-900" x-text="doctorName()"></span>
                </div>
                <div>
                    <span class="text-xs text-teal-700 uppercase font-bold tracking-wider block">Date & Time</span>
                    <span class="font-bold text-gray-900" x-text="date + ' at ' + time"></span>
                </div>
                <button type="button" @click="step = 3" class="text-xs font-bold text-[var(--primary)] underline hover:opacity-80">
                    Change Slot
                </button>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input name="name" placeholder="e.g. Ramesh Sharma" class="border border-gray-200 rounded-xl px-4 py-2.5 w-full text-sm focus:outline-none focus:border-[var(--primary)]" required value="{{ old('name') }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Mobile Number <span class="text-red-500">*</span></label>
                    <input name="phone" placeholder="e.g. 9876543210" class="border border-gray-200 rounded-xl px-4 py-2.5 w-full text-sm focus:outline-none focus:border-[var(--primary)]" required value="{{ old('phone') }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email Address (Optional)</label>
                    <input name="email" type="email" placeholder="patient@example.com" class="border border-gray-200 rounded-xl px-4 py-2.5 w-full text-sm focus:outline-none focus:border-[var(--primary)]" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Age (Optional)</label>
                    <input name="age" type="number" min="0" max="130" placeholder="e.g. 35" class="border border-gray-200 rounded-xl px-4 py-2.5 w-full text-sm focus:outline-none focus:border-[var(--primary)]" value="{{ old('age') }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Gender</label>
                    <select name="gender" class="border border-gray-200 rounded-xl px-4 py-2.5 w-full text-sm focus:outline-none focus:border-[var(--primary)]">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Visit Type</label>
                    <select name="visit_type" class="border border-gray-200 rounded-xl px-4 py-2.5 w-full text-sm focus:outline-none focus:border-[var(--primary)]">
                        <option value="new" {{ old('visit_type') == 'new' ? 'selected' : '' }}>First Visit / New Consultation</option>
                        <option value="followup" {{ old('visit_type') == 'followup' ? 'selected' : '' }}>Follow-up Visit</option>
                        <option value="video" {{ old('visit_type') == 'video' ? 'selected' : '' }}>Online Video Consult</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Notes / Symptoms for the Doctor (Optional)</label>
                    <textarea name="notes" rows="3" placeholder="Briefly describe any symptoms, past history, or questions..." class="border border-gray-200 rounded-xl px-4 py-2.5 w-full text-sm focus:outline-none focus:border-[var(--primary)]">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Form Navigation Controls --}}
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <button type="button" x-show="step > 1" @click="step--" 
                    class="px-5 py-2.5 rounded-xl border border-gray-200 font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">
                ← Back
            </button>
            <button type="button" x-show="step < 4" @click="next()" 
                    class="ml-auto px-6 py-2.5 rounded-xl bg-[var(--primary)] text-white font-semibold text-sm hover:opacity-90 shadow-sm transition">
                Next →
            </button>
            <button type="submit" x-show="step === 4" 
                    class="ml-auto px-8 py-2.5 rounded-xl bg-[var(--primary)] text-white font-bold text-sm hover:opacity-90 shadow-md transition">
                Confirm &amp; Book Appointment ✓
            </button>
        </div>
    </form>
</div>

<script>
const DEPARTMENTS = @json($departmentsJson);

function booking() {
    return {
        step: {{ $errors->any() ? 4 : 1 }},
        deptId: {{ old('doctor_id') ? (App\Models\Doctor::find(old('doctor_id'))?->department_id ?? 'null') : 'null' }},
        doctorId: {{ old('doctor_id', 'null') }},
        date: '{{ old('date', '') }}',
        time: '{{ old('time', '') }}',
        slots: [],
        loading: false,
        today: new Date().toISOString().split('T')[0],
        maxDate: new Date(Date.now() + {{ $advanceDays }} * 86400000).toISOString().split('T')[0],

        init() {
            if (this.doctorId && this.date) {
                this.loadSlots();
            }
        },

        doctorsForDept() { 
            return (DEPARTMENTS.find(d => d.id == this.deptId)?.doctors) || []; 
        },

        doctorName() {
            for (let d of DEPARTMENTS) {
                let doc = d.doctors.find(item => item.id == this.doctorId);
                if (doc) return doc.name;
            }
            return 'Doctor';
        },

        getDateOffset(days) {
            return new Date(Date.now() + days * 86400000).toISOString().split('T')[0];
        },

        setDateOffset(days) {
            this.date = this.getDateOffset(days);
            this.loadSlots();
        },

        next() {
            if (this.step === 1) {
                if (!this.deptId) return alert('Please choose a department to proceed.');
            }
            if (this.step === 2) {
                if (!this.doctorId) return alert('Please choose a doctor to proceed.');
                if (!this.date) {
                    this.date = this.today;
                }
                this.loadSlots();
            }
            if (this.step === 3) {
                if (!this.date) return alert('Please select a date.');
                if (!this.time) return alert('Please pick a time slot.');
            }
            this.step++;
        },

        async loadSlots() {
            if (!this.doctorId || !this.date) return;
            this.loading = true;
            try {
                const r = await fetch(`/appointment/slots/${this.doctorId}/${this.date}`);
                if (r.ok) {
                    this.slots = await r.json();
                } else {
                    this.slots = [];
                }
            } catch (err) {
                this.slots = [];
            }
            this.loading = false;
        },
    };
}
</script>
@endsection
