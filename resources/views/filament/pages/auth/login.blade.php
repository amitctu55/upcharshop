<x-filament-panels::page.simple>
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

    {{-- Quick Login Credentials Helper Card --}}
    @php
        $hospital = $this->getCurrentHospital();
        $tenantSlug = $hospital ? $hospital->slug : 'lifeline';
    @endphp

    <div class="mt-6 rounded-2xl border border-gray-200 dark:border-gray-800 bg-gray-50/80 dark:bg-gray-900/60 p-4 text-xs shadow-sm">
        <div class="flex items-center justify-between font-semibold text-gray-700 dark:text-gray-300 mb-2.5">
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Quick Demo Credentials
            </span>
            <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-primary-50 text-primary-600 dark:bg-primary-950/60 dark:text-primary-400">
                Click to Auto-fill
            </span>
        </div>

        <div class="grid grid-cols-1 gap-2">
            {{-- Tenant Admin --}}
            <button type="button" 
                    x-on:click="$wire.set('data.email', 'admin@{{ $tenantSlug }}.com'); $wire.set('data.password', 'password');"
                    class="w-full text-left flex items-center justify-between p-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200/80 dark:border-gray-700/60 hover:border-primary-500 dark:hover:border-primary-500 transition group cursor-pointer">
                <div>
                    <div class="font-bold text-gray-900 dark:text-white group-hover:text-primary-600">
                        {{ $hospital ? $hospital->name : 'LifeLine' }} Admin
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-[11px]">
                        admin@{{ $tenantSlug }}.com &bull; password
                    </div>
                </div>
                <span class="text-xs font-semibold text-primary-600 dark:text-primary-400 opacity-80 group-hover:opacity-100">
                    Use &rarr;
                </span>
            </button>

            {{-- Reception / Front Desk --}}
            <button type="button" 
                    x-on:click="$wire.set('data.email', 'front@{{ $tenantSlug }}.com'); $wire.set('data.password', 'password');"
                    class="w-full text-left flex items-center justify-between p-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200/80 dark:border-gray-700/60 hover:border-primary-500 dark:hover:border-primary-500 transition group cursor-pointer">
                <div>
                    <div class="font-bold text-gray-900 dark:text-white group-hover:text-primary-600">
                        Reception / Front Desk
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-[11px]">
                        front@{{ $tenantSlug }}.com &bull; password
                    </div>
                </div>
                <span class="text-xs font-semibold text-primary-600 dark:text-primary-400 opacity-80 group-hover:opacity-100">
                    Use &rarr;
                </span>
            </button>

            {{-- Super Admin --}}
            <button type="button" 
                    x-on:click="$wire.set('data.email', 'super@platform.com'); $wire.set('data.password', 'ChangeMe!123');"
                    class="w-full text-left flex items-center justify-between p-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200/80 dark:border-gray-700/60 hover:border-primary-500 dark:hover:border-primary-500 transition group cursor-pointer">
                <div>
                    <div class="font-bold text-gray-900 dark:text-white group-hover:text-primary-600">
                        Platform Super Admin
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-[11px]">
                        super@platform.com &bull; ChangeMe!123
                    </div>
                </div>
                <span class="text-xs font-semibold text-primary-600 dark:text-primary-400 opacity-80 group-hover:opacity-100">
                    Use &rarr;
                </span>
            </button>
        </div>
    </div>
</x-filament-panels::page.simple>
