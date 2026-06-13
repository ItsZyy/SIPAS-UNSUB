<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Dashboard</h2>

                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Selamat datang, {{ auth()->user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Anda login sebagai
                        <span class="font-semibold {{ auth()->user()->isAdmin() ? 'text-purple-600' : 'text-blue-600' }}">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-500">Total Arsip</p>
                                    <div class="flex items-center gap-2">
                                        <p class="stat-value text-2xl font-semibold text-gray-900" data-target="{{ $totalArchives }}">0</p>
                                        @include('components.growth-indicator', ['growth' => $card1Growth])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-500">Total Kategori</p>
                                    <div class="flex items-center gap-2">
                                        <p class="stat-value text-2xl font-semibold text-gray-900" data-target="{{ $totalCategories }}">0</p>
                                        @include('components.growth-indicator', ['growth' => $card2Growth])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-500">Arsip Bulan Ini</p>
                                    <div class="flex items-center gap-2">
                                        <p class="stat-value text-2xl font-semibold text-gray-900" data-target="{{ $archivesThisMonth }}">0</p>
                                        @include('components.growth-indicator', ['growth' => $card3Growth])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-500">Arsip Tahun Ini</p>
                                    <div class="flex items-center gap-2">
                                        <p class="stat-value text-2xl font-semibold text-gray-900" data-target="{{ $archivesThisYear }}">0</p>
                                        @include('components.growth-indicator', ['growth' => $card4Growth])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aktivitas Surat 7 Hari Terakhir</h3>
                        <div id="weeklyChart"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Arsip Terbaru</h3>
                            @if($recentArchives->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Dokumen</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($recentArchives as $archive)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $archive->document_number }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-900 max-w-xs truncate">
                                                        <a href="{{ route('archives.show', $archive) }}" class="text-indigo-600 hover:text-indigo-900">
                                                            {{ $archive->title }}
                                                        </a>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                            {{ $archive->category->name }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $archive->document_date->isoFormat('D MMMM Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Belum ada arsip.</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Arsip per Kategori</h3>
                            @if($archivesPerCategory->count() > 0)
                                <ul class="divide-y divide-gray-200">
                                    @foreach($archivesPerCategory as $category)
                                        <li class="py-3 flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-900">{{ $category->name }}</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $category->archives_count }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500">Belum ada kategori.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <style>
        .stat-card {
            opacity: 0;
            animation: statFadeIn 0.6s ease-out forwards;
        }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.15s; }
        .stat-card:nth-child(3) { animation-delay: 0.25s; }
        .stat-card:nth-child(4) { animation-delay: 0.35s; }

        @keyframes statFadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function animateStatValue(el, duration) {
                var target = parseInt(el.getAttribute('data-target'), 10);
                if (isNaN(target)) return;
                var startTime = performance.now();

                function formatNumber(num) {
                    return num.toLocaleString('en-US');
                }

                function step(currentTime) {
                    var elapsed = currentTime - startTime;
                    var progress = Math.min(elapsed / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    var current = Math.round(eased * target);
                    el.textContent = formatNumber(current);

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                }

                requestAnimationFrame(step);
            }

            var statValues = document.querySelectorAll('.stat-value');
            statValues.forEach(function(el) {
                animateStatValue(el, 1000);
            });

            var options = {
                chart: {
                    type: 'area',
                    height: 300,
                    fontFamily: 'Figtree, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                series: [{
                    name: 'Jumlah Surat',
                    data: @json($weeklyData)
                }],
                xaxis: {
                    categories: @json($weeklyLabels),
                    labels: {
                        style: { colors: '#6b7280', fontSize: '12px' }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#6b7280', fontSize: '12px' }
                    },
                    min: 0,
                    forceNiceScale: true
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: false } }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.1,
                        stops: [0, 100]
                    }
                },
                colors: ['#6366f1'],
                markers: {
                    size: 4,
                    colors: ['#fff'],
                    strokeColors: ['#6366f1'],
                    strokeWidth: 2,
                    hover: { size: 6 }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + ' surat';
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector('#weeklyChart'), options);
            chart.render();
        });
    </script>
    @endpush
</x-app-layout>
