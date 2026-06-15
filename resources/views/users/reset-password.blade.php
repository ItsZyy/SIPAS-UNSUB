<x-app-layout>
@include('layouts.sidebar')
<main class="p-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Reset Password</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Reset password untuk: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</span>
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-gray-900/30 sm:rounded-lg">
                    <div class="p-6">
                        <form action="{{ route('users.update-password', $user) }}" method="POST" class="max-w-lg">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <x-input-label for="password" :value="__('Password Baru')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
                            <div class="mb-6">
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>
                            <div class="flex items-center space-x-3">
                                <x-primary-button>
                                    {{ __('Reset Password') }}
                                </x-primary-button>
                                <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:shadow-gray-900/30 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Batal') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
