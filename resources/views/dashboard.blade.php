<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Selamat datang, {{ auth()->user()->name }}!</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Anda login sebagai
                                <span class="font-semibold {{ auth()->user()->isAdmin() ? 'text-purple-600' : 'text-blue-600' }}">
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
