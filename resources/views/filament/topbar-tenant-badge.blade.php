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
@endphp

@if ($hospital)
    <div class="hidden md:flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-slate-100/90 dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 text-xs">
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
        </span>
        <div class="flex items-center gap-1.5 font-semibold text-slate-700 dark:text-slate-200">
            <span>{{ $hospital->name }}</span>
            <span class="text-[10px] px-1.5 py-0.2 font-mono uppercase bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 rounded font-bold">
                {{ $hospital->slug }}
            </span>
        </div>
        <div class="h-3 w-px bg-slate-300 dark:bg-slate-700"></div>
        <a href="//{{ $hospital->slug }}.localhost:8000/" target="_blank" rel="noopener noreferrer" 
           class="inline-flex items-center gap-1 text-[11px] font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition">
            <span>View Site</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
        </a>
    </div>
@endif
