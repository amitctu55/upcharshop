@php
    $color = $hospital?->primary_color ?? '#0d9488';
    $emergencyPhone = $hospital?->emergency_phone ?? '108';
    $mainPhone = $hospital?->phone ?? '+91 7607777883';
    $autoConfirm = $hospital?->setting('auto_confirm', true);
    $slotDuration = $hospital?->setting('slot_duration', 15);
    $advanceDays = $hospital?->setting('advance_days', 30);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    {{-- CARD 1: Operational Readiness & Emergency Dispatch --}}
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div class="h-9 w-9 rounded-xl bg-rose-50 dark:bg-rose-950/50 flex items-center justify-center text-rose-600 dark:text-rose-400 font-bold text-base shadow-sm">
                    🚨
                </div>
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 dark:text-white font-heading">
                        Emergency & Triage
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">24×7 Critical Dispatch Hotline</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-900">
                <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                ACTIVE
            </span>
        </div>

        <div class="space-y-2.5">
            <div class="flex items-center justify-between p-2.5 rounded-xl bg-rose-50/50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-900/50">
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Ambulance / Emergency:</span>
                <a href="tel:{{ $emergencyPhone }}" class="text-sm font-extrabold text-rose-600 dark:text-rose-400 hover:underline">
                    {{ $emergencyPhone }}
                </a>
            </div>

            <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
                <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Front Desk Hotline:</span>
                <a href="tel:{{ $mainPhone }}" class="text-xs font-bold text-slate-900 dark:text-white hover:text-teal-600">
                    {{ $mainPhone }}
                </a>
            </div>

            <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400 px-1 pt-1">
                <span>Auto OPD Confirmation:</span>
                <span class="font-bold {{ $autoConfirm ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                    {{ $autoConfirm ? '● Enabled' : '○ Manual Approval' }}
                </span>
            </div>
        </div>
    </div>

    {{-- CARD 2: OPD Scheduling Parameters --}}
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div class="h-9 w-9 rounded-xl bg-teal-50 dark:bg-teal-950/50 flex items-center justify-center text-teal-600 dark:text-teal-400 font-bold text-base shadow-sm">
                    ⏱️
                </div>
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 dark:text-white font-heading">
                        OPD Consultation Engine
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Token Generation & Slot Timing</p>
                </div>
            </div>
            <a href="/admin/hospital-settings" class="text-[10px] font-bold text-teal-600 dark:text-teal-400 hover:underline">
                Configure &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 gap-2.5">
            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 text-center">
                <div class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400">Slot Interval</div>
                <div class="text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">{{ $slotDuration }} <span class="text-xs font-normal">min</span></div>
                <div class="text-[9px] text-teal-600 dark:text-teal-400 font-medium">Standard Patient OPD</div>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 text-center">
                <div class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400">Advance Booking</div>
                <div class="text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">{{ $advanceDays }} <span class="text-xs font-normal">days</span></div>
                <div class="text-[9px] text-teal-600 dark:text-teal-400 font-medium">Online Horizon</div>
            </div>
        </div>

        <div class="mt-2.5 pt-2.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px]">
            <span class="text-slate-500 dark:text-slate-400">Active Hospital Timings:</span>
            <span class="font-bold text-slate-700 dark:text-slate-200">Mon–Sat 9:00 AM – 8:00 PM</span>
        </div>
    </div>

    {{-- CARD 3: Platform Trust & Support Guarantee --}}
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-gradient-to-br from-slate-900 via-slate-850 to-slate-900 text-white p-5 shadow-sm hover:shadow-md transition relative overflow-hidden">
        <div class="absolute -right-12 -bottom-12 h-40 w-40 rounded-full bg-teal-500/10 blur-2xl pointer-events-none"></div>

        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <div class="h-8 w-8 rounded-lg bg-teal-500/20 text-teal-300 flex items-center justify-center font-bold text-sm border border-teal-500/30">
                    🛡️
                </div>
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-white font-heading">
                        Enterprise SaaS Portal
                    </h3>
                    <p class="text-[10px] text-teal-200/70">Powered by Upchar.shop</p>
                </div>
            </div>
            <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-bold">
                PRO v2.5
            </span>
        </div>

        <div class="space-y-1.5 text-[11px] text-slate-300">
            <div class="flex items-center justify-between">
                <span class="text-slate-400">Provider:</span>
                <span class="font-semibold text-white">Workboat Media Private Limited</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-slate-400">Corporate CIN:</span>
                <span class="font-mono text-teal-300">U80302UP2019PTC120912</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-slate-400">Support Desk:</span>
                <a href="tel:+917607777883" class="font-bold text-white hover:text-teal-300">+91 7607777883</a>
            </div>
        </div>

        <div class="mt-3 pt-2.5 border-t border-white/10 flex items-center justify-between text-[10px]">
            <span class="text-slate-400">24/7 SLA Guarantee:</span>
            <span class="text-emerald-400 font-bold">99.98% Uptime</span>
        </div>
    </div>
</div>
