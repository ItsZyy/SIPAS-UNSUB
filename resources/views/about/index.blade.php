<x-app-layout>
@include('layouts.sidebar')
<main class="p-8">
    <div class="max-w-5xl mx-auto">

        {{-- HERO SECTION --}}
        <div class="mb-8">
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 dark:from-indigo-600 dark:to-indigo-800 rounded-2xl p-8 sm:p-10 text-white shadow-lg">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Tentang SIPAS UNSUB</h1>
                </div>
                <p class="text-white/80 leading-relaxed max-w-3xl">
                    SIPAS UNSUB (Sistem Pengarsipan Surat Universitas Subang) adalah aplikasi berbasis web yang dirancang untuk membantu proses pengelolaan dan penyimpanan arsip surat secara digital. Sistem ini memudahkan pengguna dalam mengelola dokumen, melakukan pencarian arsip, memantau aktivitas pengguna, serta menjaga keamanan dan keteraturan data arsip.
                </p>
                <p class="text-white/80 leading-relaxed max-w-3xl mt-4">
                    Dengan penerapan sistem pengarsipan digital, SIPAS UNSUB diharapkan dapat meningkatkan efisiensi administrasi, mengurangi risiko kehilangan dokumen, dan mempercepat proses pencarian serta pengelolaan arsip surat di lingkungan Universitas Subang.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            {{-- INFORMASI APLIKASI --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-gray-900/50 sm:rounded-xl">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi Aplikasi</h2>
                    </div>
                    <dl class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:w-48">Nama Aplikasi</dt>
                            <dd class="mt-1 sm:mt-0 text-sm font-semibold text-gray-900 dark:text-gray-100">SIPAS UNSUB</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:w-48">Versi</dt>
                            <dd class="mt-1 sm:mt-0"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300">1.0.0</span></dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:w-48">Jenis Sistem</dt>
                            <dd class="mt-1 sm:mt-0 text-sm text-gray-900 dark:text-gray-100">Sistem Pengarsipan Surat</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:w-48">Platform</dt>
                            <dd class="mt-1 sm:mt-0 text-sm text-gray-900 dark:text-gray-100">Web Application</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:w-48">Institusi</dt>
                            <dd class="mt-1 sm:mt-0 text-sm text-gray-900 dark:text-gray-100">Universitas Subang</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center py-3">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:w-48">Pengembang</dt>
                            <dd class="mt-1 sm:mt-0 text-sm text-gray-900 dark:text-gray-100">Ezy Muhammad Ikbal</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- TEKNOLOGI YANG DIGUNAKAN --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-gray-900/50 sm:rounded-xl">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Teknologi</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300">Laravel</span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300">PHP</span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">MySQL</span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-teal-100 dark:bg-teal-900/50 text-teal-700 dark:text-teal-300">Tailwind CSS</span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300">JavaScript</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- FITUR UTAMA --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-gray-900/50 sm:rounded-xl mb-8">
            <div class="p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Fitur Utama</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="p-1.5 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Manajemen Arsip Surat</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="p-1.5 rounded-lg bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pencarian dan Filter Arsip</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="p-1.5 rounded-lg bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Manajemen Pengguna</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="p-1.5 rounded-lg bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Log Aktivitas</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="p-1.5 rounded-lg bg-cyan-100 dark:bg-cyan-900/50 text-cyan-600 dark:text-cyan-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Log Sistem</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="p-1.5 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-300 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pengaturan Sistem</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="p-1.5 rounded-lg bg-yellow-100 dark:bg-yellow-900/50 text-yellow-600 dark:text-yellow-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Mode Terang dan Gelap</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="p-1.5 rounded-lg bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Keamanan Sesi Pengguna</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER ABOUT --}}
        <div class="text-center py-8 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">SIPAS UNSUB v1.0.0</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                &copy; 2026 SIPAS UNSUB. Dikembangkan oleh Ezy Muhammad Ikbal.
            </p>
        </div>

    </div>
</main>
</x-app-layout>
