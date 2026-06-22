<x-app-layout>
@include('layouts.sidebar')
<main class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('settings.index') }}" class="inline-flex items-center text-sm text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Tema</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pilih tampilan aplikasi yang Anda sukai</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-400 dark:border-green-600 rounded-r-md">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <form method="post" action="{{ route('settings.update-theme') }}">
                @csrf
                @method('put')
                <input type="hidden" name="theme" value="system">
                <button type="submit" class="w-full text-left">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-gray-900/30 overflow-hidden {{ $user->theme === 'system' ? 'ring-2 ring-indigo-500 dark:ring-indigo-400' : 'ring-1 ring-gray-200 dark:ring-gray-700' }} hover:shadow-md transition">
                        <div class="h-28 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-700 flex items-center justify-center border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Default</h3>
                                @if($user->theme === 'system')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">Aktif</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mengikuti pengaturan sistem</p>
                        </div>
                    </div>
                </button>
            </form>

            <form method="post" action="{{ route('settings.update-theme') }}">
                @csrf
                @method('put')
                <input type="hidden" name="theme" value="light">
                <button type="submit" class="w-full text-left">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-gray-900/30 overflow-hidden {{ $user->theme === 'light' ? 'ring-2 ring-indigo-500 dark:ring-indigo-400' : 'ring-1 ring-gray-200 dark:ring-gray-700' }} hover:shadow-md transition">
                        <div class="h-28 bg-yellow-50 dark:bg-yellow-900/20 flex items-center justify-center border-b border-gray-100 dark:border-gray-700">
                            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Terang</h3>
                                @if($user->theme === 'light')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">Aktif</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tampilan cerah setiap saat</p>
                        </div>
                    </div>
                </button>
            </form>

            <form method="post" action="{{ route('settings.update-theme') }}">
                @csrf
                @method('put')
                <input type="hidden" name="theme" value="dark">
                <button type="submit" class="w-full text-left">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-gray-900/30 overflow-hidden {{ $user->theme === 'dark' ? 'ring-2 ring-indigo-500 dark:ring-indigo-400' : 'ring-1 ring-gray-200 dark:ring-gray-700' }} hover:shadow-md transition">
                        <div class="h-28 bg-indigo-950 flex items-center justify-center border-b border-gray-700">
                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Gelap</h3>
                                @if($user->theme === 'dark')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">Aktif</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tampilan gelap setiap saat</p>
                        </div>
                    </div>
                </button>
            </form>
        </div>
    </div>
</main>
</x-app-layout>
