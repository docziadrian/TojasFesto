<x-layouts.app title="Húsvéti Tojásfestő">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-blue-600 mb-2 font-serif tracking-wide">🐰 Húsvéti Tojásfestő 🎨</h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">Válaszd ki a kedvenc színedet és ecsetméretedet, majd fesd ki a virtuális tojásodat! Amikor készen vagy, mentsd le a mesterművet!</p>
    </div>

    <!-- Toolbar: Színek, méret, és műveletek -->
    <div class="flex justify-center mb-8">
        <x-toolbar />
    </div>

    <!-- Rajzfelület / Tojás -->
    <x-egg-canvas />

    <footer class="text-center text-gray-400 mt-16 text-sm">
        Készült Laravel és HTML5 Canvas technológiákkal a Tiszta Kód (Clean Code) elveit követve.
    </footer>
</x-layouts.app>
