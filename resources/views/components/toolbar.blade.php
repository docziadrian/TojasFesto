<style>
/* ── Editor toolbar ─────────────────────────────────────────────── */
.editor-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0;
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    padding: 0.55rem 0.75rem;
    width: 100%;
    overflow: hidden;
}

.eb-section {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0 0.55rem;
    flex-wrap: wrap;
}

.eb-sep {
    width: 1px;
    align-self: stretch;
    background: rgba(255,255,255,0.07);
    margin: 0.1rem 0;
    flex-shrink: 0;
}

.eb-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #3d4f62;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    white-space: nowrap;
    margin-right: 0.1rem;
}

/* ── Tool buttons ───────────────────────────────────────────────── */
.tool-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1px solid transparent;
    background: transparent;
    color: #5a6e84;
    cursor: pointer;
    transition: background 0.12s, color 0.12s, border-color 0.12s;
    flex-shrink: 0;
}
.tool-btn:hover {
    background: rgba(255,255,255,0.07);
    color: #c0cfe0;
}
.tool-btn.active {
    background: rgba(90,95,207,0.18);
    border-color: rgba(90,95,207,0.45);
    color: #8b92f0;
}

/* ── Sliders ────────────────────────────────────────────────────── */
.eb-slider-row {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.eb-slider {
    -webkit-appearance: none;
    appearance: none;
    width: 90px;
    height: 4px;
    border-radius: 2px;
    background: rgba(255,255,255,0.1);
    outline: none;
    cursor: pointer;
}
.eb-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #5a5fcf;
    border: 2px solid rgba(255,255,255,0.2);
    cursor: pointer;
    transition: background 0.12s, transform 0.1s;
}
.eb-slider::-webkit-slider-thumb:hover { transform: scale(1.2); }
.eb-slider::-moz-range-thumb {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #5a5fcf;
    border: 2px solid rgba(255,255,255,0.2);
    cursor: pointer;
}

.eb-val {
    font-size: 0.7rem;
    font-weight: 700;
    color: #5a5fcf;
    min-width: 28px;
    text-align: right;
}

/* ── Color swatches ─────────────────────────────────────────────── */
.color-btn {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.0);
    cursor: pointer;
    flex-shrink: 0;
    transition: transform 0.1s, border-color 0.12s, box-shadow 0.12s;
    position: relative;
    display: inline-block;
}
.color-btn:hover {
    transform: scale(1.2);
    border-color: rgba(255,255,255,0.35);
}
.color-btn.active {
    border-color: #fff;
    box-shadow: 0 0 0 2px #5a5fcf;
    transform: scale(1.15);
}

.color-picker-wrap {
    background: conic-gradient(red, yellow, lime, aqua, blue, magenta, red);
    cursor: pointer;
    overflow: hidden;
}
.color-picker-wrap input[type="color"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}

/* ── Action buttons ─────────────────────────────────────────────── */
.act-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
    padding: 0.3rem 0.65rem;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.08);
    background: transparent;
    color: #6b7e94;
    font-size: 0.72rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.12s, color 0.12s, border-color 0.12s;
}
.act-btn:hover {
    background: rgba(255,255,255,0.07);
    color: #c0cfe0;
    border-color: rgba(255,255,255,0.15);
}
.act-btn--danger:hover  { background: rgba(229,80,80,0.12); color: #e57070; border-color: rgba(229,80,80,0.25); }
.act-btn--dl:hover      { background: rgba(40,180,100,0.1); color: #4ade80; border-color: rgba(74,222,128,0.25); }
</style>

<div class="editor-bar">

    <!-- ── Tools ───────────────────────────────────────── -->
    <div class="eb-section">
        <span class="eb-label">Eszköz</span>
        <button class="tool-btn active" data-tool="brush" title="Ecset">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 17c0 0 4-1 6-4l8-8a2 2 0 0 0-3-3L6 11c-3 2-4 6-4 6z"/>
                <path d="M9 7l3 3"/>
            </svg>
        </button>
        <button class="tool-btn" data-tool="spray" title="Spray">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 3h2v18H3z"/><path d="M7 8h10"/><path d="M7 12h6"/><path d="M7 16h3"/>
                <circle cx="18" cy="8" r="1" fill="currentColor"/>
                <circle cx="20" cy="12" r="1" fill="currentColor"/>
                <circle cx="17" cy="15" r="1" fill="currentColor"/>
                <circle cx="21" cy="16" r="1" fill="currentColor"/>
                <circle cx="19" cy="19" r="1" fill="currentColor"/>
            </svg>
        </button>
        <button class="tool-btn" data-tool="eraser" title="Radír">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 20H7L3 16l10-10 7 7-3.5 3.5"/>
                <path d="M6.5 17.5l4-4"/>
            </svg>
        </button>
        <button class="tool-btn" data-tool="fill" title="Kitöltés (vödör)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 11L8.93 3.36a1 1 0 0 0-1.56.83V11"/>
                <path d="M5 11h14a2 2 0 0 1 2 2v2a7 7 0 0 1-7 7 7 7 0 0 1-7-7v-2a2 2 0 0 1 2-2z"/>
            </svg>
        </button>
    </div>

    <div class="eb-sep"></div>

    <!-- ── Brush size + Opacity ─────────────────────────── -->
    <div class="eb-section" style="flex-direction:column; gap:0.3rem; align-items:flex-start;">
        <div class="eb-slider-row">
            <span class="eb-label" style="width:60px">Méret</span>
            <input type="range" id="brushSize" min="1" max="60" value="10" class="eb-slider">
            <span class="eb-val"><span id="brushSizeLabel">10</span></span>
        </div>
        <div class="eb-slider-row">
            <span class="eb-label" style="width:60px">Átlátszóság</span>
            <input type="range" id="opacitySlider" min="1" max="100" value="100" class="eb-slider">
            <span class="eb-val"><span id="opacityLabel">100</span>%</span>
        </div>
    </div>

    <div class="eb-sep"></div>

    <!-- ── Material ─────────────────────────────────────── -->
    <div class="eb-section" style="flex-direction:column; gap:0.3rem; align-items:flex-start;">
        <div class="eb-slider-row">
            <span class="eb-label" style="width:60px">Érdesség</span>
            <input type="range" id="roughnessSlider" min="0" max="100" value="45" class="eb-slider">
        </div>
        <div class="eb-slider-row">
            <span class="eb-label" style="width:60px">Fémesség</span>
            <input type="range" id="metalnessSlider" min="0" max="100" value="8" class="eb-slider">
        </div>
    </div>

    <div class="eb-sep"></div>

    <!-- ── Colors ───────────────────────────────────────── -->
    <div class="eb-section" style="gap:0.4rem;">
        <button class="color-btn" data-color="#ef4444" style="background:#ef4444" title="Piros"></button>
        <button class="color-btn" data-color="#f97316" style="background:#f97316" title="Narancs"></button>
        <button class="color-btn" data-color="#eab308" style="background:#eab308" title="Sárga"></button>
        <button class="color-btn" data-color="#22c55e" style="background:#22c55e" title="Zöld"></button>
        <button class="color-btn" data-color="#0ea5e9" style="background:#0ea5e9" title="Égkék"></button>
        <button class="color-btn" data-color="#3b82f6" style="background:#3b82f6" title="Kék"></button>
        <button class="color-btn" data-color="#8b5cf6" style="background:#8b5cf6" title="Lila"></button>
        <button class="color-btn" data-color="#ec4899" style="background:#ec4899" title="Rózsaszín"></button>
        <button class="color-btn" data-color="#f1f5f9" style="background:#f1f5f9;box-shadow:inset 0 0 0 1px rgba(255,255,255,0.2)" title="Fehér"></button>
        <button class="color-btn" data-color="#b8860b" style="background:#b8860b" title="Arany"></button>
        <button class="color-btn" data-color="#0f172a" style="background:#0f172a;box-shadow:inset 0 0 0 1px rgba(255,255,255,0.1)" title="Fekete"></button>
        <label class="color-btn color-picker-wrap" title="Egyedi szín választása">
            <input type="color" id="colorPicker" value="#ef4444">
        </label>
    </div>

    <div class="eb-sep"></div>

    <!-- ── Actions ──────────────────────────────────────── -->
    <div class="eb-section" style="gap:0.4rem;">
        <button id="undoBtn" class="act-btn" title="Visszavonás (Ctrl+Z)">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/>
            </svg>
            Vissza
        </button>
        <button id="clearBtn" class="act-btn act-btn--danger" title="Törlés">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
            </svg>
            Törlés
        </button>
        <button id="saveBtn" class="act-btn act-btn--dl" title="Letöltés PNG-ben">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Letöltés
        </button>
    </div>

</div>
