<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Log Aktivitas</h2>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-r-md">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-md">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-md">
                        <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-4 sm:p-6">
                        <form method="GET" action="{{ route('activity-logs.index') }}">
                            <div class="flex items-end space-x-3">
                                <div class="flex-1">
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Log</label>
                                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari pengguna, aktivitas, atau detail..." class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Cari
                                </button>
                                <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @if($logs->count() > 0)
                            <form id="bulk-delete-form" method="POST" action="{{ route('activity-logs.destroy-selected') }}">
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
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left">
                                                    <input type="checkbox" id="select-all"
                                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($logs as $log)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <input type="checkbox" name="selected_ids[]" value="{{ $log->id }}"
                                                               class="log-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        @if(in_array($log->activity, ['UPLOAD', 'EDIT', 'DOWNLOAD']) && $log->archive_id)
                                                            <a href="{{ route('archives.show', $log->archive_id) }}"
                                                               class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition">
                                                                Detail
                                                            </a>
                                                        @elseif($log->activity === 'DELETE' && ($log->archive_title || $log->archive_number))
                                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded bg-gray-100 text-gray-500">
                                                                Surat telah dihapus
                                                            </span>
                                                        @else
                                                            <span class="text-gray-300 text-xs">--</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $log->created_at->isoFormat('D MMMM Y, HH:mm') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $log->user->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if($log->user->isAdmin())
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Admin</span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Operator</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @php
                                                            $badge = match($log->activity) {
                                                                'LOGIN' => ['bg-green-100', 'text-green-800'],
                                                                'LOGOUT' => ['bg-gray-100', 'text-gray-800'],
                                                                'UPLOAD' => ['bg-blue-100', 'text-blue-800'],
                                                                'EDIT' => ['bg-yellow-100', 'text-yellow-800'],
                                                                'DELETE' => ['bg-red-100', 'text-red-800'],
                                                                'DOWNLOAD' => ['bg-purple-100', 'text-purple-800'],
                                                                default => ['bg-gray-100', 'text-gray-800'],
                                                            };
                                                        @endphp
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge[0] }} {{ $badge[1] }}">
                                                            {{ $log->activity }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-md">
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
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada log aktivitas</h3>
                                <p class="mt-1 text-sm text-gray-500">Log akan muncul saat pengguna melakukan aktivitas di sistem.</p>
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
        <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
        <p class="mt-2 text-sm text-gray-600" id="delete-single-text">
            Apakah Anda yakin ingin menghapus log aktivitas ini?
        </p>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete')"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
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
        <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
        <p class="mt-2 text-sm text-gray-600">
            Apakah Anda yakin ingin menghapus seluruh log aktivitas yang dipilih?
        </p>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete-selected')"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
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
        <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
        <p class="mt-2 text-sm text-gray-600">
            Apakah Anda yakin ingin menghapus seluruh log aktivitas?<br>
            <span class="font-semibold text-red-600">Tindakan ini tidak dapat dibatalkan.</span>
        </p>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete-all')"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                Batal
            </button>
            <form method="POST" action="{{ route('activity-logs.destroy-all') }}">
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
