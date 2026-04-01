<style>
/* ── Template strip ─────────────────────────────────────────────── */
.template-strip-wrap {
    width: 100%;
    position: relative;
    margin-bottom: 0.75rem;
}

.template-strip-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #3d4f62;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 0.4rem;
    display: block;
}

#templateStrip {
    display: flex;
    gap: 0.55rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
}
#templateStrip::-webkit-scrollbar       { height: 3px; }
#templateStrip::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); border-radius: 2px; }
#templateStrip::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

.tmpl-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.3rem;
    cursor: pointer;
    flex-shrink: 0;
    scroll-snap-align: start;
    transition: transform 0.15s;
}
.tmpl-card:hover { transform: translateY(-2px); }

.tmpl-prev {
    width: 70px;
    height: 70px;
    border-radius: 10px;
    border: 2px solid rgba(255,255,255,0.07);
    transition: border-color 0.15s, box-shadow 0.15s;
    display: block;
}
.tmpl-card:hover .tmpl-prev {
    border-color: rgba(90,95,207,0.4);
    box-shadow: 0 0 0 1px rgba(90,95,207,0.2);
}
.tmpl-card.active .tmpl-prev {
    border-color: #5a5fcf;
    box-shadow: 0 0 0 2px rgba(90,95,207,0.35);
}

.tmpl-card span {
    font-size: 0.62rem;
    color: #4a5e72;
    font-weight: 600;
    letter-spacing: 0.03em;
    transition: color 0.12s;
}
.tmpl-card:hover span  { color: #7a9ab8; }
.tmpl-card.active span { color: #8b92f0; }

/* ── 3D container ───────────────────────────────────────────────── */
#egg3dContainer {
    border-radius: 16px;
    overflow: hidden;
    background: rgba(255,255,255,0.025);
    border: 1px solid rgba(255,255,255,0.07);
    box-shadow:
        0 0 0 1px rgba(90,95,207,0.1),
        inset 0 1px 0 rgba(255,255,255,0.04),
        0 24px 48px rgba(0,0,0,0.4);
}
</style>

<!-- ── Editor shell ──────────────────────────────────────────────── -->
<div class="w-full flex flex-col select-none max-w-5xl mx-auto" style="gap:0.65rem">

    <!-- Toolbar -->
    <x-toolbar />

    <!-- Template strip -->
    <div class="template-strip-wrap">
        <span class="template-strip-label">Sablonok</span>
        <div id="templateStrip">
            <!-- Populated by JS -->
        </div>
    </div>

    <!-- 3D canvas -->
    <div id="egg3dContainer"
         class="w-full aspect-square md:h-150"
         style="min-height:400px; cursor:crosshair; position:relative;">
    </div>

    <!-- Hidden texture canvas -->
    <canvas id="texture-canvas" width="1024" height="1024" class="hidden"></canvas>

</div>
