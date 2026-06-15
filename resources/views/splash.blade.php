<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'SIPAS UNSUB') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" href="{{ asset('logo-title.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

            body {
                font-family: 'Figtree', sans-serif;
                overflow: hidden;
                width: 100vw;
                height: 100vh;
                background: #f8fafc;
            }

            .phase {
                position: fixed;
                inset: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: opacity 0.6s ease;
            }

            .phase.hidden {
                opacity: 0;
                pointer-events: none;
            }

            #phase-splash {
                background: #f8fafc;
                z-index: 30;
            }

            #phase-logo {
                background: #f8fafc;
                z-index: 20;
            }

            #logo-img {
                width: 220px;
                height: auto;
                transform: scale(0);
                transition: transform 1s cubic-bezier(0.34, 1.56, 0.64, 1);
                will-change: transform;
                user-select: none;
                -webkit-user-drag: none;
                flex-shrink: 0;
            }

            #logo-img.show {
                transform: scale(1);
            }

            #click-hint {
                margin-top: 28px;
                font-size: 1rem;
                color: #64748b;
                font-weight: 500;
                opacity: 0;
                transform: translateY(12px);
                transition: opacity 0.6s ease 0.4s, transform 0.6s ease 0.4s;
            }

            #click-hint.show {
                opacity: 1;
                transform: translateY(0);
            }

            #brand-group {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 40px;
            }

            #brand-text-wrap {
                width: 0;
                overflow: hidden;
                white-space: nowrap;
                min-width: 0;
                transition: width 0.65s cubic-bezier(0.22, 1, 0.36, 1);
            }

            #brand-text-wrap.reveal {
                width: var(--brand-width);
            }

            #brand-title {
                font-size: 4rem;
                font-weight: 800;
                color: #4f46e5;
                line-height: 1.15;
                letter-spacing: -0.025em;
            }

            #brand-tagline {
                font-size: 1.35rem;
                color: #94a3b8;
                font-weight: 500;
                margin-top: 6px;
                opacity: 0;
                transition: opacity 0.5s ease;
            }

            #brand-tagline.show {
                opacity: 1;
            }

            @media (max-width: 768px) {
                #logo-img { width: 170px; }
                #click-hint { font-size: 0.9rem; margin-top: 22px; }
                #brand-title { font-size: 2.75rem; }
                #brand-tagline { font-size: 1.15rem; }
                #brand-group { gap: 32px; }
            }

            @media (max-width: 420px) {
                #logo-img { width: 130px; }
                #brand-title { font-size: 2rem; }
                #brand-tagline { font-size: 0.95rem; }
                #brand-group { gap: 24px; }
            }
        </style>
    </head>
    <body>
        <!-- Phase 1: Splash Screen -->
        <div id="phase-splash" class="phase">
            <div class="flex flex-col items-center text-center max-w-lg mx-auto px-4 sm:px-6">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-indigo-600 tracking-tight leading-tight">
                    SIPAS UNSUB
                </h1>
                <p class="mt-2 text-sm sm:text-base text-gray-400 font-medium">
                    Smart Letter Archiving System
                </p>

                <div class="mt-8 sm:mt-10 w-full max-w-sm">
                    <img src="{{ asset('images/splash.svg') }}" alt="Splash Illustration" class="w-full h-auto">
                </div>

                <p class="mt-8 sm:mt-10 text-sm text-gray-400 animate-pulse">
                    Memuat aplikasi...
                </p>
            </div>
        </div>

        <!-- Phase 2: Logo Intro + Brand Reveal (after click) -->
        <div id="phase-logo" class="phase hidden">
            <div id="brand-group">
                <img src="{{ asset('click.png') }}" alt="SIPAS UNSUB" id="logo-img" draggable="false">
                <div id="brand-text-wrap">
                    <div id="brand-text-inner">
                        <h1 id="brand-title">SIPAS UNSUB</h1>
                        <p id="brand-tagline">Smart Letter Archiving System</p>
                    </div>
                </div>
            </div>
            <p id="click-hint">Klik dimana saja untuk lanjut</p>
        </div>

        <script>
            (function() {
                var phaseSplash = document.getElementById('phase-splash');
                var phaseLogo = document.getElementById('phase-logo');
                var logo = document.getElementById('logo-img');
                var clickHint = document.getElementById('click-hint');
                var brandTextWrap = document.getElementById('brand-text-wrap');
                var brandTagline = document.getElementById('brand-tagline');
                var redirectUrl = '{{ route("login") }}';

                var splashDuration = 2000 + Math.floor(Math.random() * 500);
                var logoRevealed = false;
                var animating = false;

                // Timing constants (ms)
                var ZOOM_DURATION = 400;
                var ZOOM_SCALE = 1.06;
                var SHIFT_DELAY = 400;
                var SHIFT_DURATION = 450;
                var TAGLINE_DELAY = 600;
                var TAGLINE_DURATION = 500;
                var PAUSE_AFTER_BRANDING = 1100;

                setTimeout(function() {
                    phaseSplash.classList.add('hidden');
                    phaseLogo.classList.remove('hidden');

                    setTimeout(function() {
                        logo.classList.add('show');

                        setTimeout(function() {
                            clickHint.classList.add('show');
                            logoRevealed = true;
                        }, 800);
                    }, 300);
                }, splashDuration);

                function measureTextWidth() {
                    brandTextWrap.style.removeProperty('width');
                    brandTextWrap.style.width = 'auto';
                    var width = brandTextWrap.scrollWidth;
                    brandTextWrap.style.removeProperty('width');
                    void brandTextWrap.offsetHeight;
                    return width;
                }

                function getShiftAmount() {
                    var w = window.innerWidth;
                    if (w <= 420) return -6;
                    if (w <= 768) return -8;
                    return -10;
                }

                function startBrandReveal() {
                    if (!logoRevealed || animating) return;
                    animating = true;

                    document.removeEventListener('click', startBrandReveal);
                    document.removeEventListener('touchstart', startBrandReveal);

                    clickHint.classList.remove('show');

                    var textWidth = measureTextWidth();
                    brandTextWrap.style.setProperty('--brand-width', textWidth + 'px');

                    var shiftPx = getShiftAmount();

                    logo.style.transition = 'transform ' + ZOOM_DURATION + 'ms cubic-bezier(0.22, 1, 0.36, 1)';
                    logo.style.transform = 'scale(' + ZOOM_SCALE + ')';

                    setTimeout(function() {
                        logo.style.transition = 'transform ' + SHIFT_DURATION + 'ms cubic-bezier(0.22, 1, 0.36, 1)';
                        logo.style.transform = 'scale(' + ZOOM_SCALE + ') translateX(' + shiftPx + 'px)';
                        brandTextWrap.classList.add('reveal');

                        setTimeout(function() {
                            brandTagline.classList.add('show');

                            setTimeout(function() {
                                window.location.href = redirectUrl;
                            }, TAGLINE_DURATION + PAUSE_AFTER_BRANDING);
                        }, TAGLINE_DELAY);
                    }, SHIFT_DELAY);
                }

                document.addEventListener('click', startBrandReveal);
                document.addEventListener('touchstart', startBrandReveal, { passive: true });
            })();
        </script>
    </body>
</html>
