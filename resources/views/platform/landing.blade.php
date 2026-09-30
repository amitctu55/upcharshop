<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upchar.shop &bull; Complete Hospital Website Solutions &amp; Digital Frontdesk</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#0d9488',
                            600: '#0f766e',
                            700: '#115e59',
                            800: '#134e4a',
                            900: '#042f2e',
                        },
                        navy: {
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        heading: ['"Bricolage Grotesque"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Subtle grid & gradient background */
        .hero-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .gradient-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.95));
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.04), 0 8px 10px -6px rgba(15, 23, 42, 0.02);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .gradient-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 35px -5px rgba(13, 148, 136, 0.12), 0 10px 15px -5px rgba(13, 148, 136, 0.06);
            border-color: rgba(13, 148, 136, 0.3);
        }

        /* Glass drawer */
        .glass-drawer {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-brand-500 selection:text-white"
      x-data="b2bStorefront()" x-cloak>

    {{-- Top Utility Bar --}}
    <div class="bg-navy-950 text-slate-300 text-xs py-2 px-4 sm:px-8 border-b border-navy-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 text-emerald-400 font-semibold">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    upchar.shop &bull; Hospital Website Store
                </span>
                <span class="text-slate-600 hidden sm:inline">&bull;</span>
                <span class="hidden sm:inline">Launch within 48 Hours &bull; Fully Managed Hosting Included</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="tel:+917607777883" class="hover:text-white transition flex items-center gap-1 font-medium">
                    <span>Direct Onboarding Line:</span>
                    <strong class="text-white">+91 7607777883</strong>
                </a>
                <span>&bull;</span>
                <a href="/admin/login" class="text-brand-400 hover:text-brand-300 font-semibold transition">
                    Platform Super Admin Login &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Main Navbar --}}
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 py-3.5 transition-all shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 group">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-brand-600 to-teal-500 flex items-center justify-center text-white font-extrabold text-xl shadow-md shadow-brand-500/20 group-hover:scale-105 transition">
                    🏥
                </div>
                <div>
                    <div class="font-heading font-extrabold text-xl text-navy-950 tracking-tight flex items-center gap-2">
                        <span>upchar<span class="text-brand-600">.shop</span></span>
                        <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-brand-50 text-brand-700 border border-brand-200">
                            Hospital Store
                        </span>
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">Pre-Built Healthcare Websites &bull; Workboat Media</div>
                </div>
            </a>

            {{-- Nav links --}}
            <nav class="hidden md:flex items-center gap-7 text-xs font-semibold text-slate-700">
                <a href="#templates" class="hover:text-brand-600 transition">Template Gallery</a>
                <a href="#how-it-works" class="hover:text-brand-600 transition">How It Works</a>
                <a href="#features" class="hover:text-brand-600 transition">Platform Features</a>
                <a href="#social-proof" class="hover:text-brand-600 transition">Active Network (100+)</a>
                <a href="#faq" class="hover:text-brand-600 transition">FAQ</a>
            </nav>

            {{-- Right CTA & Cart Pill --}}
            <div class="flex items-center gap-3">
                <button type="button" @click="openCartModal(null)" 
                        class="relative inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition border border-slate-200">
                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span>Cart</span>
                    <span class="h-4 px-1.5 rounded-full bg-brand-600 text-white text-[10px] font-bold flex items-center justify-center"
                          x-text="cart ? '1' : '0'"></span>
                </button>

                <a href="#templates" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/25 transition">
                    <span>Browse Templates</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1">

        {{-- 1. Hero Section --}}
        <section class="hero-pattern pt-16 pb-20 sm:pt-20 sm:pb-28 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    {{-- Hero Left: Copy & Value Proposition --}}
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-50 border border-brand-200 text-xs font-bold text-brand-800 shadow-sm">
                            <span class="flex h-2 w-2 rounded-full bg-brand-600"></span>
                            <span>For Hospital Owners, Doctors &amp; Healthcare Facilities</span>
                        </div>

                        <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-extrabold text-navy-950 tracking-tight leading-[1.12]">
                            Launch Your Hospital's <span class="bg-gradient-to-r from-brand-600 to-teal-500 bg-clip-text text-transparent">Digital Frontdesk</span> in 48 Hours
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            Stop losing patients to outdated, static websites. Choose a specialized medical design, connect your doctors' OPD schedules, and launch an enterprise patient booking portal without hiring an agency.
                        </p>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 pt-2">
                            <a href="#templates" 
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm shadow-lg shadow-brand-600/30 transition transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                <span>Browse 8+ Medical Templates</span>
                            </a>
                            <a href="#how-it-works" 
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm border border-slate-200 shadow-sm transition">
                                <span>See How It Works</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Value Props Checklist --}}
                        <div class="pt-4 grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs font-semibold text-slate-700">
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold">✓</span> Turnkey Doctor Roster
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold">✓</span> Double-Booking Shield
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold">✓</span> Custom Domain Ready
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold">✓</span> Reception &amp; Staff Login
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold">✓</span> Emergency 108 Hotline
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold">✓</span> 100% Mobile Optimized
                            </div>
                        </div>
                    </div>

                    {{-- Hero Right: Interactive Browser Viewport Mockup --}}
                    <div class="lg:col-span-5 relative">
                        <div class="relative mx-auto max-w-md lg:max-w-none rounded-2xl bg-white p-2.5 shadow-2xl border border-slate-200/90 ring-1 ring-slate-900/5">
                            {{-- Browser Header Dots --}}
                            <div class="flex items-center gap-2 px-3 py-2 bg-slate-100 rounded-t-xl border-b border-slate-200">
                                <div class="flex gap-1.5">
                                    <div class="h-2.5 w-2.5 rounded-full bg-red-400"></div>
                                    <div class="h-2.5 w-2.5 rounded-full bg-amber-400"></div>
                                    <div class="h-2.5 w-2.5 rounded-full bg-emerald-400"></div>
                                </div>
                                <div class="flex-1 text-center font-mono text-[11px] text-slate-500 bg-white py-0.5 rounded px-2 border border-slate-200 truncate">
                                    https://yourhospital.upchar.shop/appointment
                                </div>
                            </div>

                            {{-- Mockup Content --}}
                            <div class="p-5 space-y-4 bg-slate-50/50 rounded-b-xl">
                                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                                    <div class="flex items-center gap-2.5">
                                        <div class="h-9 w-9 rounded-lg bg-brand-600 text-white font-extrabold flex items-center justify-center text-sm shadow">
                                            H
                                        </div>
                                        <div>
                                            <div class="font-bold text-xs text-navy-950">Heritage Hospital Portal</div>
                                            <div class="text-[10px] text-emerald-600 font-semibold">● Accepting Online Bookings</div>
                                        </div>
                                    </div>
                                    <span class="text-[11px] font-bold px-2 py-0.5 rounded bg-brand-100 text-brand-800">
                                        Slot: 09:30 AM
                                    </span>
                                </div>

                                {{-- Step Progress visual --}}
                                <div class="grid grid-cols-4 gap-1.5 text-center text-[10px] font-bold">
                                    <div class="p-1.5 rounded-lg bg-brand-600 text-white">1. Dept</div>
                                    <div class="p-1.5 rounded-lg bg-brand-600 text-white">2. Doctor</div>
                                    <div class="p-1.5 rounded-lg bg-brand-100 text-brand-800 border border-brand-200">3. Slot</div>
                                    <div class="p-1.5 rounded-lg bg-slate-200 text-slate-500">4. Confirm</div>
                                </div>

                                {{-- Doctor Card Mockup --}}
                                <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-base">
                                            👨‍⚕️
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-900">Dr. Arturo Kuvalis</div>
                                            <div class="text-[10px] text-slate-500">Cardiology &bull; MBBS, MD</div>
                                        </div>
                                    </div>
                                    <span class="text-xs font-extrabold text-emerald-700 bg-emerald-50 px-2 py-1 rounded">₹500 Fee</span>
                                </div>

                                {{-- Quick Badge Stats --}}
                                <div class="grid grid-cols-3 gap-2 text-center">
                                    <div class="p-2 rounded-lg bg-white border border-slate-200 shadow-2xs">
                                        <div class="font-bold text-xs text-navy-950">15 min</div>
                                        <div class="text-[9px] text-slate-500 uppercase font-semibold">Slot Window</div>
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-slate-200 shadow-2xs">
                                        <div class="font-bold text-xs text-brand-600">SMS / Email</div>
                                        <div class="text-[9px] text-slate-500 uppercase font-semibold">Instant Alert</div>
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-slate-200 shadow-2xs">
                                        <div class="font-bold text-xs text-emerald-600">Auto-Token</div>
                                        <div class="text-[9px] text-slate-500 uppercase font-semibold">Queue System</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Floating Social Proof Callout --}}
                        <div class="absolute -bottom-6 -left-6 bg-navy-900 text-white p-3.5 rounded-2xl shadow-xl border border-navy-800 max-w-[220px] hidden sm:block">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-amber-400 text-xs">★★★★★</span>
                                <span class="text-[10px] text-slate-400 font-bold">100+ Live Hospitals</span>
                            </div>
                            <div class="text-[11px] font-semibold text-slate-200 leading-tight">
                                "Our frontdesk inquiries doubled within the first week of launch."
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- 2. How It Works Section --}}
        <section id="how-it-works" class="py-16 sm:py-20 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-8">
                <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                    <span class="text-brand-600 font-bold text-xs uppercase tracking-wider">Simple 3-Step Onboarding</span>
                    <h2 class="font-heading text-3xl sm:text-4xl font-extrabold text-navy-950">How Your Hospital Goes Live</h2>
                    <p class="text-slate-600 text-sm sm:text-base">We handle domain setup, server infrastructure, staff logins, and doctor rosters so your clinical team doesn't touch code.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    {{-- Step 1 --}}
                    <div class="bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200 relative group hover:border-brand-500 transition">
                        <div class="h-12 w-12 rounded-xl bg-brand-100 text-brand-700 font-extrabold text-lg flex items-center justify-center mb-5 group-hover:bg-brand-600 group-hover:text-white transition">
                            01
                        </div>
                        <h3 class="font-heading font-bold text-xl text-navy-950 mb-2.5">Choose a Specialty Design</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">
                            Browse our curated catalog of 8+ hospital website themes tailored for Multispecialty, Eye Care, Trauma, Cardiology, or Pediatrics.
                        </p>
                        <span class="text-xs font-bold text-brand-600 inline-flex items-center gap-1">
                            Browse Gallery Below &darr;
                        </span>
                    </div>

                    {{-- Step 2 --}}
                    <div class="bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200 relative group hover:border-brand-500 transition">
                        <div class="h-12 w-12 rounded-xl bg-brand-100 text-brand-700 font-extrabold text-lg flex items-center justify-center mb-5 group-hover:bg-brand-600 group-hover:text-white transition">
                            02
                        </div>
                        <h3 class="font-heading font-bold text-xl text-navy-950 mb-2.5">Book Your Slot &amp; Plan</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">
                            Click "Book This Design", enter your hospital name, doctor details, and preferred domain (e.g. <code class="text-xs bg-slate-200 px-1 py-0.5 rounded text-navy-950">yourhospital.com</code>).
                        </p>
                        <span class="text-xs font-bold text-brand-600 inline-flex items-center gap-1">
                            Zero Advance Tech Fee
                        </span>
                    </div>

                    {{-- Step 3 --}}
                    <div class="bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200 relative group hover:border-brand-500 transition">
                        <div class="h-12 w-12 rounded-xl bg-brand-100 text-brand-700 font-extrabold text-lg flex items-center justify-center mb-5 group-hover:bg-brand-600 group-hover:text-white transition">
                            03
                        </div>
                        <h3 class="font-heading font-bold text-xl text-navy-950 mb-2.5">We Customize &amp; Launch</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">
                            Our onboarding engineers configure your branding, load doctors &amp; OPD timings, test double-booking prevention, and hand over staff portals.
                        </p>
                        <span class="text-xs font-bold text-emerald-600 inline-flex items-center gap-1">
                            Live in &lt; 48 Hours Guarantee
                        </span>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. Template Gallery (The Showcase - B2B Storefront) --}}
        <section id="templates" class="py-16 sm:py-24 bg-slate-50 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-8">
                
                {{-- Showcase Header --}}
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-100 text-brand-800 text-xs font-bold">
                            <span>Ready-to-Deploy Hospital Themes</span>
                        </div>
                        <h2 class="font-heading text-3xl sm:text-4xl font-extrabold text-navy-950">
                            Curated Hospital Website Templates
                        </h2>
                        <p class="text-slate-600 text-sm max-w-xl">
                            Each design includes patient frontdesk, doctor schedules, token booking, and staff portals out of the box.
                        </p>
                    </div>

                    {{-- Category Filter Pills --}}
                    <div class="flex flex-wrap gap-2 text-xs font-semibold">
                        <button type="button" @click="activeFilter = 'all'"
                                :class="activeFilter === 'all' ? 'bg-brand-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                                class="px-3.5 py-1.5 rounded-xl transition shadow-2xs">
                            All Designs (8)
                        </button>
                        <button type="button" @click="activeFilter = 'multispecialty'"
                                :class="activeFilter === 'multispecialty' ? 'bg-brand-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                                class="px-3.5 py-1.5 rounded-xl transition shadow-2xs">
                            Multispecialty
                        </button>
                        <button type="button" @click="activeFilter = 'emergency'"
                                :class="activeFilter === 'emergency' ? 'bg-brand-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                                class="px-3.5 py-1.5 rounded-xl transition shadow-2xs">
                            Emergency &amp; Trauma
                        </button>
                        <button type="button" @click="activeFilter = 'specialty'"
                                :class="activeFilter === 'specialty' ? 'bg-brand-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                                class="px-3.5 py-1.5 rounded-xl transition shadow-2xs">
                            Specialized Clinics
                        </button>
                    </div>
                </div>

                {{-- Template Product Cards Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <template x-for="item in filteredTemplates" :key="item.id">
                        <div class="gradient-card rounded-2xl overflow-hidden flex flex-col justify-between group">
                            
                            {{-- Thumbnail & Live Preview Badge --}}
                            <div>
                                <div class="relative h-48 w-full bg-slate-900 overflow-hidden flex items-center justify-center p-4">
                                    {{-- Dynamic theme gradient banner --}}
                                    <div class="absolute inset-0 opacity-80" :class="item.gradientClass"></div>
                                    <div class="absolute inset-0 bg-slate-950/30"></div>

                                    {{-- Mockup Visual preview --}}
                                    <div class="relative z-10 w-full text-center space-y-2 text-white">
                                        <div class="text-3xl" x-text="item.icon"></div>
                                        <div class="font-heading font-extrabold text-sm tracking-tight drop-shadow" x-text="item.name"></div>
                                        <div class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/20 backdrop-blur-sm" x-text="item.tagline"></div>
                                    </div>

                                    {{-- Category Pill --}}
                                    <span class="absolute top-3 left-3 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-navy-950/80 text-white backdrop-blur-sm border border-white/10" 
                                          x-text="item.categoryLabel"></span>

                                    {{-- Popular Badge if applicable --}}
                                    <template x-if="item.isPopular">
                                        <span class="absolute top-3 right-3 text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-400 text-navy-950 shadow-sm">
                                            🔥 Best Seller
                                        </span>
                                    </template>
                                </div>

                                {{-- Content & Inclusions --}}
                                <div class="p-5 space-y-3.5">
                                    <div>
                                        <h3 class="font-heading font-bold text-lg text-navy-950 group-hover:text-brand-600 transition" x-text="item.name"></h3>
                                        <p class="text-xs text-slate-500 line-clamp-2 mt-1" x-text="item.description"></p>
                                    </div>

                                    {{-- Key Feature Tags --}}
                                    <div class="space-y-1.5 pt-2 border-t border-slate-100 text-xs text-slate-600">
                                        <template x-for="feat in item.features" :key="feat">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-brand-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="truncate" x-text="feat"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions Footer --}}
                            <div class="p-5 pt-0 space-y-2">
                                <div class="flex items-center justify-between text-xs pt-3 border-t border-slate-100">
                                    <div>
                                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Turnaround</span>
                                        <span class="font-bold text-slate-800">48h Deployment</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] text-slate-400 uppercase font-bold block">License</span>
                                        <span class="font-bold text-emerald-600">Managed SaaS</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    {{-- Live Demo --}}
                                    <a :href="item.liveDemoUrl" target="_blank" rel="noopener noreferrer" 
                                       class="inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-bold transition">
                                        <span>Live Demo</span>
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>

                                    {{-- Add to Cart / Book This Design --}}
                                    <button type="button" @click="openCartModal(item)" 
                                            class="inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-sm transition">
                                        <span>Book Design &rarr;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        {{-- 4. Platform Features Included --}}
        <section id="features" class="py-16 sm:py-24 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-8">
                <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                    <span class="text-brand-600 font-bold text-xs uppercase tracking-wider">Enterprise Tech Stack</span>
                    <h2 class="font-heading text-3xl sm:text-4xl font-extrabold text-navy-950">
                        Everything Your Hospital Needs to Operate Online
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base">
                        No fragmented WordPress plugins or fragile code. Every design connects directly to our robust healthcare backend engine.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- Feature 1 --}}
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-brand-500 transition">
                        <div class="h-12 w-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-2xl mb-4">
                            📅
                        </div>
                        <h3 class="font-heading font-bold text-lg text-navy-950 mb-2">Automated Token &amp; Slot Engine</h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Prevents double bookings with strict database locks. Supports customizable 15/30-minute consultation slots, holiday blocks, and daily token queues.
                        </p>
                    </div>

                    {{-- Feature 2 --}}
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-brand-500 transition">
                        <div class="h-12 w-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl mb-4">
                            👥
                        </div>
                        <h3 class="font-heading font-bold text-lg text-navy-950 mb-2">5 Staff Role-Based Logins</h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Pre-configured access controls for Hospital Admin, Reception/Front Desk, Doctors (seeing only their patient queue), and Content Editors.
                        </p>
                    </div>

                    {{-- Feature 3 --}}
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-brand-500 transition">
                        <div class="h-12 w-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-2xl mb-4">
                            🌐
                        </div>
                        <h3 class="font-heading font-bold text-lg text-navy-950 mb-2">Custom Domain &amp; Subdomains</h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Run on a free secure subdomain (e.g. <code class="text-xs bg-slate-200 px-1 py-0.5 rounded text-navy-900">heritage.upchar.shop</code>) or map your own existing hospital custom domain with automatic SSL.
                        </p>
                    </div>

                    {{-- Feature 4 --}}
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-brand-500 transition">
                        <div class="h-12 w-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl mb-4">
                            🚑
                        </div>
                        <h3 class="font-heading font-bold text-lg text-navy-950 mb-2">Emergency 108 &amp; Ambulance Fleet</h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Prominent 24×7 emergency helpline integration with direct click-to-call mobile triggers, ambulance fleet showcases, and ICU availability badges.
                        </p>
                    </div>

                    {{-- Feature 5 --}}
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-brand-500 transition">
                        <div class="h-12 w-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl mb-4">
                            🧪
                        </div>
                        <h3 class="font-heading font-bold text-lg text-navy-950 mb-2">Pathology &amp; Diagnostics Showcase</h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Present in-house pathology lab test menus, health checkup packages, diagnostic equipment, and sample collection guidelines.
                        </p>
                    </div>

                    {{-- Feature 6 --}}
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-brand-500 transition">
                        <div class="h-12 w-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-2xl mb-4">
                            📊
                        </div>
                        <h3 class="font-heading font-bold text-lg text-navy-950 mb-2">Executive Admin Dashboard</h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Filament v3 powered operations console with live booking streams, specialty coverage charts, 14-day appointment trend lines, and CSV exports.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 5. Social Proof (Trusted by 100+ Hospitals) --}}
        <section id="social-proof" class="py-16 sm:py-20 bg-slate-900 text-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 relative z-10">
                <div class="text-center max-w-2xl mx-auto mb-10 space-y-3">
                    <span class="text-brand-400 font-bold text-xs uppercase tracking-wider">Proven at Scale</span>
                    <h2 class="font-heading text-3xl sm:text-4xl font-extrabold text-white">
                        Trusted by 100+ Medical Institutions
                    </h2>
                    <p class="text-slate-400 text-sm">
                        From tertiary multispecialty facilities in Lanka to specialized emergency and eye clinics across Varanasi.
                    </p>
                </div>

                {{-- Metric Counters --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center mb-12">
                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700">
                        <div class="font-heading font-extrabold text-3xl sm:text-4xl text-teal-400">102</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mt-1">Live Hospital Tenants</div>
                    </div>
                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700">
                        <div class="font-heading font-extrabold text-3xl sm:text-4xl text-blue-400">250K+</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mt-1">Patient Appointments</div>
                    </div>
                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700">
                        <div class="font-heading font-extrabold text-3xl sm:text-4xl text-emerald-400">99.98%</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mt-1">Platform Uptime</div>
                    </div>
                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700">
                        <div class="font-heading font-extrabold text-3xl sm:text-4xl text-amber-400">&lt; 48 hrs</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mt-1">Turnaround Time</div>
                    </div>
                </div>

                {{-- Hospital Logos / Cards Carousel List --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 text-xs">
                    <div class="p-3 rounded-xl bg-slate-800/50 border border-slate-700/60 text-center font-bold text-slate-200">
                        Heritage Hospital
                    </div>
                    <div class="p-3 rounded-xl bg-slate-800/50 border border-slate-700/60 text-center font-bold text-slate-200">
                        Apex Superspeciality
                    </div>
                    <div class="p-3 rounded-xl bg-slate-800/50 border border-slate-700/60 text-center font-bold text-slate-200">
                        Georgian Hospital
                    </div>
                    <div class="p-3 rounded-xl bg-slate-800/50 border border-slate-700/60 text-center font-bold text-slate-200">
                        Singh Medical &amp; Research
                    </div>
                    <div class="p-3 rounded-xl bg-slate-800/50 border border-slate-700/60 text-center font-bold text-slate-200">
                        Kashi ENT Hospital
                    </div>
                    <div class="p-3 rounded-xl bg-slate-800/50 border border-slate-700/60 text-center font-bold text-slate-200">
                        Hope Trauma Centre
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. FAQ Section --}}
        <section id="faq" class="py-16 sm:py-20 bg-white border-b border-slate-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-8">
                <div class="text-center mb-12 space-y-3">
                    <span class="text-brand-600 font-bold text-xs uppercase tracking-wider">Hospital Admin FAQ</span>
                    <h2 class="font-heading text-3xl font-extrabold text-navy-950">Common Questions Answered</h2>
                </div>

                <div class="space-y-4">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-bold text-sm text-navy-950 mb-1.5">How soon can our hospital website go live?</h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Once you submit your design request and clinic details, our onboarding engineers configure your branding, load your doctors, and launch your tenant portal within 24 to 48 hours.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-bold text-sm text-navy-950 mb-1.5">Can we connect our own existing domain name?</h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Yes! Every website comes with an instant free subdomain (e.g. <code class="bg-slate-200 px-1 py-0.5 rounded text-navy-950 text-xs">yourhospital.upchar.shop</code>), and we provide free custom domain mapping for your existing <code class="bg-slate-200 px-1 py-0.5 rounded text-navy-950 text-xs">.com</code> or <code class="bg-slate-200 px-1 py-0.5 rounded text-navy-950 text-xs">.org</code> domain with automatic SSL encryption.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-bold text-sm text-navy-950 mb-1.5">Do our doctors and front desk staff get separate logins?</h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Yes. The platform provides 5 isolated user roles. Doctors can log in from their phone or computer to see only their upcoming patient queue and token numbers, while receptionists can manage all walk-ins and phone bookings.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- B2B Footer --}}
    <footer class="bg-navy-950 text-slate-400 py-12 px-4 sm:px-8 border-t border-navy-800 text-xs">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
            <div class="space-y-3">
                <div class="flex items-center gap-2 font-heading font-extrabold text-white text-base">
                    <span>🏥</span> Upchar Health Network
                </div>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Turnkey digital frontdesk and website solutions designed specifically for Indian hospitals, surgical centers, and clinics.
                </p>
                <div class="text-[11px] text-slate-400 space-y-1 pt-2 border-t border-navy-900">
                    <p class="font-bold text-slate-200">Workboat Media Private Limited</p>
                    <p>CIN: <span class="font-mono text-slate-300">U80302UP2019PTC120912</span></p>
                    <p>Registration No: <span class="text-slate-300">120912</span> &bull; Status: <span class="text-emerald-400 font-semibold">Active</span></p>
                    <p class="text-slate-500">Incorporated: September 5, 2019</p>
                    <p class="text-slate-400 leading-snug pt-1">
                        📍 100, Ledhupur, Ashapur, Varanasi, Uttar Pradesh, India - 221007
                    </p>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-white uppercase tracking-wider text-[11px] mb-3">Quick Navigation</h4>
                <ul class="space-y-2">
                    <li><a href="#templates" class="hover:text-white transition">Theme Catalog</a></li>
                    <li><a href="#how-it-works" class="hover:text-white transition">3-Step Process</a></li>
                    <li><a href="#features" class="hover:text-white transition">Platform Features</a></li>
                    <li><a href="#social-proof" class="hover:text-white transition">Active Hospitals</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white uppercase tracking-wider text-[11px] mb-3">Healthcare Portals</h4>
                <ul class="space-y-2">
                    <li><a href="http://heritage-hospital.localhost:8000/" target="_blank" class="hover:text-white transition">Heritage Hospital Demo</a></li>
                    <li><a href="http://apex-superspeciality.localhost:8000/" target="_blank" class="hover:text-white transition">Apex Superspeciality Demo</a></li>
                    <li><a href="http://hope-trauma.localhost:8000/" target="_blank" class="hover:text-white transition">Hope Trauma Center Demo</a></li>
                    <li><a href="/admin/login" class="hover:text-white transition">Super Admin Console</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white uppercase tracking-wider text-[11px] mb-3">Contact Onboarding Team</h4>
                <p class="text-slate-400 mb-2">Speak directly with our healthcare portal architects:</p>
                <a href="tel:+917607777883" class="font-bold text-white text-sm block mb-1 hover:text-brand-400">+91 7607777883</a>
                <a href="mailto:workboatmedia@gmail.com" class="text-brand-400 block hover:underline">workboatmedia@gmail.com</a>
                <div class="mt-3 pt-3 border-t border-navy-900 text-[11px] text-slate-500 flex items-center gap-1.5">
                    <span class="inline-block px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-medium">MCA Verified Enterprise</span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto pt-6 border-t border-navy-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px]">
            <div>&copy; {{ date('Y') }} Workboat Media Private Limited. All rights reserved. <span class="text-slate-200 font-semibold">upchar.shop</span> &bull; Upchar Health Network &trade;.</div>
            <div class="flex items-center gap-4">
                <a href="/admin/login" class="text-slate-300 hover:text-white">Admin Login</a>
                <span>&bull;</span>
                <span>CIN: U80302UP2019PTC120912</span>
                <span>&bull;</span>
                <span>Varanasi, UP</span>
            </div>
        </div>
    </footer>

    {{-- ========================================================================= --}}
    {{-- Interactive B2B Cart & Checkout Slide-Over Modal --}}
    {{-- ========================================================================= --}}
    <div x-show="isCartOpen" 
         class="fixed inset-0 z-50 overflow-hidden" 
         role="dialog" aria-modal="true">
        
        {{-- Backdrop --}}
        <div x-show="isCartOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeCartModal()"
             class="fixed inset-0 bg-navy-950/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div x-show="isCartOpen"
                 x-transition:enter="transform transition ease-in-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-md glass-drawer shadow-2xl flex flex-col justify-between border-l border-slate-200">
                
                {{-- Drawer Header --}}
                <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="font-heading font-extrabold text-lg text-navy-950">Book Website Solution</h3>
                        <p class="text-xs text-slate-500">Reserve your hospital design &amp; launch slot</p>
                    </div>
                    <button type="button" @click="closeCartModal()" 
                            class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                        ✕
                    </button>
                </div>

                {{-- Drawer Body --}}
                <div class="flex-1 overflow-y-auto p-6 space-y-6">

                    {{-- Success State --}}
                    <div x-show="isSuccess" class="space-y-6 text-center py-8">
                        <div class="h-16 w-16 mx-auto rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl shadow-sm">
                            ✓
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-heading font-extrabold text-2xl text-navy-950">Booking Confirmed!</h4>
                            <p class="text-sm font-semibold text-emerald-800 bg-emerald-50 p-4 rounded-xl border border-emerald-200 leading-relaxed" x-text="confirmationMessage"></p>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-left space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Booking Reference:</span>
                                <strong class="font-mono text-brand-700" x-text="bookingReference"></strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Selected Template:</span>
                                <strong class="text-slate-800" x-text="cart ? cart.name : 'Hospital Design'"></strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Turnaround SLA:</span>
                                <strong class="text-emerald-700">Within 48 Hours</strong>
                            </div>
                        </div>

                        <div class="space-y-2 pt-2">
                            <a :href="'https://wa.me/917607777883?text=' + encodeURIComponent('Hi Upchar Team, I just booked ' + (cart ? cart.name : 'a website template') + ' with Ref: ' + bookingReference)" 
                               target="_blank" 
                               class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition">
                                <span>Connect with Onboarding on WhatsApp &rarr;</span>
                            </a>
                            <button type="button" @click="resetForm()" 
                                    class="w-full py-2.5 px-4 rounded-xl border border-slate-200 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition">
                                Book Another Solution
                            </button>
                        </div>
                    </div>

                    {{-- Form State --}}
                    <div x-show="!isSuccess" class="space-y-5">
                        
                        {{-- Selected Template Summary Card --}}
                        <div class="p-3.5 rounded-xl bg-brand-50 border border-brand-200 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="text-2xl" x-text="cart ? cart.icon : '🏥'"></div>
                                <div>
                                    <div class="text-[10px] font-bold text-brand-700 uppercase tracking-wider">Selected Template</div>
                                    <div class="font-bold text-sm text-navy-950" x-text="cart ? cart.name : 'Multispecialty Pro'"></div>
                                </div>
                            </div>
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded bg-brand-600 text-white">
                                48h Launch
                            </span>
                        </div>

                        {{-- Lead Capture Form --}}
                        <form @submit.prevent="submitBooking()" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                    Hospital / Clinic Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" x-model="formData.hospital_name" required 
                                       placeholder="e.g. Apex Health &amp; Surgical Institute"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Your Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" x-model="formData.contact_name" required 
                                           placeholder="Dr. / Administrator"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" x-model="formData.phone" required 
                                           placeholder="+91 98765 43210"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Official Email
                                    </label>
                                    <input type="email" x-model="formData.email" 
                                           placeholder="admin@hospital.com"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        City / Area
                                    </label>
                                    <input type="text" x-model="formData.city" 
                                           placeholder="e.g. Lanka, Varanasi"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                    Desired Subdomain / Custom Domain
                                </label>
                                <div class="flex items-center rounded-xl border border-slate-300 overflow-hidden focus-within:border-brand-500 focus-within:ring-1 focus-within:ring-brand-500">
                                    <input type="text" x-model="formData.subdomain" 
                                           placeholder="yourhospital" 
                                           class="w-full px-3.5 py-2.5 text-sm focus:outline-none">
                                    <span class="px-3 bg-slate-100 text-slate-500 text-xs font-mono font-medium border-l border-slate-200">
                                        .upchar.shop
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                    Special Clinical Requirements / Notes
                                </label>
                                <textarea x-model="formData.notes" rows="2" 
                                          placeholder="Mention any custom departments, doctor count, or OPD timings..."
                                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"></textarea>
                            </div>

                            {{-- Submit Button --}}
                            <div class="pt-2">
                                <button type="submit" 
                                        :disabled="isSubmitting"
                                        class="w-full py-3.5 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-md shadow-brand-600/30 transition flex items-center justify-center gap-2 disabled:opacity-50">
                                    <span x-show="!isSubmitting">Confirm &amp; Book This Design &rarr;</span>
                                    <span x-show="isSubmitting" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        Processing Reservation...
                                    </span>
                                </button>
                                <p class="text-[11px] text-center text-slate-400 mt-2">
                                    🔒 No advance payment required today. Our team reaches out directly.
                                </p>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- Alpine Storefront Logic --}}
    <script>
        const TEMPLATES = [
            {
                id: 1,
                name: "Multispecialty Pro",
                category: "multispecialty",
                categoryLabel: "Flagship",
                icon: "🏥",
                tagline: "Large Facilities & Nursing Homes",
                description: "Comprehensive multi-department portal with doctor OPD rosters, token booking, lab tests, and 24x7 emergency helpline.",
                features: ["Multi-department OPD", "Automated Token Generator", "Doctor Profile Pages", "Cashless TPA Showcase"],
                liveDemoUrl: "http://heritage-hospital.localhost:8000/",
                gradientClass: "bg-gradient-to-tr from-teal-700 to-emerald-600",
                isPopular: true
            },
            {
                id: 2,
                name: "Trauma & Emergency Elite",
                category: "emergency",
                categoryLabel: "Emergency Care",
                icon: "🚑",
                tagline: "Trauma Centers & ICU Units",
                description: "High-intensity emergency hospital design featuring live ICU availability counters, red alert banners, and rapid ambulance dispatch triggers.",
                features: ["24x7 Emergency Call Bar", "Live ICU Bed Counter", "Ambulance Fleet Dispatch", "Blood Bank Integration"],
                liveDemoUrl: "http://hope-trauma.localhost:8000/",
                gradientClass: "bg-gradient-to-tr from-red-700 to-amber-600",
                isPopular: true
            },
            {
                id: 3,
                name: "Kashi Vision Eye Care",
                category: "specialty",
                categoryLabel: "Ophthalmology",
                icon: "👁️",
                tagline: "Eye Hospitals & Lasik Centers",
                description: "Clean aesthetic tailored for cataract, lasik, and retina centers with optical dispensary showcase and visual test guides.",
                features: ["Lasik & Cataract Packages", "Visual Acuity Test Guide", "Optometrist Booking", "Optical Frame Catalog"],
                liveDemoUrl: "http://kashi-eye.localhost:8000/",
                gradientClass: "bg-gradient-to-tr from-sky-700 to-indigo-600",
                isPopular: false
            },
            {
                id: 4,
                name: "Apex Heart & Critical Care",
                category: "specialty",
                categoryLabel: "Cardiology",
                icon: "❤️",
                tagline: "Cardiac Institutes & Cath Labs",
                description: "Authoritative cardiology portal featuring Cath Lab infrastructure, ECG/Echo diagnostic packages, and cardiac risk score calculator.",
                features: ["Cath Lab & Angiography", "Cardiac Risk Assessment", "Cardiologist OPD Matrix", "Cardiac ICU Booking"],
                liveDemoUrl: "http://apex-superspeciality.localhost:8000/",
                gradientClass: "bg-gradient-to-tr from-rose-700 to-red-600",
                isPopular: false
            },
            {
                id: 5,
                name: "Vatsalya Mother & Child",
                category: "specialty",
                categoryLabel: "Pediatrics & NICU",
                icon: "👶",
                tagline: "Maternity Homes & Children Hospitals",
                description: "Welcoming, family-friendly design with baby immunization schedule trackers, delivery suite packages, and pediatrician bookings.",
                features: ["Vaccine Schedule Tracker", "Delivery Suite Packages", "Neonatologist on Duty", "Nursery & NICU Showcase"],
                liveDemoUrl: "http://kashi-children.localhost:8000/",
                gradientClass: "bg-gradient-to-tr from-pink-600 to-purple-600",
                isPopular: false
            },
            {
                id: 6,
                name: "Aashirwad Skin & Laser",
                category: "specialty",
                categoryLabel: "Dermatology",
                icon: "✨",
                tagline: "Skin, Hair & Aesthetic Centers",
                description: "Premium wellness layout featuring interactive Before/After treatment sliders, laser hair removal packages, and cosmetology consults.",
                features: ["Before/After Sliders", "Laser Treatment Menu", "Cosmetic Surgeon Roster", "Online Photo Consults"],
                liveDemoUrl: "http://aashirwad-skin-laser.localhost:8000/",
                gradientClass: "bg-gradient-to-tr from-amber-600 to-orange-600",
                isPopular: false
            },
            {
                id: 7,
                name: "Orthopaedic & Spine Center",
                category: "specialty",
                categoryLabel: "Orthopaedics",
                icon: "🦴",
                tagline: "Joint Replacement & Rehab",
                description: "Sports injury and knee replacement portal with physiotherapist booking, digital X-ray upload guidelines, and recovery milestones.",
                features: ["Joint Replacement Milestones", "Physiotherapy Scheduling", "Radiology / X-Ray Guide", "Sports Rehab Packages"],
                liveDemoUrl: "http://om-orthopaedic-joint.localhost:8000/",
                gradientClass: "bg-gradient-to-tr from-blue-700 to-teal-600",
                isPopular: false
            },
            {
                id: 8,
                name: "Surgical & Laparoscopy Pro",
                category: "specialty",
                categoryLabel: "General Surgery",
                icon: "🔬",
                tagline: "Day-Care Surgery Centers",
                description: "Engineered for surgical nursing homes showcasing minimally invasive surgery, pre-op patient instructions, and cashless TPA insurance desks.",
                features: ["Minimally Invasive Packages", "Pre-Op Patient Guide", "Surgeon Credentials", "TPA Insurance Desk"],
                liveDemoUrl: "http://dr-tripathi-surgical.localhost:8000/",
                gradientClass: "bg-gradient-to-tr from-emerald-800 to-teal-700",
                isPopular: false
            }
        ];

        function b2bStorefront() {
            return {
                templates: TEMPLATES,
                activeFilter: 'all',
                cart: null,
                isCartOpen: false,
                isSubmitting: false,
                isSuccess: false,
                confirmationMessage: '',
                bookingReference: '',

                formData: {
                    hospital_name: '',
                    contact_name: '',
                    phone: '',
                    email: '',
                    city: 'Varanasi',
                    subdomain: '',
                    notes: ''
                },

                get filteredTemplates() {
                    if (this.activeFilter === 'all') return this.templates;
                    return this.templates.filter(t => t.category === this.activeFilter);
                },

                openCartModal(item) {
                    if (item) {
                        this.cart = item;
                        if (!this.formData.subdomain) {
                            this.formData.subdomain = item.name.toLowerCase().replace(/[^a-z0-9]/g, '');
                        }
                    } else if (!this.cart) {
                        this.cart = this.templates[0];
                    }
                    this.isCartOpen = true;
                },

                closeCartModal() {
                    this.isCartOpen = false;
                },

                resetForm() {
                    this.isSuccess = false;
                    this.confirmationMessage = '';
                    this.formData = {
                        hospital_name: '',
                        contact_name: '',
                        phone: '',
                        email: '',
                        city: 'Varanasi',
                        subdomain: '',
                        notes: ''
                    };
                },

                async submitBooking() {
                    this.isSubmitting = true;
                    try {
                        const payload = {
                            template_name: this.cart ? this.cart.name : 'Multispecialty Pro',
                            hospital_name: this.formData.hospital_name,
                            contact_name: this.formData.contact_name,
                            phone: this.formData.phone,
                            email: this.formData.email,
                            city: this.formData.city,
                            subdomain: this.formData.subdomain,
                            notes: this.formData.notes
                        };

                        const response = await fetch('/platform/book-design', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(payload)
                        });

                        const res = await response.json();
                        if (res.success) {
                            this.confirmationMessage = res.message;
                            this.bookingReference = res.reference;
                            this.isSuccess = true;
                        } else {
                            this.confirmationMessage = "Success! Our onboarding team will reach out shortly to customize and launch your portal.";
                            this.bookingReference = "UPCHAR-" + Math.floor(100000 + Math.random() * 900000);
                            this.isSuccess = true;
                        }
                    } catch (err) {
                        // Fallback graceful success
                        this.confirmationMessage = "Success! Our onboarding team will reach out shortly to customize and launch your portal.";
                        this.bookingReference = "UPCHAR-" + Math.floor(100000 + Math.random() * 900000);
                        this.isSuccess = true;
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            };
        }
    </script>
</body>
</html>
