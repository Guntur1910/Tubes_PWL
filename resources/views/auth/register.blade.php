<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register — GIGS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --violet: #7c3aed;
            --violet-light: #8b5cf6;
            --violet-glow: rgba(124,58,237,0.45);
            --pink: #ec4899;
            --dark: #09090f;
            --dark-2: #0d0d18;
            --dark-3: #11111c;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: flex;
        }

        /* ── LEFT BRANDING PANEL ── */
        .panel-left {
            position: relative;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 52px;
            overflow: hidden;
            background: var(--dark-2);
        }

        .rays {
            position: absolute;
            inset: 0;
            background: conic-gradient(
                from 210deg at 75% 0%,
                transparent 0deg,
                rgba(124,58,237,0.2) 14deg,
                transparent 28deg,
                transparent 42deg,
                rgba(139,92,246,0.14) 52deg,
                transparent 66deg,
                transparent 88deg,
                rgba(236,72,153,0.10) 98deg,
                transparent 114deg
            );
            animation: rayShift 14s ease-in-out infinite alternate;
        }
        @keyframes rayShift {
            0%   { transform: rotate(0deg); opacity: 0.85; }
            100% { transform: rotate(10deg); opacity: 1; }
        }

        .stage-glow {
            position: absolute;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            height: 320px;
            background: radial-gradient(ellipse, rgba(236,72,153,0.5) 0%, rgba(124,58,237,0.18) 42%, transparent 68%);
            filter: blur(50px);
            animation: stagePulse 5s ease-in-out infinite alternate;
        }
        @keyframes stagePulse {
            0%   { opacity: 0.65; transform: translateX(-50%) scaleX(0.88); }
            100% { opacity: 1;   transform: translateX(-50%) scaleX(1.06); }
        }

        .dots-bg { position: absolute; inset: 0; overflow: hidden; }
        .dot {
            position: absolute;
            border-radius: 50%;
            animation: twinkle ease-in-out infinite;
        }
        @keyframes twinkle {
            0%, 100% { opacity: 0.15; transform: scale(1); }
            50%       { opacity: 0.85; transform: scale(1.5); }
        }

        .grid-lines {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(124,58,237,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(124,58,237,0.06) 1px, transparent 1px);
            background-size: 52px 52px;
        }

        .brand-content { position: relative; z-index: 2; }

        .brand-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 6.5rem;
            color: #fff;
            line-height: 0.9;
            letter-spacing: 0.06em;
            text-shadow: 0 0 80px var(--violet-glow), 0 0 140px rgba(124,58,237,0.15);
        }
        .brand-logo em { color: var(--pink); font-style: normal; }

        .brand-tagline {
            font-size: 0.72rem;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            margin-top: 8px;
            margin-bottom: 28px;
        }

        .perks {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .perk-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .perk-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: rgba(124,58,237,0.18);
            border: 1px solid rgba(124,58,237,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .perk-icon svg { color: #a78bfa; }
        .perk-title { font-size: 0.82rem; color: rgba(255,255,255,0.75); font-weight: 500; margin-bottom: 2px; }
        .perk-desc  { font-size: 0.75rem; color: rgba(255,255,255,0.36); font-weight: 300; line-height: 1.5; }

        .ticker-strip {
            margin-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.07);
            padding-top: 18px;
            overflow: hidden;
        }
        .ticker-inner {
            display: flex;
            gap: 44px;
            animation: tickerScroll 20s linear infinite;
            white-space: nowrap;
        }
        @keyframes tickerScroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .ticker-item {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 0.18em;
            color: rgba(255,255,255,0.22);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ticker-item .dot-sm {
            width: 4px; height: 4px;
            border-radius: 50%;
            background: var(--pink);
            opacity: 0.7;
            display: inline-block;
        }

        /* ── RIGHT FORM PANEL ── */
        .panel-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 52px;
            background: var(--dark-3);
            position: relative;
            overflow-y: auto;
        }

        .panel-right::before {
            content: '';
            position: absolute;
            bottom: -120px; left: -120px;
            width: 480px; height: 480px;
            background: radial-gradient(circle, rgba(236,72,153,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .form-inner { width: 100%; max-width: 360px; position: relative; z-index: 1; }

        .member-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(236,72,153,0.12);
            border: 1px solid rgba(236,72,153,0.25);
            border-radius: 99px;
            padding: 5px 14px;
            margin-bottom: 22px;
            font-size: 0.68rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #f9a8d4;
            font-weight: 500;
        }

        .form-heading {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.8rem;
            color: #fff;
            letter-spacing: 0.06em;
            line-height: 0.95;
            margin-bottom: 8px;
        }

        .form-sub {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.38);
            margin-bottom: 30px;
            font-weight: 300;
        }

        /* Fields */
        .field { margin-bottom: 12px; }
        .field label {
            display: block;
            font-size: 0.68rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.32);
            margin-bottom: 7px;
            font-weight: 500;
        }
        .field-wrap { position: relative; }
        .field-wrap input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 8px;
            padding: 12px 16px 12px 46px;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s;
        }
        .field-wrap input::placeholder { color: rgba(255,255,255,0.22); }
        .field-wrap input:focus {
            border-color: rgba(236,72,153,0.55);
            background: rgba(236,72,153,0.06);
            box-shadow: 0 0 0 3px rgba(236,72,153,0.13);
        }
        .field-icon {
            position: absolute;
            left: 15px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.28);
            pointer-events: none;
        }

        /* Error */
        .error-box {
            background: rgba(239,68,68,0.09);
            border: 1px solid rgba(239,68,68,0.28);
            border-radius: 8px;
            padding: 11px 14px;
            margin-bottom: 12px;
            font-size: 0.8rem;
            color: #fca5a5;
            line-height: 1.6;
        }
        .error-box p { display: flex; gap: 6px; }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.15rem;
            letter-spacing: 0.14em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 28px rgba(236,72,153,0.42);
            margin-top: 6px;
        }
        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.14), transparent 55%);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(236,72,153,0.58); }
        .btn-submit:hover::after { opacity: 1; }
        .btn-submit:active { transform: translateY(0); }

        .form-footer {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.3);
            margin-top: 20px;
            text-align: center;
        }
        .form-footer a {
            color: #f472b6;
            font-weight: 600;
            text-decoration: none;
        }
        .form-footer a:hover { color: #f9a8d4; }

        /* Animate */
        .fi { opacity: 0; transform: translateY(18px); animation: fi 0.55s cubic-bezier(0.22,1,0.36,1) forwards; }
        @keyframes fi { to { opacity: 1; transform: none; } }
        .d1{animation-delay:.05s} .d2{animation-delay:.10s} .d3{animation-delay:.16s}
        .d4{animation-delay:.22s} .d5{animation-delay:.28s} .d6{animation-delay:.34s}
        .d7{animation-delay:.40s} .d8{animation-delay:.46s}

        @media (max-width:768px) {
            .panel-left { display: none; }
            .panel-right { padding: 40px 28px; }
        }
    </style>
</head>

<body>

<!-- LEFT PANEL -->
<div class="panel-left">
    <div class="rays"></div>
    <div class="dots-bg" id="dots"></div>
    <div class="grid-lines"></div>
    <div class="stage-glow"></div>

    <div class="brand-content">
        <div class="brand-logo">GIG<em>S</em></div>
        <div class="brand-tagline">Your Stage. Your Night.</div>

        <div class="perks">
            <div class="perk-item">
                <div class="perk-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 12V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6"/><rect x="2" y="12" width="20" height="9" rx="2"/><path d="M12 12v9"/></svg>
                </div>
                <div>
                    <div class="perk-title">Akses Ribuan Konser</div>
                    <div class="perk-desc">Dari indie lokal hingga world tour, semua ada di sini.</div>
                </div>
            </div>
            <div class="perk-item">
                <div class="perk-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div>
                    <div class="perk-title">Early Bird & Promo Eksklusif</div>
                    <div class="perk-desc">Dapatkan tiket lebih murah sebelum kehabisan.</div>
                </div>
            </div>
            <div class="perk-item">
                <div class="perk-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><rect x="3" y="3" width="18" height="18" rx="3"/></svg>
                </div>
                <div>
                    <div class="perk-title">E-Ticket Instan</div>
                    <div class="perk-desc">Tiket langsung masuk ke akunmu, siap scan di venue.</div>
                </div>
            </div>
        </div>

        <div class="ticker-strip">
            <div class="ticker-inner" id="ticker"></div>
        </div>
    </div>
</div>

<!-- RIGHT PANEL -->
<div class="panel-right">
    <div class="form-inner">

        <div class="fi d1">
            <div class="member-badge">
                <svg width="7" height="7" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4" fill="#f472b6"/></svg>
                Daftar Gratis
            </div>
        </div>

        <h1 class="form-heading fi d2">BUAT AKUN<br>BARUMU</h1>
        <p class="form-sub fi d2">Mulai beli tiket event favoritmu sekarang.</p>

        <form method="POST" action="/user/register">
            @csrf

            <div class="field fi d3">
                <label>Nama Lengkap</label>
                <div class="field-wrap">
                    <svg class="field-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    <input type="text" name="name" placeholder="Nama kamu" autocomplete="name">
                </div>
            </div>

            <div class="field fi d4">
                <label>Email</label>
                <div class="field-wrap">
                    <svg class="field-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                    <input type="email" name="email" placeholder="kamu@email.com" autocomplete="email">
                </div>
            </div>

            <div class="field fi d5">
                <label>Password</label>
                <div class="field-wrap">
                    <svg class="field-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                    <input type="password" name="password" placeholder="Min. 8 karakter" autocomplete="new-password">
                </div>
            </div>

            <div class="field fi d6">
                <label>Konfirmasi Password</label>
                <div class="field-wrap">
                    <svg class="field-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/><path d="m9 16 2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password" autocomplete="new-password">
                </div>
            </div>

            @if($errors->any())
                <div class="error-box fi">
                    @foreach($errors->all() as $error)
                        <p><span>•</span> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <button type="submit" class="btn-submit fi d7">
                Buat Akun →
            </button>

        </form>

        <p class="form-footer fi d8">
            Sudah punya akun? <a href="/login">Masuk di sini</a>
        </p>

    </div>
</div>

<script>
    const colors = ['#7c3aed','#8b5cf6','#a78bfa','#ec4899','#f472b6','#c4b5fd'];
    const dotsEl = document.getElementById('dots');
    for (let i = 0; i < 30; i++) {
        const d = document.createElement('div');
        const s = Math.random() * 4 + 1.5;
        d.className = 'dot';
        d.style.cssText = `width:${s}px;height:${s}px;left:${Math.random()*100}%;top:${Math.random()*100}%;background:${colors[Math.floor(Math.random()*colors.length)]};animation-duration:${2+Math.random()*5}s;animation-delay:${Math.random()*5}s;`;
        dotsEl.appendChild(d);
    }

    const events = ['WOODZ WORLD TOUR','KONSER SENJA INDIE','ROCK IN JAKARTA','JAZZ MALAM MINGGU','EDM FESTIVAL 2026','ACOUSTIC NIGHT','POP ICONS LIVE','METAL MAYHEM'];
    const tickerEl = document.getElementById('ticker');
    [...events,...events].forEach(e => {
        const el = document.createElement('div');
        el.className = 'ticker-item';
        el.innerHTML = `<span class="dot-sm"></span>${e}`;
        tickerEl.appendChild(el);
    });
</script>

</body>
</html>