<x-layouts.app title="Regisztráció">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Regisztráció</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Név</label>
                <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required autofocus>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email cím</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                @error('email')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Jelszó</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                @error('password')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Jelszó megerősítése</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Regisztráció
                </button>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-blue-500 hover:text-blue-700">Már van fiókod? Jelentkezz be!</a>
            </div>
        </form>
    </div>
</x-layouts.app>
