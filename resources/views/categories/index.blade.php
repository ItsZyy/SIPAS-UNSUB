<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Kategori</h2>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Tambah Kategori
                        </a>
                    @endif
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-r-md">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @if($categories->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                            @if(auth()->user()->isAdmin())
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($categories as $category)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $category->name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                                    {{ $category->description ?? '-' }}
                                                </td>
                                                @if(auth()->user()->isAdmin())
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex items-center space-x-3">
                                                            <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $categories->links() }}
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kategori</h3>
                                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan kategori baru.</p>
                                @if(auth()->user()->isAdmin())
                                    <div class="mt-6">
                                        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            + Tambah Kategori
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
