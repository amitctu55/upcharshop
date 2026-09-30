<x-filament-panels::page.simple>
    @php
        $hospital = $this->getCurrentHospital();
        $tenantSlug = $hospital ? $hospital->slug : 'lifeline';
        $brandColor = $hospital?->primary_color ?? '#0d9488';
    @endphp

    {{-- Brand Header Graphic --}}
    <div class="mb-6 text-center space-y-3">
        <div class="inline-flex items-center justify-center p-3 rounded-2xl shadow-xl shadow-teal-500/20 text-white font-extrabold text-2xl"
             style="background: linear-gradient(135deg, {{ $brandColor }}, #0f766e);">
            @if ($hospital && $hospital->logo_url)
                <img src="{{ $hospital->logo_url }}" alt="{{ $hospital->name }}" class="h-10 w-10 object-contain rounded-xl">
            @else
                🏥
            @endif
        </div>

        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-500/10 dark:bg-teal-500/20 text-teal-700 dark:text-teal-300 text-[11px] font-bold uppercase tracking-wider border border-teal-500/20">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ $hospital ? $hospital->name : 'Upchar.shop Healthcare Cloud' }}</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-2 font-heading">
                {{ $hospital ? 'Hospital Staff Gateway' : 'Central Admin Authentication' }}
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                Secure enterprise access for clinical operations, appointment scheduling & hospital management.
            </p>
        </div>
    </div>

    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}
            {{ $this->registerAction }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <x-filament-panels::form id="form" wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

    {{-- Quick Demo Credentials Card with Instant Auto-fill --}}
    <div class="mt-6 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-slate-50/80 dark:bg-slate-900/70 p-4.5 text-xs shadow-sm"
         x-data="{ tab: 'hospital' }">
        <div class="flex items-center justify-between font-bold text-slate-800 dark:text-slate-200 mb-3">
            <span class="flex items-center gap-1.5 text-xs">
                <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Instant Access Logins
            </span>
            <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-teal-500/10 text-teal-700 dark:text-teal-300 border border-teal-500/20">
                1-Click Autofill
            </span>
        </div>

        <div class="grid grid-cols-1 gap-2">
            {{-- Tenant Hospital Admin --}}
            <button type="button" 
                    x-on:click="$wire.set('data.email', 'admin@{{ $tenantSlug }}.com'); $wire.set('data.password', 'password');"
                    class="w-full text-left flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700/80 hover:border-teal-500 dark:hover:border-teal-400 transition-all group shadow-sm hover:shadow cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <div class="h-8 w-8 rounded-lg bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 flex items-center justify-center font-bold text-xs shrink-0 border border-teal-200 dark:border-teal-800">
                        🏥
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 text-xs">
                            {{ $hospital ? $hospital->name : 'LifeLine' }} Administrator
                        </div>
                        <div class="text-slate-500 dark:text-slate-400 text-[11px] font-mono">
                            admin@{{ $tenantSlug }}.com &bull; password
                        </div>
                    </div>
                </div>
                <span class="text-xs font-bold text-teal-600 dark:text-teal-400 opacity-80 group-hover:opacity-100 group-hover:translate-x-0.5 transition transform">
                    Fill &rarr;
                </span>
            </button>

            {{-- Reception / Front Desk --}}
            <button type="button" 
                    x-on:click="$wire.set('data.email', 'front@{{ $tenantSlug }}.com'); $wire.set('data.password', 'password');"
                    class="w-full text-left flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700/80 hover:border-teal-500 dark:hover:border-teal-400 transition-all group shadow-sm hover:shadow cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <div class="h-8 w-8 rounded-lg bg-cyan-50 dark:bg-cyan-950/60 text-cyan-700 dark:text-cyan-300 flex items-center justify-center font-bold text-xs shrink-0 border border-cyan-200 dark:border-cyan-800">
                        👩‍💼
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 text-xs">
                            Receptionist / Front Desk
                        </div>
                        <div class="text-slate-500 dark:text-slate-400 text-[11px] font-mono">
                            front@{{ $tenantSlug }}.com &bull; password
                        </div>
                    </div>
                </div>
                <span class="text-xs font-bold text-teal-600 dark:text-teal-400 opacity-80 group-hover:opacity-100 group-hover:translate-x-0.5 transition transform">
                    Fill &rarr;
                </span>
            </button>

            {{-- Super Admin --}}
            <button type="button" 
                    x-on:click="$wire.set('data.email', 'super@platform.com'); $wire.set('data.password', 'ChangeMe!123');"
                    class="w-full text-left flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700/80 hover:border-teal-500 dark:hover:border-teal-400 transition-all group shadow-sm hover:shadow cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <div class="h-8 w-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 flex items-center justify-center font-bold text-xs shrink-0 border border-indigo-200 dark:border-indigo-800">
                        ⚡
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 text-xs">
                            Platform Super Admin
                        </div>
                        <div class="text-slate-500 dark:text-slate-400 text-[11px] font-mono">
                            super@platform.com &bull; ChangeMe!123
                        </div>
                    </div>
                </div>
                <span class="text-xs font-bold text-teal-600 dark:text-teal-400 opacity-80 group-hover:opacity-100 group-hover:translate-x-0.5 transition transform">
                    Fill &rarr;
                </span>
            </button>
        </div>
    </div>

    {{-- Corporate Compliance Footer --}}
    <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-800/80 text-center space-y-1.5 text-[11px] text-slate-400">
        <div class="flex items-center justify-center gap-2">
            <span class="inline-flex items-center gap-1 font-semibold text-slate-600 dark:text-slate-300">
                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                HIPAA & DPDP Compliant Encryption
            </span>
            <span>&bull;</span>
            <span class="font-mono text-slate-500">256-Bit SSL</span>
        </div>
        <div>
            Operated by <strong class="text-slate-600 dark:text-slate-300">Workboat Media Private Limited</strong> &bull; CIN: <span class="font-mono">U80302UP2019PTC120912</span>
        </div>
        <div class="text-[10px] text-slate-400">
            Helpline: <a href="tel:+917607777883" class="hover:text-teal-600 font-semibold">+91 7607777883</a> &bull; <a href="mailto:workboatmedia@gmail.com" class="hover:text-teal-600">workboatmedia@gmail.com</a>
        </div>
    </div>
</x-filament-panels::page.simple>
