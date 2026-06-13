<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Tambah Arsip</h2>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form action="{{ route('archives.store') }}" method="POST" enctype="multipart/form-data" class="max-w-lg">
                            @csrf

                            <div class="mb-4">
                                <x-input-label for="category_id" :value="__('Kategori')" />
                                <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="document_number" :value="__('Nomor Dokumen')" />
                                <x-text-input id="document_number" class="block mt-1 w-full" type="text" name="document_number" :value="old('document_number')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('document_number')" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="title" :value="__('Judul')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="document_date" :value="__('Tanggal Dokumen')" />
                                <x-text-input id="document_date" class="block mt-1 w-full" type="date" name="document_date" :value="old('document_date', now()->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('document_date')" />
                            </div>

                            <div class="mb-6">
                                <x-input-label for="description" :value="__('Deskripsi (opsional)')" />
                                <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div class="mb-6">
                                <x-input-label for="file" :value="__('File PDF')" />
                                <input id="file" name="file" type="file" accept="application/pdf" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required />
                                <x-input-error class="mt-2" :messages="$errors->get('file')" />
                            </div>

                            <div class="flex items-center space-x-3">
                                <x-primary-button>
                                    {{ __('Simpan') }}
                                </x-primary-button>
                                <a href="{{ route('archives.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
