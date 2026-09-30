@php
    $color = $hospital?->primary_color ?? '#0d9488';
    $name = $hospital ? $hospital->name : 'Upchar.shop Central Cloud';
    $tagline = $hospital?->tagline ?? 'Multi-Hospital Management & Clinical Operations';
    $userFirst = $user ? explode(' ', $user->name)[0] : 'Platform';
    $roleName = $user?->roles?->first()?->name ?? ($isSuperAdmin ? 'Platform Super Admin' : 'Hospital Admin');
    $roleDisplay = ucwords(str_replace('_', ' ', $roleName));
@endphp

<div class="space-y-4">
    {{-- Main Executive Header Card (Stark White, Modern SaaS) --}}
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 sm:p-7 shadow-sm transition">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            {{-- Left: User Greeting & Identity --}}
            <div class="flex items-center gap-4">
                <div class="relative shrink-0">
                    <div class="h-14 w-14 rounded-2xl flex items-center justify-center text-white font-extrabold text-xl shadow-md"
                         style="background: linear-gradient(135deg, {{ $color }}, #0f766e);">
                        @if ($hospital && $hospital->logo_url)
                            <img src="{{ $hospital->logo_url }}" alt="{{ $hospital->name }}" class="h-full w-full object-cover rounded-2xl">
                        @else
                            {{ strtoupper(substr($hospital ? $hospital->name : 'Upchar', 0, 1)) }}
                        @endif
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 h-3.5 w-3.5 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-900 shadow-sm"></span>
                </div>

                <div class="space-y-1">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h2 class="text-2xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white font-heading">
                            Welcome back, {{ $userFirst }} 👋
                        </h2>
                        <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-teal-800">
                            {{ $roleDisplay }}
                        </span>
                    </div>

                    <p class="text-slate-500 dark:text-slate-400 text-xs font-normal">
                        @if ($hospital)
                            <strong class="text-slate-700 dark:text-slate-200">{{ $hospital->name }}</strong> &bull; {{ $tagline }}
                            @if($hospital->city) <span class="text-slate-400">({{ $hospital->city }})</span> @endif
                        @else
                            <strong class="text-slate-700 dark:text-slate-200">Upchar.shop Central Cloud</strong> &bull; Central command for multi-tenant hospital operations
                        @endif
                    </p>
                </div>
            </div>

            {{-- Right: Status & Quick Action CTAs --}}
            <div class="flex flex-wrap items-center gap-3">
                {{-- System Operational Badge --}}
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200/80 dark:border-emerald-800 text-xs font-semibold text-emerald-700 dark:text-emerald-300">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span>System Operational</span>
                </div>

                {{-- Live Clock --}}
                <div class="hidden sm:flex items-center gap-1.5 text-xs font-mono text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/80 px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-700"
                     x-data="{ time: new Date().toLocaleTimeString('en-US', { hour12: true }) }"
                     x-init="setInterval(() => { time = new Date().toLocaleTimeString('en-US', { hour12: true }) }, 1000)">
                    <svg class="w-3.5 h-3.5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span x-text="time" class="font-bold"></span>
                </div>

                {{-- Book Appointment Button (Solid Teal Accent) --}}
                <a href="/admin/appointments/create" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-sm shadow-teal-500/20 transition transform hover:-translate-y-0.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Book Appointment</span>
                </a>

                {{-- Doctors CTA (Crisp Light Outlined Button) --}}
                <a href="/admin/doctors" 
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-xs border border-slate-200 dark:border-slate-700 shadow-sm transition">
                    <svg class="w-3.5 h-3.5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Doctors ({{ $activeDoctors }})</span>
                </a>

                @if ($hospital)
                <a href="//{{ $hospital->slug }}.localhost:8000/" target="_blank" rel="noopener noreferrer" 
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 text-slate-700 dark:text-slate-200 font-semibold text-xs border border-slate-200 dark:border-slate-700 shadow-sm transition">
                    <span>Live Site</span>
                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
                @else
                <a href="/" target="_blank" 
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 text-slate-700 dark:text-slate-200 font-semibold text-xs border border-slate-200 dark:border-slate-700 shadow-sm transition">
                    <span>Storefront</span>
                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Direct Switch to Hospital Portals: Horizontally Scrolling Row of Clickable Mini-Cards --}}
    @if ($isSuperAdmin && !$hospital && count($featuredHospitals) > 0)
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 shadow-sm">
        <div class="flex items-center justify-between mb-3 px-1">
            <div class="flex items-center gap-2">
                <span class="text-sm">🏥</span>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 font-heading">
                    Direct Switch to Hospital Portals
                </h3>
            </div>
            <span class="text-xs font-medium text-slate-500 dark:text-slate-400">
                Showing {{ count($featuredHospitals) }} of {{ $totalHospitals }} active tenants &bull; Scroll for more &rarr;
            </span>
        </div>

        {{-- Horizontal scrolling row of distinct clickable pills / mini-cards --}}
        <div class="flex items-center gap-3 overflow-x-auto pb-1 scrollbar-thin">
            @foreach ($featuredHospitals as $fh)
                <a href="//{{ $fh->slug }}.localhost:8000/admin" 
                   class="shrink-0 flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-50/80 hover:bg-teal-50/60 dark:bg-slate-800/60 dark:hover:bg-teal-950/40 border border-slate-200/80 dark:border-slate-700 hover:border-teal-400 dark:hover:border-teal-500 transition-all group shadow-sm hover:shadow">
                    {{-- Colored letter avatar --}}
                    <div class="h-8 w-8 rounded-lg flex items-center justify-center text-white font-extrabold text-xs shadow-sm shrink-0"
                         style="background: {{ $fh->primary_color ?? '#0d9488' }};">
                        {{ strtoupper(substr($fh->name, 0, 1)) }}
                    </div>
                    <div class="text-left">
                        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 whitespace-nowrap">
                            {{ $fh->name }}
                        </div>
                        <div class="text-[10px] text-slate-500 dark:text-slate-400 font-mono flex items-center gap-1.5 mt-0.5">
                            <span>{{ $fh->slug }}</span>
                            @if($fh->city) 
                                <span>&bull;</span>
                                <span>{{ $fh->city }}</span>
                            @endif
                        </div>
                    </div>
                    <span class="text-xs text-teal-600 dark:text-teal-400 opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition transform ml-1">
                        &rarr;
                    </span>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
