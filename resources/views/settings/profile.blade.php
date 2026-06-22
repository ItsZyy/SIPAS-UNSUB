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
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Akun</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Informasi dan pengaturan akun Anda</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-400 dark:border-green-600 rounded-r-md">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-gray-900/30">
            <div x-data="{ editing: false }">
                <div x-show="!editing" class="p-6 sm:p-8">
                    <div class="flex items-center gap-5 pb-6 mb-6 border-b border-gray-100 dark:border-gray-700/50">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 dark:text-indigo-400 shrink-0">
                            <span class="text-lg font-semibold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Nama</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100 text-right">{{ $user->name }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Email</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100 text-right">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Role</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100 capitalize text-right">{{ $user->role }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Bergabung</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100 text-right">{{ $user->created_at->isoFormat('D MMMM Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700/50">
                        <button @click="editing = true" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Informasi
                        </button>
                    </div>
                </div>

                <div x-show="editing" x-cloak class="p-6 sm:p-8">
                    <div class="flex items-center gap-5 pb-6 mb-6 border-b border-gray-100 dark:border-gray-700/50">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 dark:text-indigo-400 shrink-0">
                            <span class="text-lg font-semibold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">Edit Informasi Akun</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui nama dan email Anda</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('settings.update-profile') }}" class="space-y-5">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="name" value="Nama" />
                            <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="flex items-center gap-3 pt-4">
                            <x-primary-button>Simpan</x-primary-button>
                            <button @click="editing = false" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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
