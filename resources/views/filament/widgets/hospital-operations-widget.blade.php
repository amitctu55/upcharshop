@php
    $color = $hospital?->primary_color ?? '#0d9488';
    $emergencyPhone = !empty($hospital?->emergency_phone) ? $hospital->emergency_phone : (!empty($hospital?->phone) ? $hospital->phone : '108');
    $mainPhone = !empty($hospital?->phone) ? $hospital->phone : (!empty($hospital?->emergency_phone) ? $hospital->emergency_phone : null);
    $autoConfirm = $hospital?->setting('auto_confirm', true);
    $slotDuration = $hospital?->setting('slot_duration', 15);
    $advanceDays = $hospital?->setting('advance_days', 30);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- CARD 1: Operational Readiness & Emergency Dispatch --}}
    <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-rose-50 dark:bg-rose-950/60 flex items-center justify-center text-rose-600 dark:text-rose-400 font-bold text-lg shadow-sm border border-rose-100 dark:border-rose-900/60">
                        🚨
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white font-heading">
                            Emergency & Triage
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">24×7 Critical Dispatch Hotline</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/70 dark:text-rose-300 border border-rose-200 dark:border-rose-900">
                    <span class="h-2 w-2 rounded-full bg-rose-500 animate-pulse"></span>
                    Active
                </span>
            </div>

            <div class="space-y-3.5">
                {{-- Ambulance row with high contrast, prominent padding, and clear fallback --}}
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-rose-50/60 dark:bg-rose-950/30 border border-rose-200/80 dark:border-rose-900/60">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Ambulance / Emergency:</span>
                    @if ($emergencyPhone)
                        <a href="tel:{{ $emergencyPhone }}" class="text-sm font-extrabold text-rose-600 dark:text-rose-400 hover:underline flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ $emergencyPhone }}</span>
                        </a>
                    @else
                        <span class="text-xs font-semibold text-slate-400 italic">Not Available</span>
                    @endif
                </div>

                {{-- Front desk row --}}
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Front Desk Hotline:</span>
                    @if ($mainPhone)
                        <a href="tel:{{ $mainPhone }}" class="text-xs font-bold text-slate-900 dark:text-white hover:text-teal-600">
                            {{ $mainPhone }}
                        </a>
                    @else
                        <span class="text-xs font-semibold text-slate-400 italic">Not Available</span>
                    @endif
                </div>

                <div class="flex items-center justify-between text-xs text-slate-600 dark:text-slate-300 px-1 pt-1 border-t border-slate-100 dark:border-slate-800">
                    <span class="font-medium">Auto OPD Confirmation:</span>
                    <span class="font-bold {{ $autoConfirm ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                        {{ $autoConfirm ? '● Enabled' : '○ Manual Approval' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 2: OPD Scheduling Parameters --}}
    <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-teal-50 dark:bg-teal-950/60 flex items-center justify-center text-teal-600 dark:text-teal-400 font-bold text-lg shadow-sm border border-teal-100 dark:border-teal-900/60">
                        ⏱️
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white font-heading">
                            OPD Consultation Engine
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Token Generation & Slot Timing</p>
                    </div>
                </div>
                <a href="/admin/hospital-settings" class="text-xs font-bold text-teal-600 dark:text-teal-400 hover:underline">
                    Configure &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 gap-3.5">
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60 text-center">
                    <div class="text-xs font-bold text-slate-600 dark:text-slate-300">Slot Interval</div>
                    <div class="text-xl font-extrabold text-slate-900 dark:text-white mt-1">
                        @if (!empty($slotDuration))
                            {{ $slotDuration }} <span class="text-xs font-normal text-slate-500">min</span>
                        @else
                            <span class="text-sm font-semibold text-slate-400">Not Set</span>
                        @endif
                    </div>
                    <div class="text-[11px] text-teal-600 dark:text-teal-400 font-medium mt-0.5">Standard Patient OPD</div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60 text-center">
                    <div class="text-xs font-bold text-slate-600 dark:text-slate-300">Advance Booking</div>
                    <div class="text-xl font-extrabold text-slate-900 dark:text-white mt-1">
                        @if (!empty($advanceDays))
                            {{ $advanceDays }} <span class="text-xs font-normal text-slate-500">days</span>
                        @else
                            <span class="text-sm font-semibold text-slate-400">Not Set</span>
                        @endif
                    </div>
                    <div class="text-[11px] text-teal-600 dark:text-teal-400 font-medium mt-0.5">Online Horizon</div>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
            <span class="text-slate-500 dark:text-slate-400 font-medium">Active Hospital Timings:</span>
            <span class="font-bold text-slate-800 dark:text-slate-200">Mon–Sat 9:00 AM – 8:00 PM</span>
        </div>
    </div>

    {{-- CARD 3: Platform Trust & Support Guarantee --}}
    <div class="rounded-2xl border border-slate-800 bg-gradient-to-br from-slate-900 via-slate-850 to-slate-900 text-white p-6 shadow-sm hover:shadow-md transition relative overflow-hidden flex flex-col justify-between">
        <div class="absolute -right-12 -bottom-12 h-40 w-40 rounded-full bg-teal-500/10 blur-2xl pointer-events-none"></div>

        <div>
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="h-9 w-9 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center font-bold text-base border border-teal-500/30">
                        🛡️
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white font-heading">
                            Enterprise SaaS Portal
                        </h3>
                        <p class="text-xs text-teal-200/80">Powered by Upchar.shop</p>
                    </div>
                </div>
                <span class="text-xs font-mono px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-bold">
                    Pro v2.5
                </span>
            </div>

            <div class="space-y-2 text-xs text-slate-200">
                <div class="flex items-center justify-between py-1 border-b border-white/5">
                    <span class="text-slate-400">Provider:</span>
                    <span class="font-semibold text-white">Workboat Media Private Limited</span>
                </div>
                <div class="flex items-center justify-between py-1 border-b border-white/5">
                    <span class="text-slate-400">Corporate CIN:</span>
                    <span class="font-mono text-teal-300 font-semibold">U80302UP2019PTC120912</span>
                </div>
                <div class="flex items-center justify-between py-1">
                    <span class="text-slate-400">Support Desk:</span>
                    <a href="tel:+917607777883" class="font-bold text-white hover:text-teal-300">+91 7607777883</a>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-xs">
            <span class="text-slate-400">24/7 SLA Guarantee:</span>
            <span class="text-emerald-400 font-bold">99.98% Uptime</span>
        </div>
    </div>
</div>
