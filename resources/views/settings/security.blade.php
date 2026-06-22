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
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Keamanan</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola password akun Anda</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-400 dark:border-green-600 rounded-r-md">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-gray-900/30">
            <div x-data="{ showForm: false }">
                <div x-show="!showForm" class="p-6 sm:p-8">
                    <div class="flex items-center gap-5 pb-6 mb-6 border-b border-gray-100 dark:border-gray-700/50">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-green-50 dark:bg-green-900/30 text-green-500 dark:text-green-400 shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">Password</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Password Anda aman dan tidak pernah dibagikan</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 py-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Password telah dibuat</span>
                        </div>
                        <div class="flex items-center gap-3 py-2">
                            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Disarankan mengganti password secara berkala</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700/50">
                        <button @click="showForm = true" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Ubah Password
                        </button>
                    </div>
                </div>

                <div x-show="showForm" x-cloak class="p-6 sm:p-8">
                    <div class="flex items-center gap-5 pb-6 mb-6 border-b border-gray-100 dark:border-gray-700/50">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-green-50 dark:bg-green-900/30 text-green-500 dark:text-green-400 shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">Ubah Password</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pastikan password baru Anda kuat dan unik</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('settings.update-password') }}" class="space-y-5">
                        @csrf
                        @method('put')

                        <div>
                            <x-input-label for="current_password" value="Password Saat Ini" />
                            <x-text-input id="current_password" name="current_password" type="password" class="mt-1.5 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" value="Password Baru" />
                            <x-text-input id="password" name="password" type="password" class="mt-1.5 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1.5 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-3 pt-4">
                            <x-primary-button>Simpan</x-primary-button>
                            <button @click="showForm = false" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</x-app-layout>
