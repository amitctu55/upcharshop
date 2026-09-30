{{-- ============================================================
     Upchar.shop — Premium Admin Design System v2.0
     Workboat Media Private Limited | upchar.shop
     ============================================================ --}}

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
/* ============================================================
   GLOBAL TOKENS & FONT
   ============================================================ */
:root {
    --font-base: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    --font-heading: 'Bricolage Grotesque', sans-serif;
    --font-mono: 'JetBrains Mono', monospace;

    /* Premium Medical Teal Palette */
    --brand-50:  #f0fdfa;
    --brand-100: #ccfbf1;
    --brand-400: #2dd4bf;
    --brand-500: #14b8a6;
    --brand-600: #0d9488;
    --brand-700: #0f766e;
    --brand-800: #115e59;
    --brand-900: #134e4a;

    --sidebar-w: 280px;
    --topbar-h: 64px;
    --radius-card: 16px;
    --radius-btn: 12px;
}

body, .fi-body {
    font-family: var(--font-base) !important;
    letter-spacing: -0.012em;
    -webkit-font-smoothing: antialiased;
}

/* ============================================================
   TOPBAR — Glassmorphic Premium
   ============================================================ */
.fi-topbar {
    height: var(--topbar-h) !important;
    backdrop-filter: blur(20px) saturate(200%) !important;
    -webkit-backdrop-filter: blur(20px) saturate(200%) !important;
    background: rgba(255, 255, 255, 0.88) !important;
    border-bottom: 1px solid rgba(226, 232, 240, 0.9) !important;
    box-shadow: 0 1px 0 rgba(15, 23, 42, 0.04),
                0 4px 16px -4px rgba(15, 23, 42, 0.06) !important;
    transition: all 0.25s ease !important;
    position: sticky;
    top: 0;
    z-index: 50;
}
.dark .fi-topbar {
    background: rgba(10, 14, 26, 0.90) !important;
    border-bottom: 1px solid rgba(30, 41, 59, 0.8) !important;
    box-shadow: 0 1px 0 rgba(0,0,0,0.3), 0 4px 16px -4px rgba(0,0,0,0.4) !important;
}

/* ============================================================
   SIDEBAR — Premium Dark-Accented White
   ============================================================ */
.fi-sidebar {
    width: var(--sidebar-w) !important;
    background: #ffffff !important;
    border-right: 1px solid rgba(226, 232, 240, 0.8) !important;
    box-shadow: 4px 0 24px -8px rgba(15, 23, 42, 0.06) !important;
}
.dark .fi-sidebar {
    background: #080c18 !important;
    border-right: 1px solid rgba(30, 41, 59, 0.9) !important;
    box-shadow: 4px 0 24px -8px rgba(0, 0, 0, 0.4) !important;
}

/* Sidebar Header / Brand */
.fi-sidebar-header {
    padding: 20px 18px !important;
    border-bottom: 1px solid rgba(226, 232, 240, 0.7) !important;
}
.dark .fi-sidebar-header {
    border-bottom: 1px solid rgba(30, 41, 59, 0.7) !important;
}
.fi-brand-name {
    font-family: var(--font-heading) !important;
    font-weight: 800 !important;
    font-size: 1.05rem !important;
    letter-spacing: -0.02em !important;
    color: #0f172a !important;
    line-height: 1.2 !important;
}
.dark .fi-brand-name { color: #f1f5f9 !important; }

/* Sidebar Group Headers & Alignment */
.fi-sidebar-group-header,
.fi-sidebar-group-button {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 14px 16px 6px !important;
    width: 100% !important;
}
.fi-sidebar-group-header > *,
.fi-sidebar-group-button > * {
    display: flex !important;
    align-items: center !important;
}
.fi-sidebar-group-header svg,
.fi-sidebar-group-button svg {
    align-self: center !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    opacity: 0.65;
}
.fi-sidebar-group-label {
    font-size: 0.68rem !important;
    font-weight: 700 !important;
    letter-spacing: 0.04em !important;
    text-transform: capitalize !important;
    color: #475569 !important;
    display: inline-flex !important;
    align-items: center !important;
}
.dark .fi-sidebar-group-label { color: #94a3b8 !important; }

/* Sidebar Nav Items */
.fi-sidebar-item-button {
    border-radius: 0.85rem !important;
    margin: 2px 10px !important;
    padding: 9px 14px !important;
    font-size: 0.83rem !important;
    font-weight: 500 !important;
    color: #334155 !important;
    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative;
    overflow: hidden;
}
.dark .fi-sidebar-item-button { color: #cbd5e1 !important; }

.fi-sidebar-item-button:hover {
    background: rgba(13, 148, 136, 0.08) !important;
    color: #0f766e !important;
    transform: translateX(3px) !important;
}
.dark .fi-sidebar-item-button:hover {
    background: rgba(13, 148, 136, 0.15) !important;
    color: #2dd4bf !important;
}

/* Active State — High Contrast Solid White on Vibrant Teal */
.fi-sidebar-item-active .fi-sidebar-item-button,
.fi-sidebar-item-active > a,
.fi-sidebar-item-active[aria-current="page"] {
    background: #0d9488 !important;
    background: linear-gradient(135deg, #0d9488, #0f766e) !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    box-shadow: 0 4px 16px -3px rgba(13, 148, 136, 0.50),
                0 2px 6px -2px rgba(13, 148, 136, 0.3) !important;
    transform: translateX(0) !important;
}
.dark .fi-sidebar-item-active .fi-sidebar-item-button {
    background: linear-gradient(135deg, #0d9488, #115e59) !important;
}

.fi-sidebar-item-active .fi-sidebar-item-button span,
.fi-sidebar-item-active .fi-sidebar-item-button .fi-sidebar-item-label,
.fi-sidebar-item-active .fi-sidebar-item-button svg,
.fi-sidebar-item-active .fi-sidebar-item-button .fi-icon {
    color: #ffffff !important;
    fill: currentColor !important;
    opacity: 1 !important;
}

/* Sidebar Icon */
.fi-sidebar-item-button .fi-icon {
    width: 18px !important;
    height: 18px !important;
    opacity: 0.75;
}
.fi-sidebar-item-active .fi-sidebar-item-button .fi-icon {
    opacity: 1 !important;
    color: #ffffff !important;
}

/* Sidebar divider */
.fi-sidebar-nav { padding: 8px 0 !important; }

/* ============================================================
   MAIN CONTENT AREA
   ============================================================ */
.fi-main {
    background: #f8fafc !important;
}
.dark .fi-main {
    background: #060a14 !important;
}

/* ============================================================
   PAGE HEADER
   ============================================================ */
.fi-header {
    padding: 24px 32px 20px !important;
    border-bottom: 1px solid rgba(226, 232, 240, 0.7) !important;
    background: rgba(255,255,255,0.6) !important;
    backdrop-filter: blur(12px) !important;
}
.dark .fi-header {
    background: rgba(10,14,26,0.6) !important;
    border-bottom: 1px solid rgba(30,41,59,0.6) !important;
}
.fi-header-heading {
    font-family: var(--font-heading) !important;
    font-size: 1.6rem !important;
    font-weight: 800 !important;
    letter-spacing: -0.03em !important;
    color: #0f172a !important;
}
.dark .fi-header-heading { color: #f0f6ff !important; }

/* Breadcrumbs */
.fi-breadcrumbs-item { font-size: 0.75rem !important; }

/* ============================================================
   CARDS, SECTIONS, PANELS
   ============================================================ */
.fi-section {
    border-radius: var(--radius-card) !important;
    border: 1px solid rgba(226, 232, 240, 0.85) !important;
    background: #ffffff !important;
    box-shadow: 0 1px 3px rgba(15,23,42,0.04),
                0 8px 24px -6px rgba(15,23,42,0.05) !important;
    transition: box-shadow 0.2s ease, transform 0.2s ease !important;
    overflow: hidden !important;
}
.fi-section:hover {
    box-shadow: 0 2px 8px rgba(15,23,42,0.06),
                0 16px 32px -8px rgba(15,23,42,0.08) !important;
}
.dark .fi-section {
    background: #0d1322 !important;
    border-color: rgba(30,41,59,0.9) !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.35) !important;
}
.fi-section-header {
    padding: 18px 24px !important;
    border-bottom: 1px solid rgba(226,232,240,0.6) !important;
    font-weight: 700 !important;
    font-size: 0.88rem !important;
}
.dark .fi-section-header { border-bottom-color: rgba(30,41,59,0.7) !important; }

/* ============================================================
   STATS OVERVIEW WIDGETS
   ============================================================ */
.fi-wi-stats-overview-stat {
    border-radius: var(--radius-card) !important;
    border: 1px solid rgba(226,232,240,0.8) !important;
    background: #ffffff !important;
    box-shadow: 0 1px 3px rgba(15,23,42,0.04), 0 8px 24px -6px rgba(15,23,42,0.04) !important;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1) !important;
    overflow: hidden !important;
    position: relative;
}
.fi-wi-stats-overview-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--brand-500), var(--brand-400));
    opacity: 0;
    transition: opacity 0.2s ease;
}
.fi-wi-stats-overview-stat:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 12px 32px -8px rgba(13,148,136,0.18) !important;
}
.fi-wi-stats-overview-stat:hover::before { opacity: 1; }
.dark .fi-wi-stats-overview-stat {
    background: #0d1322 !important;
    border-color: rgba(30,41,59,0.9) !important;
}

/* Stat Value */
.fi-wi-stats-overview-stat-value {
    font-family: var(--font-heading) !important;
    font-weight: 800 !important;
    letter-spacing: -0.03em !important;
    font-size: 2rem !important;
}

/* ============================================================
   CHART WIDGETS
   ============================================================ */
.fi-wi-chart {
    border-radius: var(--radius-card) !important;
    border: 1px solid rgba(226,232,240,0.85) !important;
    background: #ffffff !important;
    box-shadow: 0 1px 3px rgba(15,23,42,0.04), 0 8px 24px -6px rgba(15,23,42,0.04) !important;
    overflow: hidden !important;
}
.dark .fi-wi-chart {
    background: #0d1322 !important;
    border-color: rgba(30,41,59,0.9) !important;
}

/* ============================================================
   DATA TABLES
   ============================================================ */
.fi-ta-ctn {
    border-radius: var(--radius-card) !important;
    border: 1px solid rgba(226,232,240,0.85) !important;
    overflow: hidden !important;
    box-shadow: 0 1px 3px rgba(15,23,42,0.04), 0 8px 24px -6px rgba(15,23,42,0.04) !important;
}
.dark .fi-ta-ctn { border-color: rgba(30,41,59,0.9) !important; }

/* Table Header */
.fi-ta-header-cell {
    font-size: 0.7rem !important;
    font-weight: 700 !important;
    letter-spacing: 0.06em !important;
    text-transform: uppercase !important;
    color: #94a3b8 !important;
    background: #f8fafc !important;
    padding: 12px 16px !important;
    border-bottom: 1px solid rgba(226,232,240,0.8) !important;
}
.dark .fi-ta-header-cell {
    background: #0a0f1e !important;
    color: #475569 !important;
    border-bottom-color: rgba(30,41,59,0.8) !important;
}

/* Table Rows */
.fi-ta-row {
    transition: background-color 0.12s ease !important;
    border-bottom: 1px solid rgba(241,245,249,0.9) !important;
}
.fi-ta-row:hover {
    background-color: rgba(240, 253, 250, 0.7) !important;
}
.dark .fi-ta-row {
    border-bottom-color: rgba(30,41,59,0.5) !important;
}
.dark .fi-ta-row:hover {
    background-color: rgba(13,148,136,0.06) !important;
}
.fi-ta-cell {
    padding: 13px 16px !important;
    font-size: 0.83rem !important;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.fi-btn {
    border-radius: var(--radius-btn) !important;
    font-weight: 600 !important;
    font-size: 0.82rem !important;
    letter-spacing: -0.01em !important;
    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1) !important;
    height: auto !important;
}
.fi-btn-primary {
    background: linear-gradient(135deg, var(--brand-600), var(--brand-700)) !important;
    box-shadow: 0 4px 16px -4px rgba(13,148,136,0.40) !important;
    border: none !important;
}
.fi-btn-primary:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 8px 24px -4px rgba(13,148,136,0.50) !important;
}
.fi-btn-primary:active { transform: translateY(0) !important; }

.fi-btn-secondary, .fi-btn-outlined {
    border-color: rgba(203,213,225,0.9) !important;
    color: #374151 !important;
}
.dark .fi-btn-secondary, .dark .fi-btn-outlined {
    border-color: rgba(30,41,59,0.9) !important;
    color: #cbd5e1 !important;
    background: rgba(30,41,59,0.5) !important;
}

/* Danger button */
.fi-btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    box-shadow: 0 4px 16px -4px rgba(239,68,68,0.40) !important;
}

/* ============================================================
   FORM INPUTS
   ============================================================ */
.fi-input-wrp {
    border-radius: 0.75rem !important;
    border-color: rgba(203,213,225,0.85) !important;
    background: #ffffff !important;
    transition: all 0.15s ease !important;
    overflow: hidden !important;
}
.dark .fi-input-wrp {
    background: #0d1322 !important;
    border-color: rgba(30,41,59,0.9) !important;
}
.fi-input-wrp:focus-within {
    border-color: var(--brand-500) !important;
    box-shadow: 0 0 0 3px rgba(13,148,136,0.14) !important;
}

.fi-input {
    font-size: 0.875rem !important;
    padding: 10px 14px !important;
}

.fi-fo-field-wrp-label {
    font-size: 0.8rem !important;
    font-weight: 600 !important;
    color: #374151 !important;
    letter-spacing: -0.005em !important;
    margin-bottom: 6px !important;
}
.dark .fi-fo-field-wrp-label { color: #94a3b8 !important; }

/* Select */
.fi-select-input {
    border-radius: 0.75rem !important;
    font-size: 0.875rem !important;
}

/* Tabs */
.fi-tabs-tab {
    border-radius: 0.7rem !important;
    font-weight: 600 !important;
    font-size: 0.82rem !important;
    transition: all 0.15s ease !important;
}
.fi-tabs-tab-active {
    background: linear-gradient(135deg, var(--brand-600), var(--brand-700)) !important;
    color: #ffffff !important;
    box-shadow: 0 3px 12px -3px rgba(13,148,136,0.4) !important;
}

/* ============================================================
   BADGES / PILL STATUS LABELS
   ============================================================ */
.fi-badge {
    border-radius: 9999px !important;
    font-size: 0.68rem !important;
    font-weight: 700 !important;
    letter-spacing: 0.04em !important;
    text-transform: uppercase !important;
    padding: 3px 10px !important;
}

/* ============================================================
   MODAL / SLIDE-OVER
   ============================================================ */
.fi-modal-window {
    border-radius: 1.25rem !important;
    overflow: hidden !important;
    box-shadow: 0 25px 80px -12px rgba(15,23,42,0.30) !important;
    border: 1px solid rgba(226,232,240,0.8) !important;
}
.dark .fi-modal-window {
    background: #0d1322 !important;
    border-color: rgba(30,41,59,0.9) !important;
    box-shadow: 0 25px 80px -12px rgba(0,0,0,0.6) !important;
}
.fi-modal-header {
    padding: 22px 28px !important;
    border-bottom: 1px solid rgba(226,232,240,0.8) !important;
    font-family: var(--font-heading) !important;
    font-weight: 800 !important;
}

/* ============================================================
   NOTIFICATIONS / TOASTS
   ============================================================ */
.fi-notifications {
    right: 24px !important;
    bottom: 24px !important;
}
.fi-notification {
    border-radius: 1rem !important;
    border: 1px solid rgba(226,232,240,0.8) !important;
    box-shadow: 0 8px 32px -8px rgba(15,23,42,0.20) !important;
    backdrop-filter: blur(12px) !important;
}
.dark .fi-notification {
    background: #0d1322 !important;
    border-color: rgba(30,41,59,0.9) !important;
}

/* ============================================================
   PAGINATION
   ============================================================ */
.fi-pagination-nav {
    border-top: 1px solid rgba(226,232,240,0.7) !important;
    padding: 16px 20px !important;
}
.fi-pagination-item-btn {
    border-radius: 0.6rem !important;
    font-size: 0.78rem !important;
    font-weight: 600 !important;
    min-width: 36px !important;
    height: 36px !important;
}
.fi-pagination-item-btn[aria-current="page"] {
    background: linear-gradient(135deg, var(--brand-600), var(--brand-700)) !important;
    color: #fff !important;
    box-shadow: 0 2px 8px -2px rgba(13,148,136,0.4) !important;
}

/* ============================================================
   FILTERS, SEARCH BAR
   ============================================================ */
.fi-ta-search-field-wrp {
    border-radius: 0.85rem !important;
    overflow: hidden !important;
}
.fi-ta-filter-form {
    border-radius: var(--radius-card) !important;
    padding: 20px !important;
    background: #ffffff !important;
    border: 1px solid rgba(226,232,240,0.85) !important;
    box-shadow: 0 8px 24px -6px rgba(15,23,42,0.08) !important;
}
.dark .fi-ta-filter-form {
    background: #0d1322 !important;
    border-color: rgba(30,41,59,0.9) !important;
}

/* ============================================================
   SCROLLBAR — Minimal
   ============================================================ */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb {
    background: rgba(148,163,184,0.35);
    border-radius: 9999px;
}
::-webkit-scrollbar-thumb:hover { background: rgba(148,163,184,0.6); }

/* ============================================================
   PAGE ENTRY ANIMATION
   ============================================================ */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fi-main-ctn > * {
    animation: fadeUp 0.3s ease both;
}
.fi-wi-stats-overview-stat { animation: fadeUp 0.35s ease both; }
.fi-wi-stats-overview-stat:nth-child(1) { animation-delay: 0.05s; }
.fi-wi-stats-overview-stat:nth-child(2) { animation-delay: 0.10s; }
.fi-wi-stats-overview-stat:nth-child(3) { animation-delay: 0.15s; }
.fi-wi-stats-overview-stat:nth-child(4) { animation-delay: 0.20s; }

/* ============================================================
   AVATAR / USER MENU
   ============================================================ */
.fi-user-avatar {
    border: 2px solid var(--brand-400) !important;
    box-shadow: 0 0 0 3px rgba(13,148,136,0.15) !important;
}

/* ============================================================
   FOOTER
   ============================================================ */
.fi-footer {
    background: transparent !important;
    border-top: 1px solid rgba(226,232,240,0.5) !important;
    font-size: 0.72rem !important;
    color: #94a3b8 !important;
}

/* ============================================================
   ACTION MENUS
   ============================================================ */
.fi-dropdown-panel {
    border-radius: 0.85rem !important;
    border: 1px solid rgba(226,232,240,0.85) !important;
    box-shadow: 0 8px 32px -8px rgba(15,23,42,0.20) !important;
    overflow: hidden !important;
}
.dark .fi-dropdown-panel {
    background: #0d1322 !important;
    border-color: rgba(30,41,59,0.9) !important;
}
.fi-dropdown-list-item-button {
    font-size: 0.83rem !important;
    font-weight: 500 !important;
    padding: 9px 14px !important;
    border-radius: 0 !important;
    transition: background 0.12s ease !important;
}
.fi-dropdown-list-item-button:hover {
    background: rgba(13,148,136,0.07) !important;
    color: var(--brand-700) !important;
}

/* ============================================================
   TABLE ACTION BUTTONS
   ============================================================ */
.fi-ta-actions .fi-btn {
    height: 32px !important;
    font-size: 0.75rem !important;
    padding: 0 10px !important;
}
</style>
