<x-app-layout>
@include('layouts.sidebar')
<main class="p-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Edit Arsip</h2>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-gray-900/30 sm:rounded-lg">
                    <div class="p-6">
                        <form action="{{ route('archives.update', $archive) }}" method="POST" enctype="multipart/form-data" class="max-w-lg">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <x-input-label for="category_id" :value="__('Kategori')" />
                                <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm dark:shadow-gray-900/30 focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $archive->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="document_number" :value="__('Nomor Dokumen')" />
                                <x-text-input id="document_number" class="block mt-1 w-full" type="text" name="document_number" :value="old('document_number', $archive->document_number)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('document_number')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="title" :value="__('Judul')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $archive->title)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="document_date" :value="__('Tanggal Dokumen')" />
                                <x-text-input id="document_date" class="block mt-1 w-full" type="date" name="document_date" :value="old('document_date', $archive->document_date?->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('document_date')" />
                            </div>
                            <div class="mb-6">
                                <x-input-label for="description" :value="__('Deskripsi (opsional)')" />
                                <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 rounded-md shadow-sm dark:shadow-gray-900/30 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $archive->description) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                            <div class="mb-6">
                                <x-input-label for="file" :value="__('File PDF')" />
                                @if($archive->file_path)
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        File saat ini: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $archive->file_name }}</span>
                                    </p>
                                @endif
                                <input id="file" name="file" type="file" accept="application/pdf" class="block mt-1 w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah file.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('file')" />
                            </div>
                            <div class="flex items-center space-x-3">
                                <x-primary-button>
                                    {{ __('Perbarui') }}
                                </x-primary-button>
                                <a href="{{ route('archives.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:shadow-gray-900/30 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
