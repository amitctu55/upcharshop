<x-filament-panels::page>
    @php
        $hospital = $this->hospital();
        $color = $hospital?->primary_color ?? '#0d9488';
    @endphp

    @if ($hospital)
    {{-- ================================================================
         Premium Hospital Identity Card
         ================================================================ --}}
    <div class="relative overflow-hidden rounded-2xl border border-slate-200/80 dark:border-slate-700/60
                bg-white dark:bg-slate-900
                shadow-sm hover:shadow-lg transition-all duration-300">

        {{-- Gradient top stripe --}}
        <div class="h-1.5 w-full"
             style="background: linear-gradient(90deg, {{ $color }}, {{ $color }}cc, #14b8a6);"></div>

        {{-- Subtle BG pattern --}}
        <div class="absolute inset-0 opacity-[0.025]"
             style="background-image: radial-gradient(circle, #000 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="relative p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6">

            {{-- Left: Hospital Identity --}}
            <div class="flex items-start gap-5">
                {{-- Avatar --}}
                <div class="relative shrink-0">
                    <div class="h-16 w-16 rounded-2xl flex items-center justify-center text-white
                                font-extrabold text-2xl shadow-lg"
                         style="background: linear-gradient(135deg, {{ $color }}, {{ $color }}aa);">
                        {{ strtoupper(substr($hospital->name, 0, 1)) }}
                    </div>
                    <span class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full bg-emerald-400 border-2 border-white dark:border-slate-900 shadow"></span>
                </div>

                {{-- Info --}}
                <div class="space-y-1.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight"
                            style="font-family: 'Bricolage Grotesque', sans-serif;">
                            {{ $hospital->name }}
                        </h2>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                     bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300
                                     border border-emerald-200/60 dark:border-emerald-700/40">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Live Tenant
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold
                                     bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400
                                     border border-slate-200/60 dark:border-slate-700/40">
                            {{ $hospital->slug }}
                        </span>
                    </div>

                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                        {{ $hospital->tagline ?? 'Multi-Speciality Healthcare Services' }}
                    </p>

                    <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 dark:text-slate-400 pt-1">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $hospital->city ?? 'Varanasi' }}{{ $hospital->state ? ', '.$hospital->state : '' }}
                        </span>
                        @if($hospital->phone)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $hospital->phone }}
                        </span>
                        @endif
                        @if($hospital->emergency_phone)
                        <span class="flex items-center gap-1.5 font-semibold text-red-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            Emergency: {{ $hospital->emergency_phone }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Quick Actions --}}
            <div class="flex items-center gap-2.5 shrink-0">
                <a href="//{{ $hospital->slug }}.localhost:8000/appointment"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                          border border-slate-200 dark:border-slate-700
                          bg-white dark:bg-slate-800
                          text-slate-600 dark:text-slate-300
                          hover:bg-slate-50 dark:hover:bg-slate-700
                          shadow-sm transition-all duration-150">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Book Appointment
                </a>

                <a href="//{{ $hospital->slug }}.localhost:8000/"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                          text-white shadow-md transition-all duration-150
                          hover:-translate-y-0.5 hover:shadow-lg"
                   style="background: linear-gradient(135deg, {{ $color }}, {{ $color }}cc);">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Preview Public Site
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- ================================================================
         Settings Form
         ================================================================ --}}
    <form wire:submit="save" class="space-y-6 mt-2">
        {{ $this->form }}

        {{-- Save Footer Bar --}}
        <div class="sticky bottom-0 z-10">
            <div class="flex items-center justify-between
                        px-6 py-4 rounded-2xl
                        bg-white/95 dark:bg-slate-900/95
                        border border-slate-200/80 dark:border-slate-700/60
                        shadow-lg shadow-slate-200/50 dark:shadow-black/30
                        backdrop-blur-md">
                <div class="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Changes apply immediately to the public hospital website and booking engine.
                </div>
                <x-filament::button type="submit" size="lg" icon="heroicon-m-check-circle"
                    style="background: linear-gradient(135deg, #0d9488, #0f766e); box-shadow: 0 4px 16px -4px rgba(13,148,136,0.45);">
                    Save &amp; Apply Changes
                </x-filament::button>
            </div>
        </div>
    </form>
</x-filament-panels::page>
