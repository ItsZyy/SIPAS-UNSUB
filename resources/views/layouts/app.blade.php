<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPAS UNSUB') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-title.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-title.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
        @auth
            <script>
                (function() {
                    var theme = '{{ Auth::user()->theme }}';
                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('darkMode', 'true');
                    } else if (theme === 'system') {
                        var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        if (prefersDark) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                        localStorage.setItem('darkMode', prefersDark ? 'true' : 'false');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('darkMode', 'false');
                    }
                })();
            </script>
            <meta name="session-timeout" content="{{ App\Models\SystemSetting::getValue('session_timeout', '30') }}">
            <meta name="session-key" content="{{ session()->getId() }}">
        @endauth
        <script>
            function toggleDarkMode() {
                var html = document.documentElement;
                var isDark = html.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
                updateIcons();
                fetch('{{ route("settings.toggle-theme") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ theme: isDark ? 'dark' : 'light' })
                });
            }

            function updateIcons() {
                var isDark = document.documentElement.classList.contains('dark');
                document.querySelectorAll('[id^="sun-icon"]').forEach(function(el) { el.classList.toggle('hidden', !isDark); });
                document.querySelectorAll('[id^="moon-icon"]').forEach(function(el) { el.classList.toggle('hidden', isDark); });
            }

            document.addEventListener('DOMContentLoaded', updateIcons);
        </script>
    </head>
    <body class="font-sans antialiased">
        <!-- Top Bar -->
        <header class="fixed top-0 left-0 right-0 h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6 z-40">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo/logounsub.png') }}" alt="" class="h-12 w-auto">
                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Arsip Universitas Subang</span>
            </a>

            <div class="flex items-center gap-3">
                <button id="dark-toggle-top" class="p-2 rounded-lg text-gray-400 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" onclick="toggleDarkMode()" aria-label="Toggle dark mode">
                    <svg id="sun-icon-top" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg id="moon-icon-top" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg dark:shadow-gray-900/50 ring-1 ring-black ring-opacity-5 overflow-hidden z-50" @click="open = false">
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Pengaturan
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 ml-64 pt-16">
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @auth
        <!-- Session Timeout Warning Modal -->
        <div id="session-timeout-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900/30 mb-4">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Sesi Akan Berakhir</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Sesi Anda akan berakhir dalam <span id="timeout-countdown" class="font-semibold text-yellow-600 dark:text-yellow-400">30</span> detik.
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mb-4">Aktifkan kembali sesi Anda atau Anda akan logout secara otomatis.</p>
                    <div class="flex gap-3 justify-center">
                        <button onclick="window.logoutNow()" class="px-4 py-2 text-sm font-medium text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-900/30 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition">
                            Logout Sekarang
                        </button>
                        <button onclick="window.keepAlive()" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                            Tetap Masuk
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        (function() {
            console.log('[Timeout] Script loaded');

            var meta, SESSION_TIMEOUT, WARNING_BEFORE, CHECK_INTERVAL, STORAGE_KEY;
            var modal, countdownEl, warningShown, warningInterval;

            try {
                meta = document.querySelector('meta[name="session-timeout"]');
                console.log('[Timeout] Meta tag:', meta ? meta.outerHTML : 'NOT FOUND');
                if (!meta) { console.warn('[Timeout] Meta tag not found, bailing out'); return; }

                var metaValue = meta.getAttribute('content');
                console.log('[Timeout] Meta value (minutes):', metaValue);

                SESSION_TIMEOUT = parseInt(metaValue, 10) * 60;
                console.log('[Timeout] SESSION_TIMEOUT (seconds):', SESSION_TIMEOUT);

                if (!SESSION_TIMEOUT || SESSION_TIMEOUT <= 0) { console.warn('[Timeout] Invalid timeout value, bailing out'); return; }

                WARNING_BEFORE = 30;
                CHECK_INTERVAL = 1;

                var sessionKeyMeta = document.querySelector('meta[name="session-key"]');
                var sessionKey = sessionKeyMeta ? sessionKeyMeta.getAttribute('content') : '';
                STORAGE_KEY = 'sipas_last_activity_' + sessionKey;
                console.log('[Timeout] STORAGE_KEY:', STORAGE_KEY);

                modal = document.getElementById('session-timeout-modal');
                console.log('[Timeout] Modal element:', modal ? 'FOUND' : 'NOT FOUND');

                countdownEl = document.getElementById('timeout-countdown');
                warningShown = false;
                warningInterval = null;
            } catch (e) {
                console.error('[Timeout] Initialization error:', e);
                return;
            }

            /* ---- localStorage helpers ---- */
            function getLastActivity() {
                try {
                    var stored = localStorage.getItem(STORAGE_KEY);
                    if (stored) {
                        var parsed = parseInt(stored, 10);
                        if (!isNaN(parsed)) return parsed;
                    }
                } catch (e) {
                    console.warn('[Timeout] localStorage getItem error:', e);
                }
                return Date.now();
            }

            function setLastActivity() {
                try {
                    var now = Date.now();
                    localStorage.setItem(STORAGE_KEY, now);
                    return now;
                } catch (e) {
                    console.warn('[Timeout] localStorage setItem error:', e);
                    return Date.now();
                }
            }

            /* ---- Expose functions FIRST so they are available everywhere ---- */
            window.keepAlive = function() {
                console.log('[Timeout] keepAlive called');
                fetch('{{ route("settings.keep-alive") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                }).then(function(resp) {
                    console.log('[Timeout] keepAlive response:', resp.status);
                    if (resp.ok) {
                        setLastActivity();
                        hideWarning();
                    }
                }).catch(function(err) {
                    console.error('[Timeout] keepAlive fetch error:', err);
                });
            };

            window.logoutNow = function() {
                console.log('[Timeout] logoutNow called');
                fetch('{{ route("auto-logout") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                }).then(function(resp) {
                    return resp.json();
                }).then(function(data) {
                    console.log('[Timeout] logoutNow response:', data);
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }).catch(function(err) {
                    console.error('[Timeout] logoutNow fetch error:', err);
                    window.location.href = '{{ url("/login") }}';
                });
            };

            /* ---- Init: check stored activity and reset ---- */
            try {
                var lastActivity = getLastActivity();
                var now = Date.now();
                var idleSec = (now - lastActivity) / 1000;
                console.log('[Timeout] Init — idle seconds:', idleSec.toFixed(1), '| timeout:', SESSION_TIMEOUT);

                if (idleSec >= SESSION_TIMEOUT) {
                    console.log('[Timeout] Session expired on load, calling logoutNow');
                    window.logoutNow();
                    return;
                }

                setLastActivity();
                console.log('[Timeout] Timer initialized');
            } catch (e) {
                console.error('[Timeout] Init check error:', e);
                setLastActivity();
            }

            /* ---- Event listeners ---- */
            function updateLastActivity() {
                if (warningShown) return;
                setLastActivity();
            }

            var events = ['mousemove', 'mousedown', 'click', 'scroll', 'keydown', 'touchstart'];
            events.forEach(function(evt) {
                document.addEventListener(evt, updateLastActivity, { passive: true });
                console.log('[Timeout] Listener attached:', evt);
            });

            document.addEventListener('submit', updateLastActivity);

            window.addEventListener('storage', function(e) {
                if (e.key === STORAGE_KEY) {
                    console.log('[Timeout] Storage event from another tab');
                }
            });

            /* ---- Warning / Countdown ---- */
            function showWarning() {
                if (warningShown) return;
                warningShown = true;
                var countdownValue = WARNING_BEFORE;
                countdownEl.textContent = countdownValue;
                modal.classList.remove('hidden');
                console.log('[Timeout] Warning modal shown, countdown:', countdownValue);

                if (warningInterval) clearInterval(warningInterval);
                warningInterval = setInterval(function() {
                    countdownValue--;
                    countdownEl.textContent = countdownValue;
                    console.log('[Timeout] Countdown:', countdownValue);
                    if (countdownValue <= 0) {
                        clearInterval(warningInterval);
                        console.log('[Timeout] Countdown expired, logging out');
                        window.logoutNow();
                    }
                }, 1000);
            }

            function hideWarning() {
                warningShown = false;
                if (warningInterval) {
                    clearInterval(warningInterval);
                    warningInterval = null;
                }
                modal.classList.add('hidden');
                console.log('[Timeout] Warning modal hidden');
            }

            /* ---- Main check interval ---- */
            setInterval(function() {
                try {
                    var idle = (Date.now() - getLastActivity()) / 1000;
                    var remaining = SESSION_TIMEOUT - idle;
                    console.log('[Timeout] Check — idle:', idle.toFixed(1), '| remaining:', remaining.toFixed(1), '| warningShown:', warningShown);

                    if (remaining <= 0) {
                        console.log('[Timeout] Session expired, logging out');
                        window.logoutNow();
                    } else if (remaining <= WARNING_BEFORE && !warningShown) {
                        console.log('[Timeout] Triggering warning');
                        showWarning();
                    } else if (remaining > WARNING_BEFORE && warningShown) {
                        console.log('[Timeout] Hiding warning (user active)');
                        hideWarning();
                    }
                } catch (e) {
                    console.error('[Timeout] Check interval error:', e);
                }
            }, CHECK_INTERVAL * 1000);

            console.log('[Timeout] Script fully initialized');
        })();
        </script>
        @endauth

        @stack('scripts')
    </body>
</html>
