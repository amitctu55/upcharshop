@php
    $color = $hospital?->primary_color ?? '#0d9488';
    $name = $hospital ? $hospital->name : 'Upchar.shop Healthcare Cloud';
    $tagline = $hospital?->tagline ?? 'Multi-Hospital SaaS Network & Clinical Operations';
    $userFirst = $user ? explode(' ', $user->name)[0] : 'Administrator';
    $roleName = $user?->roles?->first()?->name ?? ($isSuperAdmin ? 'Platform Super Admin' : 'Hospital Admin');
    $roleDisplay = ucwords(str_replace('_', ' ', $roleName));
@endphp

<div class="relative overflow-hidden rounded-3xl border border-slate-700/80 bg-slate-900 text-white shadow-2xl transition-all duration-300"
     style="background: linear-gradient(135deg, #0b1329 0%, #062325 50%, #0b1329 100%);">
    {{-- Ambient Glow Accents --}}
    <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-teal-500/15 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>

    {{-- Subtle Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
         style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="relative z-10 p-6 sm:p-8 space-y-6">
        {{-- TOP ROW: Status Pill + Real-time Clock --}}
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-700/60 pb-5">
            <div class="flex flex-wrap items-center gap-3">
                {{-- Live Network Pulse in Title Case --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-800/90 border border-slate-700 text-xs font-semibold tracking-normal text-slate-200 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    <span class="text-emerald-400 font-bold">System Operational</span>
                    <span class="text-slate-500">&bull;</span>
                    @if ($hospital)
                        <span class="text-white font-bold">{{ $hospital->name }}</span>
                    @else
                        <span class="text-white font-bold">102 Hospitals Live</span>
                    @endif
                </div>

                {{-- Platform / Tenant Indicator --}}
                @if ($hospital)
                    <span class="text-xs px-3 py-1 rounded-full bg-teal-950/80 text-teal-300 border border-teal-700/60 font-mono font-medium">
                        {{ $hospital->slug }}.localhost:8000
                    </span>
                @else
                    <span class="text-xs px-3 py-1 rounded-full bg-cyan-950/80 text-cyan-300 border border-cyan-700/60 font-mono font-medium">
                        Network Central &bull; Workboat Media
                    </span>
                @endif
            </div>

            {{-- Live Dynamic Clock --}}
            <div class="flex items-center gap-2 text-xs font-mono text-slate-200 bg-slate-800/90 px-3.5 py-1.5 rounded-xl border border-slate-700 shadow-sm"
                 x-data="{ time: new Date().toLocaleTimeString('en-US', { hour12: true }), date: new Date().toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' }) }"
                 x-init="setInterval(() => { time = new Date().toLocaleTimeString('en-US', { hour12: true }) }, 1000)">
                <svg class="w-3.5 h-3.5 text-teal-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-text="date" class="text-slate-300 hidden sm:inline"></span>
                <span class="text-slate-500 hidden sm:inline">&bull;</span>
                <span x-text="time" class="text-emerald-300 font-bold"></span>
            </div>
        </div>

        {{-- MIDDLE ROW: Hospital Hero / Executive Welcome --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            {{-- Left column with ample horizontal room to prevent 4-line wrapping --}}
            <div class="flex items-start sm:items-center gap-4 sm:gap-5 flex-1 min-w-0 max-w-3xl">
                {{-- Branded Monogram / Logo --}}
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

                <div class="space-y-1.5 flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2.5">
                        {{-- Refactored to H2 so the page has exactly one H1 tag (Filament Dashboard) --}}
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white font-heading"
                            style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                            Welcome back, {{ $userFirst }} 👋
                        </h2>
                        <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-md bg-teal-500/20 text-teal-300 border border-teal-500/40">
                            {{ $roleDisplay }}
                        </span>
                    </div>

                    <p class="text-slate-300 text-sm leading-relaxed max-w-2xl font-normal">
                        @if ($hospital)
                            <strong class="text-white font-bold">{{ $hospital->name }}</strong> &bull; {{ $tagline }}
                            @if($hospital->city) <span class="text-slate-300">({{ $hospital->city }})</span> @endif
                        @else
                            <strong class="text-white font-bold">Upchar.shop Central Cloud</strong> &bull; Complete SaaS Infrastructure for Multi-Speciality Hospitals
                        @endif
                    </p>
                </div>
            </div>

            {{-- Right: High-Contrast Primary CTAs --}}
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                {{-- Book Appointment: High Contrast Solid Emerald with crisp white text --}}
                <a href="/admin/appointments/create" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-extrabold text-xs shadow-lg transition-all transform hover:-translate-y-0.5 cursor-pointer"
                   style="background: #059669; color: #ffffff !important; border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 4px 14px -2px rgba(5,150,105,0.6);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span style="color: #ffffff !important;">Book Appointment</span>
                </a>

                {{-- Doctors CTA: High Contrast Dark Slate with clear border --}}
                <a href="/admin/doctors" 
                   class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl font-bold text-xs shadow-md transition-all transform hover:-translate-y-0.5 cursor-pointer"
                   style="background: #1e293b; color: #ffffff !important; border: 1px solid rgba(255,255,255,0.25);">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span style="color: #ffffff !important;">Doctors ({{ $activeDoctors }})</span>
                </a>

                @if ($hospital)
                {{-- Hospital Settings CTA --}}
                <a href="/admin/hospital-settings" 
                   class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl font-bold text-xs shadow-md transition-all transform hover:-translate-y-0.5 cursor-pointer"
                   style="background: #1e293b; color: #ffffff !important; border: 1px solid rgba(255,255,255,0.25);">
                    <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span style="color: #ffffff !important;">Settings</span>
                </a>

                {{-- Live Portal Link --}}
                <a href="//{{ $hospital->slug }}.localhost:8000/" target="_blank" rel="noopener noreferrer" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl font-bold text-xs shadow-md transition-all transform hover:-translate-y-0.5 cursor-pointer"
                   style="background: #0e7490; color: #ffffff !important; border: 1px solid rgba(255,255,255,0.25);">
                    <span style="color: #ffffff !important;">Live Portal</span>
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
                @else
                {{-- Storefront Link --}}
                <a href="/" target="_blank" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl font-bold text-xs shadow-md transition-all transform hover:-translate-y-0.5 cursor-pointer"
                   style="background: #0e7490; color: #ffffff !important; border: 1px solid rgba(255,255,255,0.25);">
                    <span style="color: #ffffff !important;">Storefront</span>
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>

        {{-- BOTTOM ROW: High-Impact Operations Chips --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3 pt-2">
            {{-- Metric 1: Today's Appointments --}}
            <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:bg-slate-750 transition group">
                <div class="flex items-center justify-between text-teal-300 text-xs font-semibold mb-1">
                    <span>Today's OPD</span>
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                </div>
                <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                    {{ $todayAppointments }}
                </div>
                <div class="text-xs text-slate-300 mt-0.5">
                    Scheduled consultations
                </div>
            </div>

            {{-- Metric 2: Pending Requests --}}
            <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:bg-slate-750 transition group">
                <div class="flex items-center justify-between text-amber-300 text-xs font-semibold mb-1">
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
                <div class="text-xs text-slate-300 mt-0.5">
                    Requires staff review
                </div>
            </div>

            {{-- Metric 3: Active Specialists --}}
            <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:bg-slate-750 transition group">
                <div class="flex items-center justify-between text-cyan-300 text-xs font-semibold mb-1">
                    <span>Active Doctors</span>
                    <span class="h-2 w-2 rounded-full bg-cyan-400"></span>
                </div>
                <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                    {{ $activeDoctors }}
                </div>
                <div class="text-xs text-slate-300 mt-0.5">
                    Verified medical staff
                </div>
            </div>

            {{-- Metric 4: Specialties / Departments --}}
            <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:bg-slate-750 transition group">
                <div class="flex items-center justify-between text-indigo-300 text-xs font-semibold mb-1">
                    <span>Specialties</span>
                    <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                </div>
                <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                    {{ $departmentsCount }}
                </div>
                <div class="text-xs text-slate-300 mt-0.5">
                    Clinical departments
                </div>
            </div>

            {{-- Metric 5: Platform Scope (Hospitals or Inquiries) --}}
            <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:bg-slate-750 transition group col-span-2 sm:col-span-4 lg:col-span-1">
                @if ($hospital)
                    <div class="flex items-center justify-between text-purple-300 text-xs font-semibold mb-1">
                        <span>New Inquiries</span>
                        <span class="h-2 w-2 rounded-full bg-purple-400"></span>
                    </div>
                    <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                        {{ $inquiriesCount }}
                    </div>
                    <div class="text-xs text-slate-300 mt-0.5">
                        Patient messages
                    </div>
                @else
                    <div class="flex items-center justify-between text-purple-300 text-xs font-semibold mb-1">
                        <span>Total Tenants</span>
                        <span class="h-2 w-2 rounded-full bg-purple-400"></span>
                    </div>
                    <div class="text-2xl font-extrabold text-white group-hover:scale-105 transition origin-left font-heading">
                        {{ $totalHospitals }}
                    </div>
                    <div class="text-xs text-slate-300 mt-0.5">
                        Registered hospitals
                    </div>
                @endif
            </div>
        </div>

        {{-- Super Admin Quick Hospital Switcher Carousel --}}
        @if ($isSuperAdmin && !$hospital && count($featuredHospitals) > 0)
        <div class="pt-4 border-t border-slate-700/70">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                <h3 class="text-sm font-bold text-slate-100 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Direct Switch to Hospital Portals:
                </h3>
                {{-- High contrast text passing WCAG AA --}}
                <span class="text-xs font-semibold text-slate-300 dark:text-slate-300">
                    Showing {{ count($featuredHospitals) }} of {{ $totalHospitals }} active tenants
                </span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2.5">
                @foreach ($featuredHospitals as $fh)
                    <a href="//{{ $fh->slug }}.localhost:8000/admin" 
                       class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-800/90 hover:bg-slate-700/90 border border-slate-700 hover:border-teal-400 transition-all group shadow-sm">
                        <div class="h-7 w-7 rounded-lg flex items-center justify-center text-white font-extrabold text-xs shrink-0 shadow"
                             style="background: {{ $fh->primary_color ?? '#0d9488' }};">
                            {{ strtoupper(substr($fh->name, 0, 1)) }}
                        </div>
                        <div class="truncate text-left">
                            {{-- Increased font size for hospital name to text-sm font-bold --}}
                            <div class="text-sm font-bold text-white group-hover:text-teal-300 truncate">
                                {{ $fh->name }}
                            </div>
                            <div class="text-xs text-slate-300 font-mono truncate">
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
