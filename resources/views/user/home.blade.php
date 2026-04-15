@extends('layouts.user')
@section('title', 'Home - ' . config('app.name'))
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
/* ===== VARIABLES ===== */
:root {
    --primary: #7c3aed;
    --primary-light: #a78bfa;
    --primary-dark: #5b21b6;
    --accent: #f59e0b;
    --accent-dark: #d97706;
    --bg-dark: #0f0a1e;
    --card-dark: #1a1030;
    --text-muted-dark: #a0aec0;
    --glass: rgba(255,255,255,0.07);
    --glass-border: rgba(255,255,255,0.12);
    --transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
    --radius: 20px;
    --shadow: 0 8px 32px rgba(124,58,237,0.18);
    --shadow-hover: 0 20px 60px rgba(124,58,237,0.35);
}
/* ===== RESET & BASE ===== */
*, *::before, *::after { box-sizing: border-box; }
body {
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    background: #faf7ff;
    color: #1a1033;
    transition: background 0.4s, color 0.4s;
    overflow-x: hidden;
}
/* ===== SCROLLBAR ===== */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: #f1f1f1; }
::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 10px;
}
/* ===== HERO ===== */
.hero-section {
    position: relative;
    height: 100vh;
    min-height: 600px;
    max-height: 860px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('{{ asset('essence/img/bg-img/konser1.jpg') }}');
    background-size: cover;
    background-position: center;
    transform: scale(1.06);
    transition: transform 8s ease, background-image 0.8s ease-in-out;
    will-change: transform;
    z-index: -2;
}
.hero-section:hover .hero-bg { transform: scale(1.0); }
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        160deg,
        rgba(15,10,30,0.75) 0%,
        rgba(92,33,182,0.55) 50%,
        rgba(15,10,30,0.92) 100%
    );
}
.hero-particles {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}
.particle {
    position: absolute;
    border-radius: 50%;
    opacity: 0.18;
    animation: float-particle linear infinite;
}
@keyframes float-particle {
    0%   { transform: translateY(100vh) rotate(0deg); opacity: 0; }
    10%  { opacity: 0.18; }
    90%  { opacity: 0.18; }
    100% { transform: translateY(-20px) rotate(720deg); opacity: 0; }
}
.hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    color: #fff;
    padding: 0 20px;
    max-width: 800px;
    width: 100%;
}
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(245,158,11,0.2);
    border: 1px solid rgba(245,158,11,0.5);
    color: #fbbf24;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 20px;
    backdrop-filter: blur(8px);
    animation: fadeInDown 0.7s ease both;
}
.hero-title {
    font-size: clamp(2.2rem, 6vw, 4rem);
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 18px;
    background: linear-gradient(135deg, #fff 0%, var(--primary-light) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: fadeInUp 0.7s 0.15s ease both;
    text-shadow: none;
}
.hero-location {
    font-size: 1rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: 18px;
    animation: fadeInUp 0.7s 0.25s ease both;
}
.hero-countdown {
    display: inline-flex;
    gap: 14px;
    margin-bottom: 30px;
    animation: fadeInUp 0.7s 0.35s ease both;
    flex-wrap: wrap;
    justify-content: center;
}
.countdown-box {
    background: var(--glass);
    border: 1px solid var(--glass-border);
    backdrop-filter: blur(16px);
    border-radius: 16px;
    padding: 14px 20px;
    min-width: 80px;
    text-align: center;
}
.countdown-box .num {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.countdown-box .label {
    display: block;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--primary-light);
    margin-top: 4px;
}
.hero-actions {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
    animation: fadeInUp 0.7s 0.45s ease both;
}
.btn-hero-primary {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    border: none;
    padding: 15px 36px;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 8px 30px rgba(124,58,237,0.5);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}
.btn-hero-primary::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--primary-light), var(--primary));
    opacity: 0;
    transition: opacity 0.3s;
}
.btn-hero-primary:hover { transform: translateY(-3px) scale(1.04); box-shadow: 0 14px 40px rgba(124,58,237,0.65); color:#fff; }
.btn-hero-primary:hover::before { opacity: 1; }
.btn-hero-primary span { position: relative; z-index: 1; }
.btn-hero-outline {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255,255,255,0.45);
    padding: 14px 34px;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    backdrop-filter: blur(8px);
    transition: var(--transition);
}
.btn-hero-outline:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.85);
    transform: translateY(-3px);
    color: #fff;
}
.hero-scroll {
    position: absolute;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    color: rgba(255,255,255,0.5);
    font-size: 0.72rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    animation: bounce 2s infinite;
}
.hero-scroll i { font-size: 1.1rem; }
@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50%       { transform: translateX(-50%) translateY(8px); }
}

/* ===== NEW & IMPROVED HERO NAV ===== */
.hero-nav {
    position: absolute;
    top: 50%;
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 40px;
    transform: translateY(-50%);
    z-index: 20;
    pointer-events: none; 
}

.nav-btn {
    width: 45px !important;  
    height: 45px !important; 
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    color: white;
    cursor: pointer;
    pointer-events: auto;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    padding: 0 !important;
}

.nav-btn i {
    font-size: 16px !important; 
    line-height: 1 !important;
    transition: transform 0.3s ease;
    margin: 0 !important;
}

.nav-btn:hover {
    background: var(--primary);
    border-color: var(--primary-light);
    transform: scale(1.1);
    box-shadow: 0 10px 40px rgba(124, 58, 237, 0.4);
}

#prevHero:hover i { transform: translateX(-3px); }
#nextHero:hover i { transform: translateX(3px); }

/* ===== SEARCH SECTION ===== */
.search-section {
    background: #fff;
    padding: 32px 0;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    position: sticky;
    top: 0;
    z-index: 100;
}
.search-wrapper {
    position: relative;
    max-width: 560px;
    margin: 0 auto;
}
.search-wrapper i {
    position: absolute;
    left: 22px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary);
    font-size: 1rem;
    z-index: 2;
}
.search-input {
    width: 100%;
    padding: 15px 22px 15px 52px;
    border: 2px solid #ede9fe;
    border-radius: 50px;
    font-size: 0.95rem;
    background: #faf7ff;
    color: #1a1033;
    transition: var(--transition);
    outline: none;
    box-shadow: 0 4px 20px rgba(124,58,237,0.08);
}
.search-input:focus {
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 4px 24px rgba(124,58,237,0.22);
}
.search-input::placeholder { color: #a0aec0; }

/* ===== SECTION HEADER ===== */
.section-header { text-align: center; margin-bottom: 50px; }
.section-tag {
    display: inline-block;
    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
    color: var(--primary-dark);
    padding: 5px 16px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 12px;
}
.section-title {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    font-weight: 900;
    color: #1a1033;
    margin-bottom: 12px;
    line-height: 1.15;
}
.section-subtitle {
    color: #6b7280;
    font-size: 1.02rem;
    max-width: 480px;
    margin: 0 auto;
}

/* ===== EVENTS SECTION ===== */
.events-section {
    padding: 80px 0 100px;
    background: #faf7ff;
}

/* ===== FILTER TABS ===== */
.filter-tabs {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 46px;
}
.filter-tab {
    padding: 8px 22px;
    border-radius: 50px;
    border: 2px solid #ede9fe;
    background: transparent;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}
.filter-tab.active,
.filter-tab:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
    box-shadow: 0 4px 16px rgba(124,58,237,0.3);
}

/* ===== EVENT CAROUSEL (NEW CSS) ===== */
.event-carousel-wrapper {
    position: relative;
    width: 100%;
    padding: 0 10px;
}
.event-carousel-track {
    display: flex;
    gap: 24px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    padding: 20px 10px 40px 10px; /* Space for hover shadows */
    /* Hide scrollbar for cleaner look */
    -ms-overflow-style: none;  
    scrollbar-width: none;  
}
.event-carousel-track::-webkit-scrollbar { 
    display: none; 
}
.event-card-col {
    flex: 0 0 calc(33.333% - 16px);
    min-width: 300px; /* Minimal width agar tidak gepeng */
    scroll-snap-align: start;
    transition: opacity 0.4s ease, transform 0.4s ease;
}

/* CAROUSEL NAV BUTTONS */
.carousel-action-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #fff;
    color: var(--primary);
    border: 2px solid #ede9fe;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    z-index: 10;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}
.carousel-action-btn:hover {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
    box-shadow: 0 10px 30px rgba(124,58,237,0.3);
}
.carousel-action-btn i { font-size: 1rem; }
.btn-prev-event { left: -25px; }
.btn-next-event { right: -25px; }

/* ===== EVENT CARD ===== */
.event-card {
    height: 100%;
}
.event-card-inner {
    background: #fff;
    border-radius: var(--radius);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: var(--transition);
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    position: relative;
}
.event-card-inner:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-hover);
}
.event-card-inner:hover .card-img-cover { transform: scale(1.08); }
.card-img-wrapper {
    position: relative;
    height: 230px;
    overflow: hidden;
}
.card-img-cover {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.55s cubic-bezier(0.4,0,0.2,1);
}
.card-img-overlay-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 65%;
    background: linear-gradient(to top, rgba(0,0,0,0.72), transparent);
    pointer-events: none;
}
.card-date-chip {
    position: absolute;
    top: 14px;
    left: 14px;
    background: rgba(0,0,0,0.65);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.18);
    color: #fff;
    border-radius: 12px;
    padding: 6px 13px;
    font-size: 0.72rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 5px;
}
.card-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.badge-sold { background: #ef4444; color: #fff; }
.badge-hot  { background: #f59e0b; color: #1a1033; }
.card-price-tag {
    position: absolute;
    bottom: 14px;
    right: 14px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 0.82rem;
    font-weight: 800;
    box-shadow: 0 4px 14px rgba(124,58,237,0.45);
}
.event-card-body {
    padding: 22px 22px 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.event-card-title {
    font-size: 1.08rem;
    font-weight: 800;
    color: #1a1033;
    margin-bottom: 10px;
    line-height: 1.3;
}
.event-card-meta {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 16px;
}
.event-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.83rem;
    color: #6b7280;
}
.event-meta-item i {
    width: 18px;
    text-align: center;
    color: var(--primary);
    flex-shrink: 0;
}

/* ===== QUOTA PROGRESS ===== */
.quota-wrapper { margin-bottom: 18px; }
.quota-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.75rem;
    color: #9ca3af;
    margin-bottom: 6px;
    font-weight: 600;
}
.quota-label span:last-child { color: var(--primary); font-weight: 700; }
.quota-bar {
    height: 6px;
    background: #ede9fe;
    border-radius: 50px;
    overflow: hidden;
}
.quota-fill {
    height: 100%;
    border-radius: 50px;
    background: linear-gradient(90deg, var(--primary-light), var(--primary));
    transition: width 1.2s cubic-bezier(0.4,0,0.2,1);
    position: relative;
}
.quota-fill::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 30px;
    background: rgba(255,255,255,0.4);
    animation: shimmer 2s infinite;
}
@keyframes shimmer {
    0%   { transform: skewX(-15deg) translateX(-30px); opacity: 0; }
    50%  { opacity: 1; }
    100% { transform: skewX(-15deg) translateX(200px); opacity: 0; }
}

/* ===== CARD BUTTON ===== */
.btn-card {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    border: none;
    border-radius: 14px;
    font-size: 0.9rem;
    font-weight: 700;
    text-decoration: none;
    transition: var(--transition);
    margin-top: auto;
    box-shadow: 0 4px 16px rgba(124,58,237,0.3);
    position: relative;
    overflow: hidden;
}
.btn-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255,255,255,0.1);
    transform: rotate(45deg);
    transition: all 0.5s ease;
}

.cs-glow-2 {
    width: 350px;
    height: 350px;
    background: rgba(245,158,11,0.12);
    position: absolute;
    bottom: -100px;
    right: -80px;
    border-radius: 50%;
    z-index: 1;
}
.cs-content { position: relative; z-index: 2; text-align: center; }
.cs-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    color: #fff;
    font-size: 2rem;
    box-shadow: 0 0 40px rgba(124,58,237,0.5);
    animation: pulse-glow 3s infinite;
}
@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 30px rgba(124,58,237,0.4); }
    50%       { box-shadow: 0 0 60px rgba(124,58,237,0.8); }
}
.cs-title {
    font-size: 2.2rem;
    font-weight: 900;
    color: black;
    margin-bottom: 12px;
}
.cs-subtitle { color: black; font-size: 1rem; margin-bottom: 36px; }
.cs-notify-form {
    display: flex;
    gap: 10px;
    max-width: 440px;
    margin: 0 auto;
    flex-wrap: wrap;
    justify-content: center;
}
.cs-input {
    flex: 1;
    min-width: 220px;
    padding: 14px 22px;
    border-radius: 50px;
    border: 2px solid rgba(0, 0, 0, 0.438);
    background: rgba(13, 12, 12, 0);
    color: rgb(0, 0, 0);
    font-size: 0.9rem;
    outline: none;
    transition: var(--transition);
    backdrop-filter: blur(8px);
}
.cs-input::placeholder { color: rgba(1, 1, 1, 0.434); }
.cs-input:focus { border-color: var(--primary); background: rgba(255,255,255,0.1); }
.btn-cs {
    padding: 14px 28px;
    border-radius: 50px;
    background: linear-gradient(135deg, var(--accent), var(--accent-dark));
    color: #1a1033;
    font-weight: 800;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    transition: var(--transition);
    box-shadow: 0 4px 20px rgba(245,158,11,0.4);
}
.btn-cs:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(245,158,11,0.6); }

/* ===== BRANDS ===== */
.brands-section {
    background: #fff;
    padding: 36px 0;
    border-top: 1px solid #ede9fe;
    border-bottom: 1px solid #ede9fe;
}
.brands-track {
    display: flex;
    align-items: center;
    gap: 50px;
    justify-content: center;
    flex-wrap: wrap;
}
.brand-item img {
    height: 36px;
    opacity: 0.35;
    filter: grayscale(100%);
    transition: var(--transition);
}
.brand-item:hover img { opacity: 0.85; filter: grayscale(0%); }

/* ===== DARK MODE TOGGLE ===== */
.dark-toggle-wrapper {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 999;
}
.btn-dark-toggle {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border: none;
    color: #fff;
    font-size: 1.3rem;
    cursor: pointer;
    box-shadow: 0 6px 24px rgba(124,58,237,0.5);
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-dark-toggle:hover { transform: scale(1.12) rotate(20deg); }

/* ===== DARK MODE ===== */
body.dark-mode {
    background: var(--bg-dark);
    color: #e2d9f3;
}
body.dark-mode .search-section {
    background: #14082a;
    box-shadow: 0 4px 24px rgba(0,0,0,0.4);
}
body.dark-mode .search-input {
    background: #1a0e30;
    border-color: #3a2563;
    color: #e2d9f3;
}
body.dark-mode .search-input:focus {
    background: #1e1138;
    border-color: var(--primary);
}
body.dark-mode .events-section { background: var(--bg-dark); }
body.dark-mode .section-title { color: #e2d9f3; }
body.dark-mode .event-card-inner {
    background: var(--card-dark);
    box-shadow: 0 4px 20px rgba(0,0,0,0.4);
}
body.dark-mode .event-card-inner:hover { box-shadow: 0 20px 60px rgba(124,58,237,0.4); }
body.dark-mode .event-card-title { color: #e2d9f3; }
body.dark-mode .event-meta-item { color: #a0aec0; }
body.dark-mode .quota-bar { background: #2d1f4e; }
body.dark-mode .brands-section {
    background: #14082a;
    border-color: #2d1f4e;
}
body.dark-mode .filter-tab {
    border-color: #3a2563;
    color: #a0aec0;
}
body.dark-mode .section-tag {
    background: linear-gradient(135deg, #2d1f4e, #3a2563);
    color: var(--primary-light);
}

/* ===== EMPTY STATE ===== */
.empty-state {
    text-align: center;
    padding: 70px 20px;
    color: #9ca3af;
    width: 100%;
}
.empty-state i {
    font-size: 3.5rem;
    margin-bottom: 16px;
    color: #d8b4fe;
}
.empty-state h5 { color: #6b7280; font-weight: 700; }

/* ===== ANIMATIONS ===== */
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-18px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .event-card-col { flex: 0 0 calc(50% - 12px); }
    .btn-prev-event { left: -10px; }
    .btn-next-event { right: -10px; }
}

@media (max-width: 768px) {
    .hero-section { max-height: 700px; }
    .hero-title { font-size: 2rem; }
    .countdown-box .num { font-size: 1.5rem; }
    .countdown-box { padding: 10px 14px; min-width: 66px; }
    .btn-hero-primary, .btn-hero-outline { padding: 13px 26px; font-size: 0.9rem; }
    .cs-title { font-size: 1.7rem; }
    
    .hero-nav { padding: 0 15px; }
    .nav-btn { width: 44px; height: 44px; }
    .nav-btn i { font-size: 1rem; }

    /* Hide buttons on mobile, allow native swiping */
    .carousel-action-btn { display: none; } 
    .event-card-col { flex: 0 0 100%; }
}
</style>
@endpush

@php
    $heroEvents = $popularProducts->take(3);
    $heroEvent = $heroEvents->first(); 
@endphp

@section('content')

<section class="hero-section">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-nav">
        <button class="nav-btn" id="prevHero">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="nav-btn" id="nextHero">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <div class="hero-particles" id="heroParticles"></div>

    <div class="hero-content">
        @if($heroEvents->count())
            <div class="hero-badge">
                <i class="fas fa-fire"></i>
                Event Terpopuler
            </div>

            <h1 class="hero-title">Loading...</h1>

            <p class="hero-location">
                <i class="fas fa-map-marker-alt" style="color: #f59e0b; margin-right:6px;"></i>
                Loading...
            </p>

            <div class="hero-actions">
                <a href="#" id="heroBtn" class="btn-hero-primary">
                    <span><i class="fas fa-ticket-alt"></i> Beli Tiket</span>
                </a>

                <a href="#events" class="btn-hero-outline">
                    <i class="fas fa-compass"></i> Jelajahi Event
                </a>
            </div>
        @else
            <h1 class="hero-title">Event Segera Hadir</h1>
        @endif
    </div>

    <div class="hero-scroll">
        <span>Scroll</span>
    </div>
</section>

<section class="search-section" id="events">
    <div class="container">
        <div class="search-wrapper">
            <i class="fa fa-search" aria-hidden="true"></i>
            <input type="text" id="searchEvent" class="search-input"
                   placeholder="Cari nama event, lokasi...">
        </div>
    </div>
</section>

<section class="events-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag">🔥 Populer</div>
            <h2 class="section-title">Event yang Sedang Hits</h2>
            <p class="section-subtitle">Temukan pengalaman konser tak terlupakan dan pesan tiketmu sekarang</p>
        </div>

        <div class="filter-tabs" data-aos="fade-up" data-aos-delay="100">
            <button class="filter-tab active" data-category="all">Semua</button>
            <button class="filter-tab" data-category="konser">Konser</button>
            <button class="filter-tab" data-category="festival">Festival</button>
            <button class="filter-tab" data-category="theater">Theater</button>
        </div>

        <div class="event-carousel-wrapper" data-aos="fade-up" data-aos-delay="150">
            <button class="carousel-action-btn btn-prev-event" id="scrollEventPrev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-action-btn btn-next-event" id="scrollEventNext">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div class="event-carousel-track" id="eventList">
                @forelse($popularProducts as $event)
                <div class="event-card-col" data-category="{{ strtolower($event->category ?? 'all') }}">
                    <div class="event-card">
                        <div class="event-card-inner">
                            <div class="card-img-wrapper">
                                <img src="{{ $event->image ?? asset('essence/img/bg-img/konser2.jpg') }}"
                                     class="card-img-cover"
                                     alt="{{ $event->name }}"
                                     loading="lazy">
                                <div class="card-img-overlay-gradient"></div>
                                <div class="card-date-chip">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                                </div>
                                @if($event->quota <= 0)
                                    <div class="card-badge badge-sold">Sold Out</div>
                                @elseif($event->quota <= 20)
                                    <div class="card-badge badge-hot">🔥 Hampir Habis</div>
                                @endif
                                <div class="card-price-tag">
                                    Rp {{ number_format($event->price, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="event-card-body">
                                <h5 class="event-card-title">{{ $event->name }}</h5>
                                <div class="event-card-meta">
                                    <div class="event-meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                    <div class="event-meta-item">
                                        <i class="fas fa-ticket-alt"></i>
                                        <span>{{ $event->quota > 0 ? $event->quota . ' tiket tersisa' : 'Tiket habis' }}</span>
                                    </div>
                                </div>
                                @php
                                    $maxQuota = 100;
                                    $percentage = $event->quota > 0 ? min(100, ($event->quota / $maxQuota) * 100) : 0;
                                @endphp
                                <div class="quota-wrapper">
                                    <div class="quota-label">
                                        <span>Ketersediaan Tiket</span>
                                        <span>{{ round($percentage) }}%</span>
                                    </div>
                                    <div class="quota-bar">
                                        <div class="quota-fill" style="width: {{ $percentage }}%;
                                            @if($event->quota <= 0) background: #ef4444;
                                            @elseif($event->quota <= 20) background: linear-gradient(90deg, #fbbf24, #f59e0b);
                                            @endif">
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('user.event', $event->id) }}" class="btn-card">
                                    <i class="fas fa-arrow-right"></i>
                                    Lihat Detail &amp; Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h5>Belum ada event tersedia</h5>
                    <p>Event baru akan segera ditambahkan, stay tuned!</p>
                </div>
                @endforelse
            </div>
        </div>
        
    </div>
</section>

<section class="coming-soon-section position-relative overflow-hidden pt-5 pb-5">
    <div class="cs-glow-2"></div>
    <div class="container">
        <div class="cs-content" data-aos="fade-up">
            <div class="cs-icon"><i class="fas fa-music"></i></div>
            <h3 class="cs-title">Event Berikutnya Sudah Dekat</h3>
            <p class="cs-subtitle">Daftarkan email kamu untuk mendapat notifikasi pertama saat tiket dirilis!</p>
            <div class="cs-notify-form">
                <input type="email" class="cs-input" placeholder="email@kamu.com">
                <button class="btn-cs">
                    <i class="fas fa-bell" style="margin-right:6px;"></i> Notifikasi
                </button>
            </div>
        </div>
    </div>
</section>

<div class="brands-section">
    <div class="container">
        <div class="brands-track">
            @for($i = 1; $i <= 6; $i++)
            <div class="brand-item">
                <img src="{{ asset('essence/img/core-img/brand' . $i . '.png') }}"
                     alt="Brand {{ $i }}">
            </div>
            @endfor
        </div>
    </div>
</div>

<div class="dark-toggle-wrapper">
    <button id="darkModeToggle" class="btn-dark-toggle" title="Toggle Dark Mode">
        🌙
    </button>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 700, once: true, easing: 'ease-out-cubic' });

/* ---- PARTICLES ---- */
(function() {
    const container = document.getElementById('heroParticles');
    if (!container) return;
    const colors = ['#a78bfa','#7c3aed','#f59e0b','#fff','#c4b5fd'];
    for (let i = 0; i < 28; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        const size = Math.random() * 10 + 4;
        p.style.cssText = `
            width:${size}px; height:${size}px;
            left:${Math.random()*100}%;
            background:${colors[Math.floor(Math.random()*colors.length)]};
            animation-duration:${Math.random()*14+8}s;
            animation-delay:${Math.random()*-15}s;
        `;
        container.appendChild(p);
    }
})();

/* ---- HERO SLIDER ---- */
const heroEvents = @json($heroEvents);

(function () {
    if (!heroEvents || heroEvents.length === 0) return;

    let i = 0;
    const bg = document.getElementById('heroBg');
    const title = document.querySelector('.hero-title');
    const locationText = document.querySelector('.hero-location');
    const btn = document.getElementById('heroBtn');

    function setHero(index) {
        const e = heroEvents[index];
        bg.style.backgroundImage = `url('${e.image ?? '/essence/img/bg-img/konser1.jpg'}')`;
        title.textContent = e.name;
        locationText.innerHTML = `<i class="fas fa-map-marker-alt" style="color:#f59e0b;margin-right:6px;"></i>${e.location}`;
        btn.href = `/event/${e.id}`;
    }

    function next() {
        i = (i + 1) % heroEvents.length;
        setHero(i);
    }

    function prev() {
        i = (i - 1 + heroEvents.length) % heroEvents.length;
        setHero(i);
    }

    setHero(i);
    let auto = setInterval(next, 5000);

    document.getElementById('nextHero').onclick = () => {
        next();
        resetAuto();
    };

    document.getElementById('prevHero').onclick = () => {
        prev();
        resetAuto();
    };

    function resetAuto() {
        clearInterval(auto);
        auto = setInterval(next, 5000);
    }
})();

/* ---- EVENT CAROUSEL NAVIGATION ---- */
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('eventList');
    const btnPrev = document.getElementById('scrollEventPrev');
    const btnNext = document.getElementById('scrollEventNext');

    if (track && btnPrev && btnNext) {
        btnNext.addEventListener('click', () => {
            // Dapatkan lebar card yang sedang aktif + gap (24px)
            const activeCard = track.querySelector('.event-card-col:not([style*="display: none"])');
            const cardWidth = activeCard ? activeCard.offsetWidth : 300;
            track.scrollBy({ left: cardWidth + 24, behavior: 'smooth' });
        });

        btnPrev.addEventListener('click', () => {
            const activeCard = track.querySelector('.event-card-col:not([style*="display: none"])');
            const cardWidth = activeCard ? activeCard.offsetWidth : 300;
            track.scrollBy({ left: -(cardWidth + 24), behavior: 'smooth' });
        });
    }
});

/* ---- QUOTA BAR ANIMATE ON SCROLL ---- */
const observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
        if (entry.isIntersecting) {
            entry.target.style.width = entry.target.dataset.width;
        }
    });
}, { threshold: 0.3 });
document.querySelectorAll('.quota-fill').forEach(function(bar) {
    bar.dataset.width = bar.style.width;
    bar.style.width = '0%';
    observer.observe(bar);
});

/* ---- DARK MODE ---- */
const dmToggle = document.getElementById('darkModeToggle');
const saved = localStorage.getItem('darkMode');
if (saved === 'true') {
    document.body.classList.add('dark-mode');
    dmToggle.textContent = '☀️';
}
dmToggle.addEventListener('click', function() {
    const isDark = document.body.classList.toggle('dark-mode');
    this.textContent = isDark ? '☀️' : '🌙';
    localStorage.setItem('darkMode', isDark);
});

/* ---- FILTER & SEARCH LOGIC ---- */
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.filter-tab');
    const cards = document.querySelectorAll('.event-card-col');
    const searchInput = document.getElementById('searchEvent');

    let currentCategory = 'all';

    function applyFilter() {
        const keyword = searchInput.value.toLowerCase().trim();

        cards.forEach(card => {
            const text = card.innerText.toLowerCase();
            const category = card.dataset.category ? card.dataset.category.toLowerCase() : 'all';

            const matchSearch = text.includes(keyword);
            const matchCategory = (currentCategory === 'all' || category === currentCategory);

            if (matchSearch && matchCategory) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    tabs.forEach(button => {
        button.addEventListener('click', function () {
            document.querySelector('.filter-tab.active')?.classList.remove('active');
            this.classList.add('active');

            currentCategory = this.dataset.category.toLowerCase();
            applyFilter();
        });
    });

    searchInput.addEventListener('input', applyFilter);
});
</script>
@endsection