<!-- Színválasztó komponens -->
<div class="color-picker-container flex flex-col xl:flex-row items-center gap-3">
    <label for="colorPicker" class="text-sm font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap">💧 Szín</label>
    <div class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-xl border border-gray-100">
        <label title="Különleges szín választása" class="cursor-pointer relative overflow-hidden rounded-full w-10 h-10 border-2 border-white shadow-sm ring-2 ring-gray-200 hover:ring-blue-400 transition" style="background: conic-gradient(red, yellow, lime, aqua, blue, magenta, red);">
            <input type="color" id="colorPicker" name="colorPicker" value="#1d4ed8" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
        </label>
        <div class="h-6 w-px bg-gray-300 mx-2"></div>
        <div class="flex gap-2 flex-wrap">
            <button class="color-btn w-8 h-8 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-200 hover:ring-blue-500 hover:scale-110 transition shrink-0" style="background-color: #ef4444;" data-color="#ef4444" title="Piros"></button>
            <button class="color-btn w-8 h-8 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-200 hover:ring-blue-500 hover:scale-110 transition shrink-0" style="background-color: #22c55e;" data-color="#22c55e" title="Zöld"></button>
            <button class="color-btn w-8 h-8 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-200 hover:ring-blue-500 hover:scale-110 transition shrink-0" style="background-color: #3b82f6;" data-color="#3b82f6" title="Kék"></button>
            <button class="color-btn w-8 h-8 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-200 hover:ring-blue-500 hover:scale-110 transition shrink-0" style="background-color: #eab308;" data-color="#eab308" title="Sárga"></button>
        </div>
    </div>
</div>
