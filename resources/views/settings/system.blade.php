<x-app-layout>
@include('layouts.sidebar')
<main class="p-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Konfigurasi Sistem</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Atur batas dan kebijakan sistem aplikasi</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-sm text-green-700 dark:text-green-300 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('settings.update-system') }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Session Timeout --}}
            @php
                $timeout = old('session_timeout', $sessionTimeout);
                $timeoutCustom = old('session_timeout_custom', '');
                $timeoutPresets = ['15', '30', '60'];
                $timeoutIsCustom = !in_array($timeout, $timeoutPresets);
                $timeoutDisplay = $timeoutIsCustom ? ($timeout ?: $timeoutCustom) : '';
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-5">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Session Timeout</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Atur berapa lama pengguna dapat tidak aktif sebelum logout otomatis</p>
                        </div>
                    </div>

                    <div class="ml-14 space-y-2">
                        @foreach(['15' => '15 menit', '30' => '30 menit', '60' => '1 jam'] as $val => $label)
                            <label class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer has-[:checked]:border-red-500 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20 transition hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <input type="radio" name="session_timeout" value="{{ $val }}" class="w-4 h-4 text-red-500 focus:ring-red-500" {{ $timeout == $val ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </label>
                        @endforeach

                        <div class="rounded-lg border border-gray-200 dark:border-gray-600 has-[:checked]:border-red-500 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20 transition">
                            <label class="flex items-center gap-3 px-4 py-3 cursor-pointer">
                                <input type="radio" name="session_timeout" value="" id="kustom_session_timeout" class="w-4 h-4 text-red-500 focus:ring-red-500" {{ $timeoutIsCustom ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Kustom</span>
                            </label>
                            <div class="px-4 pb-4">
                                <div class="flex items-center gap-2 ml-7">
                                    <input type="number" name="session_timeout_custom" id="custom_session_timeout" min="1" max="480"
                                        class="w-24 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500 transition"
                                        placeholder="0" value="{{ $timeoutDisplay }}">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">menit</span>
                                </div>
                                @error('sessionTimeout')
                                    <p class="mt-2 text-sm text-red-600 ml-7">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ukuran Maksimum Upload PDF --}}
            @php
                $fileSize = old('max_file_size', $maxFileSize);
                $fileSizeCustom = old('max_file_size_custom', '');
                $fileSizePresets = ['5', '10', '25', '50', '100'];
                $fileSizeIsCustom = !in_array($fileSize, $fileSizePresets);
                $fileSizeDisplay = $fileSizeIsCustom ? ($fileSize ?: $fileSizeCustom) : '';

                $phpUploadRaw = trim(ini_get('upload_max_filesize'));
                $phpUploadUnit = strtoupper(substr($phpUploadRaw, -1));
                $phpUploadNum = (int) $phpUploadRaw;
                $phpUploadMB = match($phpUploadUnit) {
                    'G' => $phpUploadNum * 1024,
                    'M' => $phpUploadNum,
                    'K' => (int) round($phpUploadNum / 1024),
                    default => (int) round($phpUploadNum / 1024 / 1024),
                };
                $appMB = (int) $fileSize;
                $hasServerConflict = $appMB > $phpUploadMB;
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-5">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-500 dark:text-blue-400 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Ukuran Maksimum Upload PDF</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Atur ukuran maksimal file PDF yang dapat diunggah pengguna</p>
                        </div>
                    </div>

                    @if($hasServerConflict)
                        <div class="ml-14 mb-4 p-3 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 text-xs text-yellow-700 dark:text-yellow-300 flex items-start gap-2">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <div>
                                <p class="font-medium">Konflik batas server</p>
                                <p class="mt-1">Setting aplikasi (<strong>{{ $appMB }} MB</strong>) melebihi batas server PHP (<strong>{{ $phpUploadRaw }}</strong>). Upload file akan tetap gagal sampai nilai <code class="text-yellow-800 dark:text-yellow-200 bg-yellow-100 dark:bg-yellow-900/40 px-1 rounded">upload_max_filesize</code> di php.ini dinaikkan.</p>
                            </div>
                        </div>
                    @endif

                    <div class="ml-14 space-y-2">
                        @foreach(['5' => '5 MB', '10' => '10 MB', '25' => '25 MB', '50' => '50 MB', '100' => '100 MB'] as $val => $label)
                            <label class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20 transition hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <input type="radio" name="max_file_size" value="{{ $val }}" class="w-4 h-4 text-blue-500 focus:ring-blue-500" {{ $fileSize == $val ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </label>
                        @endforeach

                        <div class="rounded-lg border border-gray-200 dark:border-gray-600 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20 transition">
                            <label class="flex items-center gap-3 px-4 py-3 cursor-pointer">
                                <input type="radio" name="max_file_size" value="" id="kustom_max_file_size" class="w-4 h-4 text-blue-500 focus:ring-blue-500" {{ $fileSizeIsCustom ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Kustom</span>
                            </label>
                            <div class="px-4 pb-4">
                                <div class="flex items-center gap-2 ml-7">
                                    <input type="number" name="max_file_size_custom" id="custom_max_file_size" min="1" max="500"
                                        class="w-24 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                                        placeholder="0" value="{{ $fileSizeDisplay }}">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">MB</span>
                                </div>
                                @error('maxFileSize')
                                    <p class="mt-2 text-sm text-red-600 ml-7">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Retensi Log Aktivitas --}}
            @php
                $retention = old('log_retention_days', $logRetentionDays);
                $retentionCustom = old('log_retention_days_custom', '');
                $retentionPresets = ['7', '14', '30', '90', '365'];
                $retentionIsCustom = !in_array($retention, $retentionPresets);
                $retentionDisplay = $retentionIsCustom ? ($retention ?: $retentionCustom) : '';
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-5">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-50 dark:bg-yellow-900/30 text-yellow-500 dark:text-yellow-400 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Retensi Log Aktivitas</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Atur berapa lama log aktivitas disimpan sebelum dihapus otomatis</p>
                        </div>
                    </div>

                    <div class="ml-14 space-y-2">
                        @foreach(['7' => '7 hari', '14' => '14 hari', '30' => '30 hari', '90' => '90 hari', '365' => '1 tahun'] as $val => $label)
                            <label class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50 dark:has-[:checked]:bg-yellow-900/20 transition hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <input type="radio" name="log_retention_days" value="{{ $val }}" class="w-4 h-4 text-yellow-500 focus:ring-yellow-500" {{ $retention == $val ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </label>
                        @endforeach

                        <div class="rounded-lg border border-gray-200 dark:border-gray-600 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50 dark:has-[:checked]:bg-yellow-900/20 transition">
                            <label class="flex items-center gap-3 px-4 py-3 cursor-pointer">
                                <input type="radio" name="log_retention_days" value="" id="kustom_log_retention_days" class="w-4 h-4 text-yellow-500 focus:ring-yellow-500" {{ $retentionIsCustom ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Kustom</span>
                            </label>
                            <div class="px-4 pb-4">
                                <div class="flex items-center gap-2 ml-7">
                                    <input type="number" name="log_retention_days_custom" id="custom_log_retention_days" min="1" max="3650"
                                        class="w-24 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 text-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 transition"
                                        placeholder="0" value="{{ $retentionDisplay }}">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">hari</span>
                                </div>
                                @error('logRetentionDays')
                                    <p class="mt-2 text-sm text-red-600 ml-7">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('settings.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pairs = [
            { kustom: 'kustom_session_timeout', custom: 'custom_session_timeout' },
            { kustom: 'kustom_max_file_size', custom: 'custom_max_file_size' },
            { kustom: 'kustom_log_retention_days', custom: 'custom_log_retention_days' },
        ];

        pairs.forEach(function(pair) {
            const kustomRadio = document.getElementById(pair.kustom);
            const customInput = document.getElementById(pair.custom);

            if (!kustomRadio || !customInput) return;

            customInput.addEventListener('input', function() {
                kustomRadio.checked = true;
            });

            kustomRadio.addEventListener('change', function() {
                if (this.checked) {
                    customInput.focus();
                }
            });
        });
    });
</script>
</x-app-layout>
