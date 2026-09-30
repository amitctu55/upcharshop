{{-- Antigravity Custom Healthcare Admin Design System --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
    :root {
        --font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }

    body, .fi-body {
        font-family: var(--font-family) !important;
        letter-spacing: -0.011em;
    }

    /* Modern Glassmorphic Topbar */
    .fi-topbar {
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        background: rgba(255, 255, 255, 0.85) !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
        transition: all 0.2s ease;
    }
    .dark .fi-topbar {
        background: rgba(15, 23, 42, 0.85) !important;
        border-bottom: 1px solid rgba(30, 41, 59, 0.7) !important;
    }

    /* Sleek Sidebar Styling */
    .fi-sidebar {
        border-right: 1px solid rgba(226, 232, 240, 0.8) !important;
        background: #ffffff !important;
    }
    .dark .fi-sidebar {
        background: #0b0f19 !important;
        border-right: 1px solid rgba(30, 41, 59, 0.7) !important;
    }

    .fi-sidebar-item-button {
        border-radius: 0.75rem !important;
        margin-left: 0.25rem !important;
        margin-right: 0.25rem !important;
        font-weight: 500 !important;
        transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .fi-sidebar-item-button:hover {
        transform: translateX(3px);
    }
    .fi-sidebar-item-active .fi-sidebar-item-button {
        font-weight: 700 !important;
        box-shadow: 0 4px 12px -2px rgba(13, 148, 136, 0.25) !important;
    }

    /* Cards, Panels & Stats Elevation */
    .fi-section, .fi-wi-stats-overview-stat, .fi-wi-chart, .fi-ta-ctn {
        border-radius: 1rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 10px 25px -5px rgba(0, 0, 0, 0.03) !important;
        border: 1px solid rgba(226, 232, 240, 0.9) !important;
        transition: all 0.2s ease-in-out !important;
    }
    .dark .fi-section, .dark .fi-wi-stats-overview-stat, .dark .fi-wi-chart, .dark .fi-ta-ctn {
        border-color: rgba(30, 41, 59, 0.8) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25) !important;
        background: #0f172a !important;
    }

    .fi-wi-stats-overview-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.08) !important;
    }

    /* Modern Table Rows */
    .fi-ta-row {
        transition: background-color 0.12s ease;
    }
    .fi-ta-row:hover {
        background-color: rgba(248, 250, 252, 0.8) !important;
    }
    .dark .fi-ta-row:hover {
        background-color: rgba(30, 41, 59, 0.5) !important;
    }

    /* Button Polish */
    .fi-btn {
        border-radius: 0.75rem !important;
        font-weight: 600 !important;
        letter-spacing: -0.01em !important;
        transition: all 0.15s ease !important;
    }
    .fi-btn-primary {
        box-shadow: 0 4px 14px -2px rgba(13, 148, 136, 0.35) !important;
    }
    .fi-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px -2px rgba(13, 148, 136, 0.45) !important;
    }

    /* Input Fields Polish */
    .fi-input-wrp {
        border-radius: 0.75rem !important;
        border-color: rgba(203, 213, 225, 0.8) !important;
        transition: all 0.15s ease !important;
    }
    .fi-input-wrp:focus-within {
        border-color: rgb(13, 148, 136) !important;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12) !important;
    }

    /* Custom subtle scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.4);
        border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.7);
    }
</style>
