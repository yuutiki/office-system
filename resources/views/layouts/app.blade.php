<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="touch-manipulation">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- favicon -->
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

        {{-- Windows/Android用マニフェスト --}}
        <link rel="manifest" href="/manifest.json">
        {{-- IOS用マニフェスト --}}
        <link rel="manifest" href="manifest.webmanifest" />
        <script async src="https://cdn.jsdelivr.net/npm/pwacompat" crossorigin="anonymous"></script>
        {{-- service-workerの読み込み --}}
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/assets/js/service-worker.js')
                        .then(function(registration) {
                            console.log('Service Worker registered with scope:', registration.scope);
                        }).catch(function(error) {
                            console.log('Service Worker registration failed:', error);
                        });
                });
            }
        </script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- 郵便番号 -->
        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
        <!-- Darkモード用 -->
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>

        <!-- Alphine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
        <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

        <!-- Select2のスタイルを読み込む（CDNを使用する場合） -->
        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> --}}

        {{-- 横スクロールヒント1/2 --}}
        <link rel="stylesheet" href="https://unpkg.com/scroll-hint@latest/css/scroll-hint.css">

        {{-- 画像切り取り用 --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- PDFのプレビュー表示用 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-[#f3f4f9] dark:bg-gray-900 ">

            @include('layouts.drawernavigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="fixed top-[51px] left-0 right-0 z-10 bg-gray-100 dark:bg-gray-800 shadow-md">
                    <div class="md:ml-9 px-4 min-h-[48px] flex items-center justify-between">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>
            
            <!-- Page Content -->
            <main class="h-auto mt-28">
                {{ $slot }}
            </main>

            {{-- <x-loading-spinner /> --}}


            <div id="my-spinner" class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-800 text-white transition-all duration-[800ms]">
                <!-- スピナー全体 -->
                <div class="relative w-[120px] h-[120px]">
                    <!-- 回転する円 -->
                    <div class="absolute inset-0 border-[8px] border-solid border-white border-t-white/10 border-b-white/10 rounded-full animate-spinner">
                    </div>

                    <!-- 円の中央のテキスト -->
                    <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-xs animate-spinner-text">
                        Loading...
                    </span>
                </div>
            </div>

            <script>
                // ページの読み込み完了後にローダーをフェードアウト
                window.addEventListener('load', () => {
                    const spinner = document.getElementById('my-spinner');

                    // フェードアウトアニメーション
                    spinner.classList.add('opacity-0', 'pointer-events-none');

                    // 完全に透明になった後に非表示化（約0.8秒後）
                    setTimeout(() => {
                    spinner.classList.add('hidden');
                    }, 800);
                });
            </script>

            <style>
                @keyframes spinner {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
                }

                @keyframes spinner-text {
                0%, 100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.2;
                }
                }

                /* Tailwind で使えるように */
                @layer utilities {
                .animate-spinner {
                    animation: spinner 1.5s linear infinite;
                }

                .animate-spinner-text {
                    animation: spinner-text 1.5s ease-in-out infinite;
                }
                }
            </style>


            <!-- スピードダイアル -->
            <x-speed-dials.speed-dial />


            <footer class="bg-white dark:bg-gray-800 sticky top-[100vh]">
                <div class="w-full mx-auto justify-end">
                    <div class="text-sm text-right text-gray-500  dark:text-gray-400 px-2" tabindex="-1">
                        © 2023 <a href="#" class="hover:underline" tabindex="-1">Yuu™</a>. All Rights Reserved.
                    </div>
                    @production
                        {{--  --}}
                    @else
                        <div class="text-sm text-right text-gray-500 dark:text-gray-400 px-2">
                            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                        </div>
                    @endproduction
                </div>
            </footer>
        </div>


        {{-- JQUERY --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

        <!-- Select2を読み込む（CDNを使用する場合） -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/ja.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

        {{-- 自作JS --}}
        <script src="{{ asset('/assets/js/shortcut.js') }}"></script>
        <script src="{{ asset('/assets/js/main.js') }}"></script>

        @stack('scripts')

        <x-message :message="session('message')" class="z-[9999]"/>
    </body>
</html>




