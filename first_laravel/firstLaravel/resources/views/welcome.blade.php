<x-layouts.app title="Húsvéti Tojásfestő">

<style>
    /* ── Page-level dark glass styles ─────────────────────────── */
    .page-title {
        font-size: clamp(1.7rem, 3.8vw, 2.6rem);
        font-weight: 800;
        color: #ecf0f8;
        letter-spacing: -0.035em;
        margin-bottom: 0.4rem;
    }

    .page-subtitle {
        color: #566070;
        font-size: 0.92rem;
        line-height: 1.65;
        max-width: 40rem;
        margin: 0 auto;
    }

    .layout-grid {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
        max-width: 82rem;
        margin: 0 auto;
    }

    @media (min-width: 1024px) {
        .layout-grid {
            flex-direction: row;
            align-items: flex-start;
        }
        .sidebar       { width: 300px; flex-shrink: 0; order: 1; }
        .canvas-wrap   { flex: 1; order: 2; }
    }

    /* ── Glass card ────────────────────────────────────────────── */
    .glass-card {
        background: rgba(255,255,255,0.04);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
    }

    .card-heading {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        margin-bottom: 0.85rem;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        font-size: 0.95rem;
        font-weight: 700;
        color: #c8d2e0;
    }

    .card-heading svg {
        color: #5a5fcf;
        flex-shrink: 0;
    }

    /* ── User badge ────────────────────────────────────────────── */
    .user-badge {
        font-size: 0.82rem;
        color: #8fa0b8;
        background: rgba(90,95,207,0.1);
        border: 1px solid rgba(90,95,207,0.2);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.9rem;
    }
    .user-badge strong { color: #bdc7d8; }

    /* ── Save button ───────────────────────────────────────────── */
    .btn-save {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        width: 100%;
        background: #5a5fcf;
        color: #fff;
        font-size: 0.85rem;
        font-weight: 700;
        padding: 0.65rem 1rem;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
        margin-bottom: 1rem;
    }
    .btn-save:hover  { background: #4a4fba; }
    .btn-save:active { transform: scale(0.97); }

    /* ── Gallery ───────────────────────────────────────────────── */
    .gallery-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #45576a;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        margin-bottom: 0.6rem;
    }

    .egg-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.6rem;
        overflow-y: auto;
        max-height: 340px;
        padding-right: 4px;
    }

    /* scrollbar */
    .egg-grid::-webkit-scrollbar       { width: 4px; }
    .egg-grid::-webkit-scrollbar-track { background: rgba(255,255,255,0.03); border-radius: 4px; }
    .egg-grid::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.12); border-radius: 4px; }
    .egg-grid::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.22); }

    .egg-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        aspect-ratio: 1;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.07);
        cursor: pointer;
        transition: border-color 0.15s;
    }
    .egg-item:hover { border-color: rgba(90,95,207,0.4); }

    .egg-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
        display: block;
    }
    .egg-item:hover img { transform: scale(1.08); }

    .egg-delete-btn {
        position: absolute;
        top: 6px;
        right: 6px;
        background: rgba(15,20,30,0.7);
        border: 1px solid rgba(255,255,255,0.12);
        color: #e57a7a;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.15s, background 0.15s;
        cursor: pointer;
        padding: 0;
    }
    .egg-item:hover .egg-delete-btn { opacity: 1; }
    .egg-delete-btn:hover { background: rgba(229,122,122,0.25); }

    .gallery-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 1.5rem 0.5rem;
        font-size: 0.8rem;
        color: #374455;
        font-style: italic;
    }

    /* ── Auth prompt ───────────────────────────────────────────── */
    .auth-prompt {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.65rem;
        padding: 1.25rem 0.5rem;
        margin-top: 0.25rem;
    }

    .auth-prompt p {
        font-size: 0.83rem;
        color: #566070;
        text-align: center;
        line-height: 1.55;
        margin-bottom: 0.25rem;
    }

    .btn-auth {
        display: block;
        width: 100%;
        text-align: center;
        font-size: 0.83rem;
        font-weight: 600;
        padding: 0.55rem 1rem;
        border-radius: 9px;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }

    .btn-auth-ghost {
        background: transparent;
        color: #8fa0b8;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .btn-auth-ghost:hover {
        background: rgba(255,255,255,0.06);
        color: #dde3ee;
    }

    .btn-auth-fill {
        background: #5a5fcf;
        color: #fff;
        border: 1px solid transparent;
    }
    .btn-auth-fill:hover { background: #4a4fba; }

    /* ── Canvas wrapper ────────────────────────────────────────── */
    .canvas-wrap {
        width: 100%;
    }

    /* ── Page footer ───────────────────────────────────────────── */
    .page-footer {
        text-align: center;
        margin-top: 2.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.78rem;
        color: #3d4a5e;
    }
    .page-footer .heart { color: #c05858; }
</style>

<!-- ── Header ──────────────────────────────────────────────────── -->
<div class="text-center mb-7">
    <h1 class="page-title">Húsvéti Tojásfestő</h1>
    <p class="page-subtitle">
        Válaszd ki a kedvenc színedet és ecsetméretedet, majd fesd ki a virtuális tojásodat
        a 3D térben. Ha elkészültél, mentsd el a galériádba vagy töltsd le.
    </p>
</div>

<!-- ── Layout grid ─────────────────────────────────────────────── -->
<div class="layout-grid">

    <!-- LEFT: Account & Gallery -->
    <aside class="sidebar">
        <div class="glass-card">

            <div class="card-heading">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h10"/>
                </svg>
                Fiókom &amp; Galéria
            </div>

            @auth
                <div class="user-badge">
                    Szia, <strong>{{ Auth::user()->name }}</strong>!
                </div>

                <button id="save-egg-btn" class="btn-save">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Mentés a Galériába
                </button>

                <p class="gallery-label">Mentett tojásaim</p>

                <div id="egg-gallery" class="egg-grid">
                    @forelse(Auth::user()->eggs as $egg)
                        <div class="egg-item" data-egg-id="{{ $egg->id }}">
                            <img src="{{ asset('storage/' . $egg->preview_path) }}"
                                 alt="Tojás"
                                 class="load-egg"
                                 data-texture="{{ asset('storage/' . $egg->texture_path) }}">
                            <button class="egg-delete-btn delete-egg"
                                    title="Törlés"
                                    data-egg-id="{{ $egg->id }}">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    @empty
                        <p class="gallery-empty">Még nem mentettél el tojást.</p>
                    @endforelse
                </div>

            @else
                <div class="auth-prompt">
                    <p>A létrehozott tojások elmentéséhez és betöltéséhez be kell jelentkezned.</p>
                    <a href="{{ route('login') }}"    class="btn-auth btn-auth-ghost">Bejelentkezés</a>
                    <a href="{{ route('register') }}" class="btn-auth btn-auth-fill">Regisztráció</a>
                </div>
            @endauth

        </div>
    </aside>

    <!-- RIGHT: 3D canvas -->
    <div class="canvas-wrap">
        <x-egg-canvas />
    </div>

</div>

<div class="page-footer">
    &copy; 2026 Húsvéti Tojásfestő &mdash;
    készült <span class="heart">&#9829;</span>
    Laravel, Three.js &amp; Tailwind CSS használatával.
</div>

</x-layouts.app>
