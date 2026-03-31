<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Húsvéti Tojásfestő' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/gallery.js') }}" defer></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #0b0f18;
            color: #dde3ee;
            min-height: 100vh;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        #poly-bg {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            display: block;
        }

        /* ── Header ─────────────────────────────────────────────── */
        .site-header {
            position: relative;
            z-index: 30;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 1.75rem;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            background: rgba(11, 15, 24, 0.72);
            border-bottom: 1px solid rgba(255, 255, 255, 0.065);
        }

        .site-logo {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            font-size: 1rem;
            font-weight: 700;
            color: #e8edf5;
            letter-spacing: -0.02em;
            text-decoration: none;
        }

        .logo-gem {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-username {
            font-size: 0.82rem;
            color: #7c8fa8;
            margin-right: 0.25rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.38rem 0.9rem;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            transition: background 0.15s, color 0.15s, border-color 0.15s, transform 0.1s;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn:active { transform: scale(0.97); }

        .btn-ghost {
            background: transparent;
            color: #8fa0b8;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-ghost:hover {
            background: rgba(255,255,255,0.06);
            color: #dde3ee;
            border-color: rgba(255,255,255,0.18);
        }

        .btn-primary {
            background: #5a5fcf;
            color: #fff;
            border: 1px solid transparent;
        }
        .btn-primary:hover { background: #4a4fba; }

        .btn-danger {
            background: transparent;
            color: #e57a7a;
            border: 1px solid rgba(229,122,122,0.22);
        }
        .btn-danger:hover { background: rgba(229,122,122,0.1); }

        /* ── Main ────────────────────────────────────────────────── */
        .site-main {
            position: relative;
            z-index: 10;
            flex: 1;
            width: 100%;
            padding: 1.75rem 1rem 2rem;
        }

        /* ── Footer ──────────────────────────────────────────────── */
        .site-footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 1.25rem 1rem;
            font-size: 0.78rem;
            color: #3d4a5e;
            border-top: 1px solid rgba(255,255,255,0.04);
        }
        .site-footer .accent { color: #5a5fcf; }
        .site-footer .heart  { color: #c05858; }
    </style>
</head>
<body>

<canvas id="poly-bg"></canvas>

<header class="site-header">
    <a href="/" class="site-logo">
        <!-- Polygon gem icon -->
        <svg class="logo-gem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <polygon points="12,2 22,8 22,16 12,22 2,16 2,8" fill="rgba(90,95,207,0.25)" stroke="#5a5fcf" stroke-width="1.4"/>
            <polygon points="12,2 22,8 12,12" fill="rgba(90,95,207,0.18)"/>
            <polygon points="22,8 22,16 12,12" fill="rgba(90,95,207,0.12)"/>
            <polygon points="12,22 2,16 12,12" fill="rgba(90,95,207,0.22)"/>
            <polygon points="2,8 12,12 2,16"  fill="rgba(90,95,207,0.15)"/>
            <polygon points="12,2 2,8 12,12"  fill="rgba(90,95,207,0.2)"/>
        </svg>
        Húsvéti Tojásfestő
    </a>

    <nav class="nav-auth">
        @auth
            <span class="nav-username">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;display:inline">
                @csrf
                <button type="submit" class="btn btn-danger">Kijelentkezés</button>
            </form>
        @else
            <a href="{{ route('login') }}"    class="btn btn-ghost">Bejelentkezés</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Regisztráció</a>
        @endauth
    </nav>
</header>

<main class="site-main">
    {{ $slot }}
</main>

<footer class="site-footer">
    &copy; 2026 Húsvéti Tojásfestő &mdash;
    készült <span class="heart">&#9829;</span> Laravel,
    <span class="accent">Three.js</span> &amp; Tailwind CSS használatával.
</footer>

<!-- ── Animated polygon background ─────────────────────────────── -->
<script>
(function () {
    'use strict';
    const cv  = document.getElementById('poly-bg');
    const ctx = cv.getContext('2d');
    const COLS = 15, ROWS = 10, SPEED = 0.32;
    let W, H, pts;

    function resize() {
        W = cv.width  = window.innerWidth;
        H = cv.height = window.innerHeight;
        build();
    }

    function build() {
        pts = [];
        const cw = W / COLS, ch = H / ROWS;
        for (let r = 0; r <= ROWS; r++) {
            for (let c = 0; c <= COLS; c++) {
                const ox = c * cw, oy = r * ch;
                pts.push({
                    x:  ox + (Math.random() - .5) * cw * .72,
                    y:  oy + (Math.random() - .5) * ch * .72,
                    ox, oy,
                    vx: (Math.random() - .5) * SPEED,
                    vy: (Math.random() - .5) * SPEED,
                });
            }
        }
    }

    function fillColor(cy, idx) {
        const t   = cy / H;
        const lum = 6.5 + t * 8 + (idx % 4) * 1.2;
        return `hsl(224,30%,${lum.toFixed(1)}%)`;
    }

    function strokeColor(cy) {
        const t   = cy / H;
        const lum = 12 + t * 9;
        return `hsla(224,36%,${lum.toFixed(1)}%,0.5)`;
    }

    function tick() {
        ctx.clearRect(0, 0, W, H);
        ctx.fillStyle = '#0b0f18';
        ctx.fillRect(0, 0, W, H);

        pts.forEach(p => {
            p.vx += (p.ox - p.x) * 0.00022;
            p.vy += (p.oy - p.y) * 0.00022;
            p.vx *= 0.993;
            p.vy *= 0.993;
            p.x  += p.vx;
            p.y  += p.vy;
        });

        const stride = COLS + 1;
        for (let r = 0; r < ROWS; r++) {
            for (let c = 0; c < COLS; c++) {
                const a = pts[ r      * stride + c    ];
                const b = pts[ r      * stride + c + 1];
                const d = pts[(r + 1) * stride + c    ];
                const e = pts[(r + 1) * stride + c + 1];
                const i = r * COLS + c;

                // upper-left triangle
                const cy1 = (a.y + b.y + d.y) / 3;
                ctx.beginPath();
                ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y); ctx.lineTo(d.x, d.y);
                ctx.closePath();
                ctx.fillStyle   = fillColor(cy1, i);
                ctx.fill();
                ctx.strokeStyle = strokeColor(cy1);
                ctx.lineWidth   = 0.55;
                ctx.stroke();

                // lower-right triangle
                const cy2 = (b.y + e.y + d.y) / 3;
                ctx.beginPath();
                ctx.moveTo(b.x, b.y); ctx.lineTo(e.x, e.y); ctx.lineTo(d.x, d.y);
                ctx.closePath();
                ctx.fillStyle   = fillColor(cy2, i + 1);
                ctx.fill();
                ctx.strokeStyle = strokeColor(cy2);
                ctx.lineWidth   = 0.55;
                ctx.stroke();
            }
        }

        requestAnimationFrame(tick);
    }

    window.addEventListener('resize', resize);
    resize();
    tick();
}());
</script>

</body>
</html>
