<!-- Ecsetméret szabályozó csúszka -->
<div class="brush-size-container flex flex-col xl:flex-row items-center gap-3 w-full">
    <div class="flex justify-between items-center gap-2">
        <label for="brushSize" class="text-sm font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap">🖌️ Méret</label>
        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md"><span id="brushSizeLabel">10</span>px</span>
    </div>

    <div class="flex flex-1 items-center gap-3 bg-gray-50 p-2 rounded-xl border border-gray-100 min-w-[120px]">
        <div class="w-2 h-2 bg-gray-400 rounded-full shrink-0"></div>
        <input type="range" id="brushSize" min="1" max="50" value="10" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
        <div class="w-4 h-4 bg-gray-400 rounded-full shrink-0"></div>
    </div>
</div>
