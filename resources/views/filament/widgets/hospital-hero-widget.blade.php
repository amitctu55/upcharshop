<div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-800 via-teal-700 to-emerald-800 text-white p-6 sm:p-8 shadow-xl">
    {{-- Background glowing accents --}}
    <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-emerald-500/20 blur-3xl pointer-events-none"></div>
    <div class="absolute right-1/3 -bottom-20 h-56 w-56 rounded-full bg-teal-400/20 blur-2xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        {{-- Left: Hospital Identity & Greeting --}}
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                </span>
                <span>{{ $hospital ? $hospital->name : 'Healthcare Platform' }} &bull; Command Center</span>
            </div>

            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                Welcome back, {{ $user ? explode(' ', $user->name)[0] : 'Administrator' }} 👋
            </h2>

            <p class="text-teal-100 text-sm max-w-xl leading-relaxed">
                Hospital portal is active and operating normally. You have 
                <strong class="text-white underline decoration-emerald-400 decoration-2">{{ $todayAppointments }}</strong> appointments scheduled today, 
                and <strong class="text-amber-200">{{ $pendingAppointments }}</strong> awaiting confirmation.
            </p>
        </div>

        {{-- Right: Quick Action Buttons --}}
        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
            <a href="/admin/appointments" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-teal-900 font-bold text-xs shadow-md hover:bg-teal-50 transition transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Appointments
            </a>

            <a href="/admin/doctors" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs border border-white/20 backdrop-blur-sm transition transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Doctors ({{ $activeDoctors }})
            </a>

            @if ($hospital)
            <a href="/admin/hospital-settings" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs border border-white/20 backdrop-blur-sm transition transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Hospital Settings
            </a>

            <a href="//{{ $hospital->slug }}.localhost:8000/" target="_blank" rel="noopener noreferrer" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-teal-950 font-bold text-xs shadow-md transition transform hover:-translate-y-0.5">
                <span>Live Site</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
            @endif
        </div>
    </div>
</div>
