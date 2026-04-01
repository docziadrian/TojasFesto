window.saveEgg = async function() {
    const saveBtn = document.getElementById("save-egg-btn");
    if(!saveBtn) return;
    saveBtn.disabled = true;
    saveBtn.innerText = "Mentés...";

    const textureData = document.getElementById("texture-canvas").toDataURL("image/png");
    const previewData = renderer.domElement.toDataURL("image/png");

    try {
        const response = await fetch("/api/eggs", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector("meta[name=\"csrf-token\"]")?.getAttribute("content")
            },
            body: JSON.stringify({
                texture: textureData,
                preview: previewData
            })
        });

        const data = await response.json();
        if(data.success) {
            location.reload(); // Egyszerű frissítés a galéria miatt
        } else {
            alert("Hiba történt a mentés során.");
        }
    } catch (e) {
        console.error(e);
        alert("Hiba történt a mentés során.");
    } finally {
        saveBtn.disabled = false;
        saveBtn.innerText = "Mentés a galériába";
    }
};

document.getElementById("save-egg-btn")?.addEventListener("click", window.saveEgg);

document.querySelectorAll(".delete-egg").forEach(btn => {
    btn.addEventListener("click", async function(e) {
        if(!confirm("Biztosan törlöd?")) return;
        const id = this.getAttribute("data-egg-id");
        try {
            const response = await fetch("/api/eggs/" + id, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector("meta[name=\"csrf-token\"]")?.getAttribute("content")
                }
            });
            const data = await response.json();
            if(data.success) {
                location.reload();
            }
        } catch(e) {
            console.error(e);
        }
    });
});

document.querySelectorAll(".load-egg").forEach(img => {
    img.addEventListener("click", function(e) {
        e.preventDefault();
        const textureSrc = this.getAttribute("data-texture");
        const imgObj = new Image();
        imgObj.onload = function() {
            drawingContext.clearRect(0, 0, drawingCanvas.width, drawingCanvas.height);
            drawingContext.drawImage(imgObj, 0, 0);
            if(eggMaterial && eggMaterial.map) {
                eggMaterial.map.needsUpdate = true;
            }
        };
        imgObj.src = textureSrc;
    });
});
