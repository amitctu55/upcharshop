@php
    $color = $hospital?->primary_color ?? '#0d9488';
    $name = $hospital ? $hospital->name : 'Upchar.shop Healthcare Cloud';
    $tagline = $hospital?->tagline ?? 'Multi-Hospital SaaS Network & Clinical Operations';
    $userFirst = $user ? explode(' ', $user->name)[0] : 'Administrator';
    $roleName = $user?->roles?->first()?->name ?? ($isSuperAdmin ? 'Platform Super Admin' : 'Hospital Admin');
    $roleDisplay = ucwords(str_replace('_', ' ', $roleName));
@endphp

<div class="relative overflow-hidden rounded-3xl border border-slate-200/90 dark:border-slate-800/80 bg-gradient-to-br from-slate-900 via-teal-950 to-slate-900 text-white shadow-2xl transition-all duration-300">
    {{-- Ambient Glow Orbs --}}
    <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-teal-500/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-emerald-500/15 blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/3 h-64 w-64 rounded-full bg-cyan-500/10 blur-2xl pointer-events-none"></div>

    {{-- Subtle Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
         style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="relative z-10 p-6 sm:p-8 space-y-6">
        {{-- TOP ROW: Status Pill + Real-time Clock --}}
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-white/10 pb-5">
            <div class="flex flex-wrap items-center gap-3">
                {{-- Live Network Pulse --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold tracking-wide">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    <span class="text-emerald-300">SYSTEM OPERATIONAL</span>
                    <span class="text-white/40">&bull;</span>
                    @if ($hospital)
                        <span class="text-teal-100 font-bold">{{ $hospital->name }}</span>
                    @else
                        <span class="text-teal-100 font-bold">102 Hospitals Live</span>
                    @endif
                </div>

                {{-- Platform / Tenant Indicator --}}
                @if ($hospital)
                    <span class="text-[11px] px-2.5 py-1 rounded-full bg-teal-500/20 text-teal-200 border border-teal-400/30 font-mono">
                        {{ $hospital->slug }}.localhost:8000
                    </span>
                @else
                    <span class="text-[11px] px-2.5 py-1 rounded-full bg-cyan-500/20 text-cyan-200 border border-cyan-400/30 font-mono">
                        Network Central &bull; Workboat Media
                    </span>
                @endif
            </div>

            {{-- Live Dynamic Clock --}}
            <div class="flex items-center gap-2 text-xs font-mono text-slate-300 bg-black/30 backdrop-blur-md px-3.5 py-1.5 rounded-xl border border-white/10"
                 x-data="{ time: new Date().toLocaleTimeString('en-US', { hour12: true }), date: new Date().toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' }) }"
                 x-init="setInterval(() => { time = new Date().toLocaleTimeString('en-US', { hour12: true }) }, 1000)">
                <svg class="w-3.5 h-3.5 text-teal-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-text="date" class="text-slate-400 hidden sm:inline"></span>
                <span class="text-white/30 hidden sm:inline">&bull;</span>
                <span x-text="time" class="text-emerald-300 font-bold"></span>
            </div>
        </div>

        {{-- MIDDLE ROW: Hospital Hero / Executive Welcome --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-start sm:items-center gap-4 sm:gap-5">
                {{-- Large Branded Monogram / Logo --}}
                <div class="relative shrink-0">
                    <div class="h-16 w-16 sm:h-18 sm:w-18 rounded-2xl flex items-center justify-center text-white font-extrabold text-2xl shadow-xl border border-white/20"
                         style="background: linear-gradient(135deg, {{ $color }}, #0f766e);">
                        @if ($hospital && $hospital->logo_url)
                            <img src="{{ $hospital->logo_url }}" alt="{{ $hospital->name }}" class="h-full w-full object-cover rounded-2xl">
                        @else
                            {{ strtoupper(substr($hospital ? $hospital->name : 'Upchar', 0, 1)) }}
                        @endif
                    </div>
                    <span class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full bg-emerald-400 border-2 border-slate-900 shadow"></span>
                </div>

                <div class="space-y-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white font-heading">
                            Welcome back, {{ $userFirst }} 👋
                        </h1>
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-teal-400/20 text-teal-300 border border-teal-400/30">
                            {{ $roleDisplay }}
                        </span>
                    </div>

                    <p class="text-teal-200/80 text-sm max-w-2xl leading-relaxed">
                        @if ($hospital)
                            <strong>{{ $hospital->name }}</strong> &bull; {{ $tagline }}
                            @if($hospital->city) <span class="text-white/40">({{ $hospital->city }})</span> @endif
                        @else
                            <strong>Upchar.shop Central Cloud</strong> &bull; Complete SaaS Infrastructure for Multi-Speciality Hospitals
                        @endif
                    </p>
                </div>
            </div>

            {{-- Quick Launch Action Buttons --}}
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 shrink-0">
                <a href="/admin/appointments/create" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-extrabold text-xs shadow-lg shadow-teal-500/25 transition transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Book Appointment</span>
                </a>

                <a href="/admin/doctors" 
                   class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 text-white font-semibold text-xs border border-white/15 backdrop-blur-md transition transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Doctors ({{ $activeDoctors }})</span>
                </a>

                @if ($hospital)
                <a href="/admin/hospital-settings" 
                   class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 text-white font-semibold text-xs border border-white/15 backdrop-blur-md transition transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Settings</span>
                </a>

                <a href="//{{ $hospital->slug }}.localhost:8000/" target="_blank" rel="noopener noreferrer" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-teal-500/20 hover:bg-teal-500/30 text-teal-200 font-bold text-xs border border-teal-400/40 backdrop-blur-md transition transform hover:-translate-y-0.5">
                    <span>Live Portal</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
                @else
                <a href="/" target="_blank" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-teal-500/20 hover:bg-teal-500/30 text-teal-200 font-bold text-xs border border-teal-400/40 backdrop-blur-md transition transform hover:-translate-y-0.5">
                    <span>Storefront</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>

        {{-- BOTTOM ROW: High-Impact Operations Chips --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3 pt-2">
            {{-- Metric 1: Today's Appointments --}}
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm hover:bg-white/10 transition group">
                <div class="flex items-center justify-between text-teal-300 text-xs font-medium mb-1">
                    <span>Today's OPD</span>
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                </div>
                <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                    {{ $todayAppointments }}
                </div>
                <div class="text-[11px] text-teal-200/60 mt-0.5">
                    Scheduled consultations
                </div>
            </div>

            {{-- Metric 2: Pending Requests --}}
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm hover:bg-white/10 transition group">
                <div class="flex items-center justify-between text-amber-300 text-xs font-medium mb-1">
                    <span>Awaiting Action</span>
                    @if($pendingAppointments > 0)
                        <span class="animate-ping h-2 w-2 rounded-full bg-amber-400"></span>
                    @else
                        <span class="h-2 w-2 rounded-full bg-slate-500"></span>
                    @endif
                </div>
                <div class="text-2xl font-extrabold {{ $pendingAppointments > 0 ? 'text-amber-300' : 'text-white' }} group-hover:scale-105 transition origin-left font-heading">
                    {{ $pendingAppointments }}
                </div>
                <div class="text-[11px] text-teal-200/60 mt-0.5">
                    Requires staff review
                </div>
            </div>

            {{-- Metric 3: Active Specialists --}}
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm hover:bg-white/10 transition group">
                <div class="flex items-center justify-between text-cyan-300 text-xs font-medium mb-1">
                    <span>Active Doctors</span>
                    <span class="h-2 w-2 rounded-full bg-cyan-400"></span>
                </div>
                <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                    {{ $activeDoctors }}
                </div>
                <div class="text-[11px] text-teal-200/60 mt-0.5">
                    Verified medical staff
                </div>
            </div>

            {{-- Metric 4: Specialties / Departments --}}
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm hover:bg-white/10 transition group">
                <div class="flex items-center justify-between text-indigo-300 text-xs font-medium mb-1">
                    <span>Specialties</span>
                    <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                </div>
                <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                    {{ $departmentsCount }}
                </div>
                <div class="text-[11px] text-teal-200/60 mt-0.5">
                    Clinical departments
                </div>
            </div>

            {{-- Metric 5: Platform Scope (Hospitals or Inquiries) --}}
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm hover:bg-white/10 transition group col-span-2 sm:col-span-4 lg:col-span-1">
                @if ($hospital)
                    <div class="flex items-center justify-between text-purple-300 text-xs font-medium mb-1">
                        <span>New Inquiries</span>
                        <span class="h-2 w-2 rounded-full bg-purple-400"></span>
                    </div>
                    <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                        {{ $inquiriesCount }}
                    </div>
                    <div class="text-[11px] text-teal-200/60 mt-0.5">
                        Patient messages
                    </div>
                @else
                    <div class="flex items-center justify-between text-purple-300 text-xs font-medium mb-1">
                        <span>Total Tenants</span>
                        <span class="h-2 w-2 rounded-full bg-purple-400"></span>
                    </div>
                    <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                        {{ $totalHospitals }}
                    </div>
                    <div class="text-[11px] text-teal-200/60 mt-0.5">
                        Registered hospitals
                    </div>
                @endif
            </div>
        </div>

        {{-- OPTIONAL: Super Admin Quick Hospital Switcher Carousel --}}
        @if ($isSuperAdmin && !$hospital && count($featuredHospitals) > 0)
        <div class="pt-2 border-t border-white/10">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-2.5">
                <span class="text-xs font-bold text-slate-300 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Direct Switch to Hospital Portals:
                </span>
                <span class="text-[11px] text-teal-300/80">
                    Showing {{ count($featuredHospitals) }} of {{ $totalHospitals }} active tenants
                </span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
                @foreach ($featuredHospitals as $fh)
                    <a href="//{{ $fh->slug }}.localhost:8000/admin" 
                       class="flex items-center gap-2 p-2 rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 hover:border-teal-400/40 transition group">
                        <div class="h-6 w-6 rounded-lg flex items-center justify-center text-white font-extrabold text-[10px] shrink-0"
                             style="background: {{ $fh->primary_color ?? '#0d9488' }};">
                            {{ strtoupper(substr($fh->name, 0, 1)) }}
                        </div>
                        <div class="truncate text-left">
                            <div class="text-[11px] font-bold text-white group-hover:text-teal-300 truncate">
                                {{ $fh->name }}
                            </div>
                            <div class="text-[9px] text-slate-400 font-mono truncate">
                                {{ $fh->slug }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
