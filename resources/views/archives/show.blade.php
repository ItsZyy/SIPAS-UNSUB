<x-app-layout>
@include('layouts.sidebar')
<main class="p-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Detail Arsip</h2>
                    <div class="flex items-center space-x-3">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('archives.edit', $archive) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit Arsip
                            </a>
                        @endif
                        <a href="{{ route('archives.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:shadow-gray-900/30 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-gray-900/30 sm:rounded-lg">
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Dokumen</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $archive->document_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-300">
                                        {{ $archive->category->name }}
                                    </span>
                                </dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Judul</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $archive->title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Dokumen</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $archive->document_date->isoFormat('D MMMM Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Diupload Oleh</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $archive->uploader->name }}</dd>
                            </div>
                            @if($archive->description)
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $archive->description }}</dd>
                                </div>
                            @endif
                            @if($archive->file_path)
                                @php
                                    $fileExists = Storage::disk('public')->exists($archive->file_path);
                                    $fileUrl = url('storage/' . $archive->file_path);
                                @endphp
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">File</dt>
                                    <dd class="mt-2">
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                                                {{ $archive->file_name }}
                                            </span>
                                            @if($fileExists)
                                                <a href="{{ $fileUrl }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Preview PDF
                                                </a>
                                                <a href="{{ route('archives.download', $archive) }}" class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:shadow-gray-900/30 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Download PDF
                                                </a>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                                    File tidak ditemukan
                                                </span>
                                            @endif
                                        </div>
                                    </dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat Pada</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $archive->created_at->isoFormat('D MMMM Y, HH:mm') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Diperbarui Pada</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $archive->updated_at->isoFormat('D MMMM Y, HH:mm') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
