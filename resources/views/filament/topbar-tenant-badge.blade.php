@php
    $user = auth()->user();
    $host = request()->getHost();
    $subdomain = (new \App\Http\Middleware\ResolveHospital)->subdomain($host);

    $hospital = null;
    if ($subdomain !== '' && $subdomain !== 'localhost' && $subdomain !== $host) {
        $hospital = \App\Models\Hospital::where('slug', $subdomain)->orWhere('custom_domain', $host)->first();
    }
    if (!$hospital && $user && $user->hospital_id) {
        $hospital = $user->hospital;
    }

    $isSuperAdmin = $user && $user->hospital_id === null;
@endphp

@if ($hospital)
    {{-- Hospital Tenant Badge --}}
    <div class="hidden md:flex items-center gap-3 px-3 py-1.5 rounded-2xl
                bg-gradient-to-r from-slate-50 to-teal-50/60
                dark:from-slate-800/80 dark:to-teal-900/20
                border border-slate-200/80 dark:border-slate-700/60
                shadow-sm text-xs transition-all hover:shadow-md">

        {{-- Live Pulse --}}
        <span class="relative flex h-2.5 w-2.5 shrink-0">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-60"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 shadow-sm shadow-emerald-400/50"></span>
        </span>

        {{-- Hospital Info --}}
        <div class="flex items-center gap-2">
            {{-- Avatar Letter --}}
            <div class="h-6 w-6 rounded-lg flex items-center justify-center text-white font-extrabold text-[10px] shadow-sm"
                 style="background: linear-gradient(135deg, {{ $hospital->primary_color ?? '#0d9488' }}, {{ $hospital->primary_color ?? '#0f766e' }});">
                {{ strtoupper(substr($hospital->name, 0, 1)) }}
            </div>

            <div class="flex items-center gap-1.5">
                <span class="font-bold text-slate-700 dark:text-slate-200 text-[13px]">
                    {{ Str::limit($hospital->name, 28) }}
                </span>
                <span class="font-mono text-[10px] px-1.5 py-0.5 rounded-md
                             bg-teal-100 dark:bg-teal-900/50
                             text-teal-700 dark:text-teal-300
                             border border-teal-200/60 dark:border-teal-700/40
                             font-bold tracking-wide">
                    {{ $hospital->slug }}
                </span>
                @if($hospital->status === 'active')
                    <span class="text-[10px] px-1.5 py-0.5 rounded-md
                                 bg-emerald-100 dark:bg-emerald-900/50
                                 text-emerald-700 dark:text-emerald-300
                                 border border-emerald-200/60 dark:border-emerald-700/40
                                 font-bold uppercase tracking-wide">
                        Live
                    </span>
                @endif
            </div>
        </div>

        {{-- Divider --}}
        <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 shrink-0"></div>

        {{-- View Site Button --}}
        <a href="//{{ $hospital->slug }}.localhost:8000/"
           target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg
                  bg-white dark:bg-slate-800
                  border border-slate-200/70 dark:border-slate-700/60
                  text-[11px] font-semibold
                  text-teal-700 dark:text-teal-400
                  hover:bg-teal-600 hover:text-white hover:border-teal-600
                  dark:hover:bg-teal-700 dark:hover:text-white
                  shadow-sm transition-all duration-150 group">
            <svg class="w-3 h-3 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            <span>View Site</span>
        </a>
    </div>

@elseif ($isSuperAdmin)
    {{-- Super Admin Badge --}}
    <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-2xl
                bg-gradient-to-r from-violet-50 to-purple-50/60
                dark:from-violet-900/20 dark:to-purple-900/10
                border border-violet-200/70 dark:border-violet-700/40
                shadow-sm text-xs">
        <span class="text-lg">🛡️</span>
        <span class="font-bold text-violet-700 dark:text-violet-300 text-[12px]">Super Admin</span>
        <span class="font-mono text-[10px] px-1.5 py-0.5 rounded-md
                     bg-violet-100 dark:bg-violet-900/50
                     text-violet-600 dark:text-violet-400
                     border border-violet-200/60
                     font-bold tracking-wide uppercase">
            upchar.shop
        </span>
    </div>
@endif
