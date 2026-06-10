<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Edit Kategori</h2>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form action="{{ route('categories.update', $category) }}" method="POST" class="max-w-lg">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Nama Kategori')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $category->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="mb-6">
                                <x-input-label for="description" :value="__('Deskripsi (opsional)')" />
                                <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $category->description) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div class="flex items-center space-x-3">
                                <x-primary-button>
                                    {{ __('Perbarui') }}
                                </x-primary-button>
                                <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
