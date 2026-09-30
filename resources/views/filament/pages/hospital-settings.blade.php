<x-filament-panels::page>
    @php
        $hospital = $this->hospital();
    @endphp

    {{-- Interactive Live Hospital Preview Card --}}
    @if ($hospital)
    <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm transition hover:shadow-md">
        <div class="h-3 w-full" style="background-color: {{ $hospital->primary_color ?? '#0d9488' }};"></div>
        <div class="p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-2xl flex items-center justify-center text-white font-extrabold text-xl shadow-md"
                     style="background-color: {{ $hospital->primary_color ?? '#0d9488' }};">
                    {{ strtoupper(substr($hospital->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $hospital->name }}</h3>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                            Live Tenant
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                        {{ $hospital->tagline ?? 'Multi-Speciality Healthcare Services' }}
                    </p>
                    <div class="mt-1 flex flex-wrap items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                        <span>📍 {{ $hospital->city ?? 'Location Configured' }}</span>
                        <span>&bull;</span>
                        <span>📞 {{ $hospital->phone ?? 'Phone Configured' }}</span>
                        <span>&bull;</span>
                        <span>🚨 Emergency: <strong class="text-red-500">{{ $hospital->emergency_phone ?? '108' }}</strong></span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="//{{ $hospital->slug }}.localhost:8000/" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 transition shadow-sm">
                    <span>Preview Public Website</span>
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- The Tabbed Settings Form --}}
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-800">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                Changes take effect immediately on public site pages and booking engine.
            </span>
            <x-filament::button type="submit" size="lg" icon="heroicon-m-check">
                Save &amp; Apply Changes
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
