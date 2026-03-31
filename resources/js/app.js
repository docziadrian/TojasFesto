import "./bootstrap";
import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";

// ── Template drawing functions ────────────────────────────────────────────────
function drawTemplateToCtx(c, S, id) {
    c.clearRect(0, 0, S, S);

    // Helper: deterministic pseudo-random from index
    const rng = (seed) => {
        let x = Math.sin(seed + 1) * 43758.5453;
        return x - Math.floor(x);
    };

    switch (id) {
        case "blank":
            c.fillStyle = "#fffaf0";
            c.fillRect(0, 0, S, S);
            break;

        case "marble": {
            c.fillStyle = "#f0ece6";
            c.fillRect(0, 0, S, S);
            const veins = [
                "rgba(170,155,140,0.45)",
                "rgba(130,115,100,0.3)",
                "rgba(200,185,168,0.5)",
                "rgba(90,80,70,0.2)",
            ];
            for (let i = 0; i < 18; i++) {
                c.beginPath();
                c.strokeStyle = veins[i % veins.length];
                c.lineWidth = 0.8 + rng(i * 7) * 2.5;
                const x0 = rng(i * 13) * S;
                const y0 = rng(i * 17) * S;
                c.moveTo(x0, y0);
                c.bezierCurveTo(
                    x0 + (rng(i * 3) - 0.5) * S * 0.7,
                    y0 + rng(i * 5) * S * 0.5,
                    rng(i * 11) * S,
                    rng(i * 19) * S,
                    rng(i * 23) * S,
                    rng(i * 29) * S
                );
                c.stroke();
            }
            // Subtle sheen overlay
            const mg = c.createLinearGradient(0, 0, S, S);
            mg.addColorStop(0, "rgba(255,250,245,0.18)");
            mg.addColorStop(0.5, "rgba(200,190,180,0.05)");
            mg.addColorStop(1, "rgba(255,250,245,0.12)");
            c.fillStyle = mg;
            c.fillRect(0, 0, S, S);
            break;
        }

        case "gold": {
            c.fillStyle = "#b8860b";
            c.fillRect(0, 0, S, S);
            for (let i = 0; i < 24; i++) {
                const y = (i / 24) * S;
                const bright = Math.sin(i * 0.9) * 0.5 + 0.5;
                c.fillStyle = `rgba(255,215,60,${bright * 0.35})`;
                c.fillRect(0, y, S, S / 24);
            }
            const gg = c.createLinearGradient(0, 0, S * 0.6, S);
            gg.addColorStop(0, "rgba(255,238,130,0.5)");
            gg.addColorStop(0.4, "rgba(200,155,10,0.1)");
            gg.addColorStop(1, "rgba(255,200,40,0.35)");
            c.fillStyle = gg;
            c.fillRect(0, 0, S, S);
            // Fine cross-hatch lines
            c.strokeStyle = "rgba(255,240,100,0.1)";
            c.lineWidth = 0.5;
            for (let i = 0; i < 30; i++) {
                c.beginPath();
                c.moveTo(0, (i / 30) * S);
                c.lineTo(S, (i / 30) * S);
                c.stroke();
            }
            break;
        }

        case "galaxy": {
            c.fillStyle = "#07071a";
            c.fillRect(0, 0, S, S);
            // Stars
            const starCount = Math.round(S * 0.18);
            for (let i = 0; i < starCount; i++) {
                const x = rng(i * 127.1) * S;
                const y = rng(i * 311.7) * S;
                const r = 0.4 + rng(i * 93.4) * 1.2;
                const a = 0.4 + rng(i * 57.3) * 0.6;
                c.beginPath();
                c.arc(x, y, r, 0, Math.PI * 2);
                c.fillStyle = `rgba(255,255,255,${a})`;
                c.fill();
            }
            // Nebula blobs
            const nb = [
                { x: 0.35, y: 0.45, r: 0.38, col: "rgba(80,30,140,0.28)" },
                { x: 0.65, y: 0.6, r: 0.3, col: "rgba(20,60,140,0.22)" },
                { x: 0.2, y: 0.7, r: 0.25, col: "rgba(140,20,80,0.18)" },
            ];
            nb.forEach(({ x, y, r, col }) => {
                const ng = c.createRadialGradient(x * S, y * S, 0, x * S, y * S, r * S);
                ng.addColorStop(0, col);
                ng.addColorStop(1, "rgba(0,0,0,0)");
                c.fillStyle = ng;
                c.fillRect(0, 0, S, S);
            });
            break;
        }

        case "stripes": {
            const cols = ["#f87171", "#fb923c", "#fbbf24", "#4ade80", "#60a5fa", "#a78bfa", "#f472b6"];
            const h = S / cols.length;
            cols.forEach((col, i) => {
                c.fillStyle = col;
                c.fillRect(0, i * h, S, h);
            });
            // Subtle wave overlay
            c.strokeStyle = "rgba(255,255,255,0.2)";
            c.lineWidth = 1;
            for (let i = 0; i < cols.length; i++) {
                c.beginPath();
                c.moveTo(0, (i + 0.5) * h);
                for (let x = 0; x <= S; x += 4) {
                    c.lineTo(x, (i + 0.5) * h + Math.sin(x / (S * 0.08)) * 4);
                }
                c.stroke();
            }
            break;
        }

        case "polka": {
            c.fillStyle = "#fef9f0";
            c.fillRect(0, 0, S, S);
            const dotColors = ["#ef4444", "#f97316", "#eab308", "#22c55e", "#3b82f6", "#8b5cf6", "#ec4899"];
            const spacing = S / 8;
            let ci = 0;
            for (let row = 0; row < 9; row++) {
                for (let col = 0; col < 9; col++) {
                    const x = col * spacing + (row % 2 === 0 ? spacing / 2 : 0);
                    const y = row * spacing;
                    c.beginPath();
                    c.arc(x, y, spacing * 0.32, 0, Math.PI * 2);
                    c.fillStyle = dotColors[ci % dotColors.length];
                    c.fill();
                    ci++;
                }
            }
            break;
        }

        case "geo": {
            c.fillStyle = "#12112a";
            c.fillRect(0, 0, S, S);
            const cell = S / 10;
            for (let row = 0; row < 11; row++) {
                for (let col = 0; col < 11; col++) {
                    const cx = col * cell;
                    const cy = row * cell;
                    c.beginPath();
                    c.moveTo(cx, cy - cell * 0.45);
                    c.lineTo(cx + cell * 0.45, cy);
                    c.lineTo(cx, cy + cell * 0.45);
                    c.lineTo(cx - cell * 0.45, cy);
                    c.closePath();
                    const tone = (row + col) % 2 === 0 ? "rgba(90,95,207,0.3)" : "rgba(60,65,160,0.15)";
                    c.fillStyle = tone;
                    c.fill();
                    c.strokeStyle = "rgba(100,110,220,0.25)";
                    c.lineWidth = 0.6;
                    c.stroke();
                }
            }
            break;
        }

        case "spring": {
            c.fillStyle = "#e8f5e9";
            c.fillRect(0, 0, S, S);
            // Diagonal leaf stripes
            c.strokeStyle = "rgba(100,180,100,0.25)";
            c.lineWidth = 2;
            for (let i = -S; i < S * 2; i += 60) {
                c.beginPath();
                c.moveTo(i, 0);
                c.lineTo(i + S, S);
                c.stroke();
            }
            // Flowers
            const flowerCols = ["#f9a8d4", "#fde68a", "#bbf7d0", "#a5f3fc", "#ddd6fe"];
            for (let i = 0; i < 18; i++) {
                const fx = rng(i * 31) * S;
                const fy = rng(i * 37) * S;
                const fr = S * 0.03;
                const fc = flowerCols[i % flowerCols.length];
                for (let p = 0; p < 5; p++) {
                    const angle = (p / 5) * Math.PI * 2;
                    c.beginPath();
                    c.arc(fx + Math.cos(angle) * fr, fy + Math.sin(angle) * fr, fr * 0.7, 0, Math.PI * 2);
                    c.fillStyle = fc;
                    c.fill();
                }
                c.beginPath();
                c.arc(fx, fy, fr * 0.5, 0, Math.PI * 2);
                c.fillStyle = "#fef08a";
                c.fill();
            }
            break;
        }

        case "sunset": {
            const sg = c.createLinearGradient(0, 0, 0, S);
            sg.addColorStop(0, "#1e1b4b");
            sg.addColorStop(0.3, "#7c3aed");
            sg.addColorStop(0.55, "#db2777");
            sg.addColorStop(0.75, "#f97316");
            sg.addColorStop(1, "#fcd34d");
            c.fillStyle = sg;
            c.fillRect(0, 0, S, S);
            // Horizon glow
            const hg = c.createRadialGradient(S / 2, S * 0.72, 0, S / 2, S * 0.72, S * 0.45);
            hg.addColorStop(0, "rgba(255,200,80,0.45)");
            hg.addColorStop(1, "rgba(0,0,0,0)");
            c.fillStyle = hg;
            c.fillRect(0, 0, S, S);
            break;
        }

        case "ocean": {
            const og = c.createLinearGradient(0, 0, 0, S);
            og.addColorStop(0, "#1e40af");
            og.addColorStop(0.5, "#0284c7");
            og.addColorStop(1, "#06b6d4");
            c.fillStyle = og;
            c.fillRect(0, 0, S, S);
            // Waves
            for (let i = 0; i < 18; i++) {
                const y = (i / 18) * S;
                const alpha = 0.06 + (i / 18) * 0.12;
                c.beginPath();
                c.moveTo(0, y);
                for (let x = 0; x <= S; x += 5) {
                    c.lineTo(x, y + Math.sin((x / S) * Math.PI * 5 + i * 0.4) * (S * 0.018));
                }
                c.lineTo(S, S);
                c.lineTo(0, S);
                c.closePath();
                c.fillStyle = `rgba(255,255,255,${alpha})`;
                c.fill();
            }
            break;
        }

        case "rose": {
            c.fillStyle = "#fce4ec";
            c.fillRect(0, 0, S, S);
            // Rose petals from center
            const cx = S / 2, cy = S / 2;
            const petalCols = ["#f9a8d4", "#f472b6", "#ec4899", "#fbcfe8", "#fda4af"];
            for (let i = 0; i < 32; i++) {
                const a = (i / 32) * Math.PI * 2;
                const r = S * 0.15 + rng(i * 11) * S * 0.22;
                c.beginPath();
                c.ellipse(
                    cx + Math.cos(a) * r * 0.5,
                    cy + Math.sin(a) * r * 0.5,
                    r * 0.28, r * 0.16,
                    a, 0, Math.PI * 2
                );
                c.fillStyle = petalCols[i % petalCols.length];
                c.globalAlpha = 0.55;
                c.fill();
            }
            c.globalAlpha = 1;
            // Center
            c.beginPath();
            c.arc(cx, cy, S * 0.07, 0, Math.PI * 2);
            c.fillStyle = "#f43f5e";
            c.fill();
            break;
        }

        case "nordic": {
            c.fillStyle = "#f8f4ef";
            c.fillRect(0, 0, S, S);
            const nc = "#c0392b";
            const nb2 = "#2c3e90";
            // Horizontal band
            c.fillStyle = nb2;
            c.fillRect(0, S * 0.42, S, S * 0.16);
            // Vertical band
            c.fillStyle = nb2;
            c.fillRect(S * 0.3, 0, S * 0.16, S);
            // Red cross inner
            c.fillStyle = nc;
            c.fillRect(0, S * 0.455, S, S * 0.09);
            c.fillStyle = nc;
            c.fillRect(S * 0.335, 0, S * 0.09, S);
            break;
        }

        default:
            c.fillStyle = "#fffaf0";
            c.fillRect(0, 0, S, S);
    }
}

const TEMPLATES = [
    { id: "blank",   label: "Üres" },
    { id: "marble",  label: "Márvány" },
    { id: "gold",    label: "Arany" },
    { id: "galaxy",  label: "Galaxis" },
    { id: "stripes", label: "Csíkos" },
    { id: "polka",   label: "Pöttyös" },
    { id: "geo",     label: "Geometrikus" },
    { id: "spring",  label: "Tavaszi" },
    { id: "sunset",  label: "Naplemente" },
    { id: "ocean",   label: "Óceán" },
    { id: "rose",    label: "Rózsa" },
    { id: "nordic",  label: "Nordik" },
];

// ── Main app ──────────────────────────────────────────────────────────────────
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("egg3dContainer");
    if (!container) return;

    // ── Three.js Setup ────────────────────────────────────────────────────────
    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(
        45,
        container.clientWidth / container.clientHeight,
        0.1,
        1000
    );
    camera.position.set(0, 0, 8);

    const renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true,
        preserveDrawingBuffer: true,
    });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enablePan = false;
    controls.minDistance = 4;
    controls.maxDistance = 15;
    controls.enableDamping = true;
    controls.dampingFactor = 0.07;

    // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.55);
    scene.add(ambientLight);
    const dirLight = new THREE.DirectionalLight(0xffffff, 0.9);
    dirLight.position.set(5, 6, 5);
    scene.add(dirLight);
    const dirLight2 = new THREE.DirectionalLight(0xb8c4ff, 0.35);
    dirLight2.position.set(-5, -2, -5);
    scene.add(dirLight2);
    const rimLight = new THREE.DirectionalLight(0xffd0a0, 0.2);
    rimLight.position.set(0, -5, 3);
    scene.add(rimLight);

    // ── Texture Canvas ────────────────────────────────────────────────────────
    const TEX_SIZE = 1024;
    const drawingCanvas = document.createElement("canvas");
    drawingCanvas.width = TEX_SIZE;
    drawingCanvas.height = TEX_SIZE;
    const ctx = drawingCanvas.getContext("2d");

    let bgColor = "#fffaf0";

    function clearTextureCanvas() {
        ctx.globalAlpha = 1;
        ctx.globalCompositeOperation = "source-over";
        ctx.fillStyle = bgColor;
        ctx.fillRect(0, 0, TEX_SIZE, TEX_SIZE);
    }
    clearTextureCanvas();

    const eggTexture = new THREE.CanvasTexture(drawingCanvas);
    eggTexture.colorSpace = THREE.SRGBColorSpace;
    eggTexture.minFilter = THREE.LinearFilter;

    // ── Egg Geometry ──────────────────────────────────────────────────────────
    const geometry = new THREE.SphereGeometry(2, 64, 64);
    const positions = geometry.attributes.position;
    const v = new THREE.Vector3();
    for (let i = 0; i < positions.count; i++) {
        v.fromBufferAttribute(positions, i);
        if (v.y > 0) {
            v.y *= 1.3;
            v.x *= 0.98;
            v.z *= 0.98;
        } else {
            v.y *= 0.95;
            v.x *= 1.02;
            v.z *= 1.02;
        }
        positions.setXYZ(i, v.x, v.y, v.z);
    }
    geometry.computeVertexNormals();

    const material = new THREE.MeshStandardMaterial({
        map: eggTexture,
        roughness: 0.45,
        metalness: 0.08,
    });

    const eggMesh = new THREE.Mesh(geometry, material);
    scene.add(eggMesh);

    // ── State ─────────────────────────────────────────────────────────────────
    let isDrawing    = false;
    let currentColor = "#ef4444";
    let currentSize  = 10;
    let currentOpacity = 1.0;
    let currentTool  = "brush";
    let lastUV       = null;

    // ── Undo ──────────────────────────────────────────────────────────────────
    const undoStack = [];
    const MAX_UNDO  = 20;

    function saveUndoState() {
        if (undoStack.length >= MAX_UNDO) undoStack.shift();
        undoStack.push(ctx.getImageData(0, 0, TEX_SIZE, TEX_SIZE));
    }

    function undo() {
        if (undoStack.length === 0) return;
        const state = undoStack.pop();
        ctx.putImageData(state, 0, 0);
        eggTexture.needsUpdate = true;
    }

    // ── Drawing ───────────────────────────────────────────────────────────────
    function hexToRgb(hex) {
        const r = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return r ? { r: parseInt(r[1], 16), g: parseInt(r[2], 16), b: parseInt(r[3], 16) } : null;
    }

    function paintStroke(tx, ty) {
        const col = currentTool === "eraser" ? bgColor : currentColor;
        ctx.globalAlpha     = currentOpacity;
        ctx.fillStyle       = col;
        ctx.strokeStyle     = col;
        ctx.lineWidth       = currentSize * 2;
        ctx.lineCap         = "round";
        ctx.lineJoin        = "round";
        ctx.globalCompositeOperation = "source-over";

        if (lastUV) {
            const dist = Math.hypot(tx - lastUV.x, ty - lastUV.y);
            if (dist < 120) {
                ctx.beginPath();
                ctx.moveTo(lastUV.x, lastUV.y);
                ctx.lineTo(tx, ty);
                ctx.stroke();
            } else {
                ctx.beginPath();
                ctx.arc(tx, ty, currentSize, 0, Math.PI * 2);
                ctx.fill();
            }
        } else {
            ctx.beginPath();
            ctx.arc(tx, ty, currentSize, 0, Math.PI * 2);
            ctx.fill();
        }
        ctx.globalAlpha = 1;
    }

    function sprayAt(tx, ty) {
        const density = 40;
        const radius  = currentSize * 3.5;
        const col = hexToRgb(currentColor);
        if (!col) return;
        for (let i = 0; i < density; i++) {
            const angle = Math.random() * Math.PI * 2;
            const r     = Math.sqrt(Math.random()) * radius;
            const x     = tx + Math.cos(angle) * r;
            const y     = ty + Math.sin(angle) * r;
            ctx.beginPath();
            ctx.arc(x, y, 0.8 + Math.random() * 1.2, 0, Math.PI * 2);
            ctx.fillStyle = currentColor;
            ctx.globalAlpha = currentOpacity * (0.3 + Math.random() * 0.5);
            ctx.fill();
        }
        ctx.globalAlpha = 1;
    }

    function floodFill(startX, startY) {
        const imageData = ctx.getImageData(0, 0, TEX_SIZE, TEX_SIZE);
        const data      = imageData.data;
        const si        = (startY * TEX_SIZE + startX) * 4;
        const tR = data[si], tG = data[si + 1], tB = data[si + 2];
        const fill = hexToRgb(currentColor);
        if (!fill) return;
        if (tR === fill.r && tG === fill.g && tB === fill.b) return;
        const fA = Math.round(currentOpacity * 255);
        const tol = 30;
        const matches = (idx) =>
            Math.abs(data[idx]   - tR) <= tol &&
            Math.abs(data[idx+1] - tG) <= tol &&
            Math.abs(data[idx+2] - tB) <= tol;
        const visited = new Uint8Array(TEX_SIZE * TEX_SIZE);
        const stack = [startX + startY * TEX_SIZE];
        while (stack.length) {
            const pos = stack.pop();
            const x = pos % TEX_SIZE;
            const y = (pos - x) / TEX_SIZE;
            if (x < 0 || x >= TEX_SIZE || y < 0 || y >= TEX_SIZE) continue;
            if (visited[pos]) continue;
            const idx = pos * 4;
            if (!matches(idx)) continue;
            visited[pos] = 1;
            data[idx]   = fill.r;
            data[idx+1] = fill.g;
            data[idx+2] = fill.b;
            data[idx+3] = fA;
            stack.push(pos + 1, pos - 1, pos + TEX_SIZE, pos - TEX_SIZE);
        }
        ctx.putImageData(imageData, 0, 0);
    }

    function handleDrawAt(tx, ty) {
        if (currentTool === "spray") {
            sprayAt(tx, ty);
        } else {
            paintStroke(tx, ty);
        }
        eggTexture.needsUpdate = true;
    }

    // ── Raycasting helper ─────────────────────────────────────────────────────
    const raycaster = new THREE.Raycaster();
    const mouse     = new THREE.Vector2();

    function getUVFromEvent(event) {
        let clientX = event.clientX, clientY = event.clientY;
        if (event.touches && event.touches.length > 0) {
            clientX = event.touches[0].clientX;
            clientY = event.touches[0].clientY;
        }
        const rect = renderer.domElement.getBoundingClientRect();
        mouse.x = ((clientX - rect.left) / rect.width) * 2 - 1;
        mouse.y = -((clientY - rect.top) / rect.height) * 2 + 1;
        raycaster.setFromCamera(mouse, camera);
        const hits = raycaster.intersectObject(eggMesh);
        if (!hits.length) return null;
        const uv = hits[0].uv;
        return { x: uv.x * TEX_SIZE, y: (1 - uv.y) * TEX_SIZE };
    }

    // ── Pointer events ────────────────────────────────────────────────────────
    renderer.domElement.addEventListener("pointerdown", (e) => {
        if (e.button === 2 || e.button === 1) return;
        const uv = getUVFromEvent(e);
        if (!uv) return;
        saveUndoState();
        if (currentTool === "fill") {
            floodFill(Math.round(uv.x), Math.round(uv.y));
            eggTexture.needsUpdate = true;
            return;
        }
        isDrawing = true;
        controls.enabled = false;
        lastUV = null;
        handleDrawAt(uv.x, uv.y);
        lastUV = uv;
    });

    renderer.domElement.addEventListener("pointermove", (e) => {
        if (!isDrawing) return;
        const uv = getUVFromEvent(e);
        if (uv) {
            handleDrawAt(uv.x, uv.y);
            lastUV = uv;
        } else {
            lastUV = null;
        }
    });

    window.addEventListener("pointerup", () => {
        if (isDrawing) {
            isDrawing = false;
            lastUV = null;
            controls.enabled = true;
        }
    });

    // ── UI: Tool buttons ──────────────────────────────────────────────────────
    document.querySelectorAll(".tool-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            currentTool = btn.dataset.tool;
            document.querySelectorAll(".tool-btn").forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");
        });
    });

    // ── UI: Color ─────────────────────────────────────────────────────────────
    const colorPicker = document.getElementById("colorPicker");
    const colorBtns   = document.querySelectorAll(".color-btn");

    function setActiveColor(color, btn = null) {
        currentColor = color;
        colorBtns.forEach((b) => b.classList.remove("active"));
        if (btn) btn.classList.add("active");
        if (colorPicker) colorPicker.value = color;
    }

    colorBtns.forEach((btn) => {
        btn.addEventListener("click", () => setActiveColor(btn.dataset.color, btn));
    });
    if (colorPicker) {
        colorPicker.addEventListener("input", (e) => setActiveColor(e.target.value));
    }
    if (colorBtns.length > 0) {
        setActiveColor(colorBtns[0].dataset.color, colorBtns[0]);
    }

    // ── UI: Brush size ────────────────────────────────────────────────────────
    const brushSizeInput = document.getElementById("brushSize");
    const brushSizeLabel = document.getElementById("brushSizeLabel");
    if (brushSizeInput) {
        brushSizeInput.addEventListener("input", (e) => {
            currentSize = +e.target.value;
            if (brushSizeLabel) brushSizeLabel.textContent = currentSize;
        });
    }

    // ── UI: Opacity ───────────────────────────────────────────────────────────
    const opacitySlider = document.getElementById("opacitySlider");
    const opacityLabel  = document.getElementById("opacityLabel");
    if (opacitySlider) {
        opacitySlider.addEventListener("input", (e) => {
            currentOpacity = +e.target.value / 100;
            if (opacityLabel) opacityLabel.textContent = e.target.value + "%";
        });
    }

    // ── UI: Material roughness / metalness ────────────────────────────────────
    const roughnessSlider = document.getElementById("roughnessSlider");
    if (roughnessSlider) {
        roughnessSlider.addEventListener("input", (e) => {
            material.roughness = +e.target.value / 100;
        });
    }
    const metalnessSlider = document.getElementById("metalnessSlider");
    if (metalnessSlider) {
        metalnessSlider.addEventListener("input", (e) => {
            material.metalness = +e.target.value / 100;
        });
    }

    // ── UI: Undo ──────────────────────────────────────────────────────────────
    const undoBtn = document.getElementById("undoBtn");
    if (undoBtn) undoBtn.addEventListener("click", undo);
    document.addEventListener("keydown", (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === "z") {
            e.preventDefault();
            undo();
        }
    });

    // ── UI: Clear ─────────────────────────────────────────────────────────────
    const clearBtn = document.getElementById("clearBtn");
    if (clearBtn) {
        clearBtn.addEventListener("click", () => {
            if (!confirm("Biztosan letörlöd a tojásról a festéket?")) return;
            saveUndoState();
            clearTextureCanvas();
            eggTexture.needsUpdate = true;
        });
    }

    // ── UI: Download ──────────────────────────────────────────────────────────
    const saveBtn = document.getElementById("saveBtn");
    if (saveBtn) {
        saveBtn.addEventListener("click", () => {
            const dataUrl = renderer.domElement.toDataURL("image/png");
            const a = document.createElement("a");
            a.download = "husveti-tojas.png";
            a.href = dataUrl;
            a.click();
        });
    }

    // ── Templates ─────────────────────────────────────────────────────────────
    function applyTemplate(id) {
        saveUndoState();
        // Update bgColor for eraser and clear
        const bgMap = {
            blank: "#fffaf0", marble: "#f0ece6", gold: "#b8860b",
            galaxy: "#07071a", stripes: "#f87171", polka: "#fef9f0",
            geo: "#12112a", spring: "#e8f5e9", sunset: "#1e1b4b",
            ocean: "#1e40af", rose: "#fce4ec", nordic: "#f8f4ef",
        };
        bgColor = bgMap[id] ?? "#fffaf0";
        drawTemplateToCtx(ctx, TEX_SIZE, id);
        eggTexture.needsUpdate = true;
    }

    // Build template strip HTML + render previews
    const strip = document.getElementById("templateStrip");
    if (strip) {
        strip.innerHTML = "";
        TEMPLATES.forEach((tmpl) => {
            const card = document.createElement("div");
            card.className = "tmpl-card";
            card.dataset.template = tmpl.id;
            card.title = tmpl.label;

            const cv = document.createElement("canvas");
            cv.width = cv.height = 90;
            cv.className = "tmpl-prev";
            drawTemplateToCtx(cv.getContext("2d"), 90, tmpl.id);

            const label = document.createElement("span");
            label.textContent = tmpl.label;

            card.appendChild(cv);
            card.appendChild(label);
            strip.appendChild(card);

            card.addEventListener("click", () => {
                document.querySelectorAll(".tmpl-card").forEach((c) => c.classList.remove("active"));
                card.classList.add("active");
                applyTemplate(tmpl.id);
            });
        });
    }

    // ── Resize ────────────────────────────────────────────────────────────────
    window.addEventListener("resize", () => {
        if (!container) return;
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });

    // ── Animation loop ────────────────────────────────────────────────────────
    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }
    animate();

    // ── Gallery: Save to backend ──────────────────────────────────────────────
    const saveGalleryBtn = document.getElementById("save-egg-btn");
    if (saveGalleryBtn) {
        saveGalleryBtn.addEventListener("click", async () => {
            const orig = saveGalleryBtn.innerHTML;
            saveGalleryBtn.disabled = true;
            saveGalleryBtn.innerHTML = "Mentés...";
            try {
                const response = await fetch("/api/eggs", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content,
                    },
                    body: JSON.stringify({
                        texture: drawingCanvas.toDataURL("image/png"),
                        preview: renderer.domElement.toDataURL("image/png"),
                    }),
                });
                const data = await response.json();
                if (data.success) location.reload();
                else alert("Hiba történt a mentés során.");
            } catch {
                alert("Hiba történt a mentés során.");
            } finally {
                saveGalleryBtn.disabled = false;
                saveGalleryBtn.innerHTML = orig;
            }
        });
    }

    // ── Gallery: Delete ───────────────────────────────────────────────────────
    document.querySelectorAll(".delete-egg").forEach((btn) => {
        btn.addEventListener("click", async function (e) {
            e.stopPropagation();
            if (!confirm("Biztosan törlöd ezt a tojást?")) return;
            const id = this.dataset.eggId;
            try {
                const res = await fetch("/api/eggs/" + id, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content,
                    },
                });
                const data = await res.json();
                if (data.success) location.reload();
            } catch {}
        });
    });

    // ── Gallery: Load ─────────────────────────────────────────────────────────
    document.querySelectorAll(".load-egg").forEach((img) => {
        img.addEventListener("click", function () {
            const src = this.dataset.texture;
            const image = new Image();
            image.crossOrigin = "Anonymous";
            image.onload = () => {
                saveUndoState();
                ctx.clearRect(0, 0, TEX_SIZE, TEX_SIZE);
                ctx.drawImage(image, 0, 0);
                eggTexture.needsUpdate = true;
            };
            image.src = src;
        });
    });
});
