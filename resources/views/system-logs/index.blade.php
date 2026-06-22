<x-app-layout>
@include('layouts.sidebar')
<main class="p-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Log Sistem</h2>
                </div>
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-400 dark:border-green-600 rounded-r-md">
                        <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-400 dark:border-red-600 rounded-r-md">
                        <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-400 dark:border-red-600 rounded-r-md">
                        <p class="text-sm text-red-700 dark:text-red-300">{{ $errors->first() }}</p>
                    </div>
                @endif
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-gray-900/30 sm:rounded-lg mb-6">
                    <div class="p-4 sm:p-6">
                        <form method="GET" action="{{ route('system-logs.index') }}">
                            <div class="flex items-end space-x-3">
                                <div class="flex-1">
                                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari Log</label>
                                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari pengguna, aktivitas, atau detail..." class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 rounded-md shadow-sm dark:shadow-gray-900/30 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Cari
                                </button>
                                <a href="{{ route('system-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:shadow-gray-900/30 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-gray-900/30 sm:rounded-lg">
                    <div class="p-6">
                        @if($logs->count() > 0)
                            <form id="bulk-delete-form" method="POST" action="{{ route('system-logs.destroy-selected') }}">
                                @csrf
                                @method('DELETE')
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <button type="button" id="delete-selected-btn" disabled
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150"
                                                onclick="showDeleteSelectedModal()">
                                            Hapus Terpilih
                                        </button>
                                        <button type="button"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition ease-in-out duration-150"
                                                onclick="showDeleteAllModal()">
                                            Hapus Semua
                                        </button>
                                    </div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                                            <tr>
                                                <th class="px-6 py-3 text-left">
                                                    <input type="checkbox" id="select-all"
                                                           class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 dark:text-indigo-400 shadow-sm dark:shadow-gray-900/30 focus:ring-indigo-500">
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Waktu</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pengguna</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aktivitas</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($logs as $log)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <input type="checkbox" name="selected_ids[]" value="{{ $log->id }}"
                                                               class="log-checkbox rounded border-gray-300 dark:border-gray-600 text-indigo-600 dark:text-indigo-400 shadow-sm dark:shadow-gray-900/30 focus:ring-indigo-500">
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        @if(in_array($log->activity, ['UPLOAD', 'EDIT', 'DOWNLOAD']) && $log->archive_id)
                                                            <a href="{{ route('archives.show', $log->archive_id) }}"
                                                               class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-100 dark:hover:bg-gray-700 transition">
                                                                Detail
                                                            </a>
                                                        @elseif($log->activity === 'DELETE' && ($log->archive_title || $log->archive_number))
                                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                                                Surat telah dihapus
                                                            </span>
                                                        @else
                                                            <span class="text-gray-300 text-xs">--</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $log->created_at->isoFormat('D MMMM Y, HH:mm') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $log->user->name ?? 'Sistem' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if($log->user)
                                                            @if($log->user->isAdmin())
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300">Admin</span>
                                                            @else
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800">Operator</span>
                                                            @endif
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-500">Sistem</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @php
                                                            $badge = match($log->activity) {
                                                                'UPLOAD' => ['bg-blue-100 dark:bg-blue-900/50', 'text-blue-800 dark:text-blue-300'],
                                                                'EDIT' => ['bg-yellow-100 dark:bg-yellow-900/50', 'text-yellow-800 dark:text-yellow-300'],
                                                                'DELETE' => ['bg-red-100 dark:bg-red-900/50', 'text-red-800 dark:text-red-300'],
                                                                'SETTINGS' => ['bg-cyan-100 dark:bg-cyan-900/50', 'text-cyan-800 dark:text-cyan-300'],
                                                                'CREATE_USER' => ['bg-green-100 dark:bg-green-900/50', 'text-green-800 dark:text-green-300'],
                                                                'UPDATE_USER' => ['bg-yellow-100 dark:bg-yellow-900/50', 'text-yellow-800 dark:text-yellow-300'],
                                                                'DELETE_USER' => ['bg-red-100 dark:bg-red-900/50', 'text-red-800 dark:text-red-300'],
                                                                'RESET_PASSWORD' => ['bg-orange-100 dark:bg-orange-900/50', 'text-orange-800 dark:text-orange-300'],
                                                                'CREATE_CATEGORY' => ['bg-green-100 dark:bg-green-900/50', 'text-green-800 dark:text-green-300'],
                                                                'UPDATE_CATEGORY' => ['bg-yellow-100 dark:bg-yellow-900/50', 'text-yellow-800 dark:text-yellow-300'],
                                                                'DELETE_CATEGORY' => ['bg-red-100 dark:bg-red-900/50', 'text-red-800 dark:text-red-300'],
                                                                'PRUNE_LOGS' => ['bg-gray-100 dark:bg-gray-700', 'text-gray-800'],
                                                                default => ['bg-gray-100 dark:bg-gray-700', 'text-gray-800'],
                                                            };
                                                        @endphp
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge[0] }} {{ $badge[1] }}">
                                                            {{ $log->activity }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 max-w-md">
                                                        {{ $log->description }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $logs->links() }}
                                </div>
                            </form>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada log sistem</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Log akan muncul saat terjadi perubahan data atau konfigurasi sistem.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
{{-- Modal Hapus Satu --}}
<x-modal name="confirm-delete" :show="false" maxWidth="md">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Konfirmasi Hapus</h3>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400" id="delete-single-text">
            Apakah Anda yakin ingin menghapus log sistem ini?
        </p>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:shadow-gray-900/30 hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
                Batal
            </button>
            <form id="delete-single-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition ease-in-out duration-150">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</x-modal>
{{-- Modal Hapus Terpilih --}}
<x-modal name="confirm-delete-selected" :show="false" maxWidth="md">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Konfirmasi Hapus</h3>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Apakah Anda yakin ingin menghapus seluruh log sistem yang dipilih?
        </p>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete-selected')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:shadow-gray-900/30 hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
                Batal
            </button>
            <button type="submit" form="bulk-delete-form"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition ease-in-out duration-150">
                Hapus
            </button>
        </div>
    </div>
</x-modal>
{{-- Modal Hapus Semua --}}
<x-modal name="confirm-delete-all" :show="false" maxWidth="md">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Konfirmasi Hapus</h3>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Apakah Anda yakin ingin menghapus seluruh log sistem?<br>
            <span class="font-semibold text-red-600 dark:text-red-400">Tindakan ini tidak dapat dibatalkan.</span>
        </p>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete-all')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:shadow-gray-900/30 hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
                Batal
            </button>
            <form method="POST" action="{{ route('system-logs.destroy-all') }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition ease-in-out duration-150">
                    Hapus Semua
                </button>
            </form>
        </div>
    </div>
</x-modal>
<script>
// Select All checkbox
document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.log-checkbox').forEach(cb => cb.checked = this.checked);
    updateDeleteSelectedButton();
});
// Individual checkboxes
document.querySelectorAll('.log-checkbox').forEach(cb => {
    cb.addEventListener('change', updateDeleteSelectedButton);
});
function updateDeleteSelectedButton() {
    const checked = document.querySelectorAll('.log-checkbox:checked');
    const btn = document.getElementById('delete-selected-btn');
    if (checked.length > 0) {
        btn.disabled = false;
        btn.textContent = 'Hapus Terpilih (' + checked.length + ')';
    } else {
        btn.disabled = true;
        btn.textContent = 'Hapus Terpilih';
    }
}
// Single delete
function confirmDelete(url) {
    document.getElementById('delete-single-form').action = url;
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-delete' }));
}
// Bulk delete
function showDeleteSelectedModal() {
    const checked = document.querySelectorAll('.log-checkbox:checked');
    if (checked.length === 0) return;
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-delete-selected' }));
}
// Delete all
function showDeleteAllModal() {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-delete-all' }));
}
</script>
