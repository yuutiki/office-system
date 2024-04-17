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
        {{-- favicon --}}
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
        <!-- Add this to your app.blade.php layout -->

        {{-- Windows/Android用マニフェスト --}}
        <link rel="manifest" href="/manifest.json">
        {{-- IOS用マニフェスト --}}
        <link rel="manifest" href="manifest.webmanifest" />
        <script async src="https://cdn.jsdelivr.net/npm/pwacompat" crossorigin="anonymous"></script>
        {{-- serviceworkerの読み込み --}}
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
        <script>
            // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        {{-- ApexCharts  --}}
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
        <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script> --}}
        {{-- <link rel="stylesheet" href="{{ asset('/assets/css/select2.min.css') }}"> --}}
        {{-- <script type="text/javascript" src="{{ asset('/assets/js/select2.min.js') }}"></script> --}}
        <!-- Select2のスタイルを読み込む（CDNを使用する場合） -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

        {{-- 横スクロールヒント1/2 --}}
        <link rel="stylesheet" href="https://unpkg.com/scroll-hint@latest/css/scroll-hint.css">
        {{-- 横スクロールヒント2/2 --}}


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-blue-100 dark:bg-gray-900 ">
            @include('layouts.drawernavigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-gray-300  dark:bg-gray-800 shadow mt-12">
                    <div class="md:ml-9 py-4 px-4">
                        {{ $header }}
                    </div>
                </header>
            @endif
            
            <!-- Page Content -->
            <main class="h-auto">
                {{ $slot }}
            </main>


            <div id="rap" class="fixed bottom-6 md:bottom-12 end-6 group z-[9999]">
                <div id="speed-dial-button" class="flex flex-col items-center hidden mb-4 space-y-2">
                    <button type="button" onclick="location.href='{{route('reports.create')}}'" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <svg class="w-4 h-4 mx-auto mb-1"  xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                            <path d="M14.419 10.581a3.564 3.564 0 0 0-2.574 1.1l-4.756-2.49a3.54 3.54 0 0 0 .072-.71 3.55 3.55 0 0 0-.043-.428L11.67 6.1a3.56 3.56 0 1 0-.831-2.265c.006.143.02.286.043.428L6.33 6.218a3.573 3.573 0 1 0-.175 4.743l4.756 2.491a3.58 3.58 0 1 0 3.508-2.871Z"/>
                        </svg>
                        <span class="block mb-px text-xs font-medium">Report</span>
                    </button>
                    <button type="button" onclick="location.href='{{route('keepfile.create')}}'" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <svg class="w-4 h-4 mx-auto mb-1"  xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 20h10a1 1 0 0 0 1-1v-5H4v5a1 1 0 0 0 1 1Z"/>
                            <path d="M18 7H2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2v-3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-1-2V2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3h14Z"/>
                        </svg>
                        <span class="block mb-px text-xs font-medium">Keepfile</span>
                    </button>
                    <button type="button" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <svg class="w-4 h-4 mx-auto mb-1"  xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                            <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="block mb-px text-xs font-medium">Save</span>
                    </button>
                    <button type="button" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <svg class="w-4 h-4 mx-auto mb-1"  xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M5 9V4.13a2.96 2.96 0 0 0-1.293.749L.879 7.707A2.96 2.96 0 0 0 .13 9H5Zm11.066-9H9.829a2.98 2.98 0 0 0-2.122.879L7 1.584A.987.987 0 0 0 6.766 2h4.3A3.972 3.972 0 0 1 15 6v10h1.066A1.97 1.97 0 0 0 18 14V2a1.97 1.97 0 0 0-1.934-2Z"/>
                            <path d="M11.066 4H7v5a2 2 0 0 1-2 2H0v7a1.969 1.969 0 0 0 1.933 2h9.133A1.97 1.97 0 0 0 13 18V6a1.97 1.97 0 0 0-1.934-2Z"/>
                        </svg>
                        <span class="block mb-px text-xs font-medium">Copy</span>
                    </button>
                </div>
                <button type="button" id="dial" onclick="rotateButton()" class="flex items-center justify-center text-white bg-blue-700 rounded-full w-14 h-14 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-5 h-5 transition-transform" id="dial-icon"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                    <span class="sr-only">Open actions menu</span>
                </button>
            </div>


            <footer class="bg-white dark:bg-gray-800 sticky top-[100vh]">
                <div class="w-full mx-auto justify-end">
                    <div class="text-sm text-right text-gray-500  dark:text-gray-400 px-2" tabindex="-1">
                        © 2023 <a href="#" class="hover:underline" tabindex="-1">Yuu™</a>. All Rights Reserved.
                    </div>
                    <div class="text-sm text-right text-gray-500 dark:text-gray-400 px-2">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </footer>
        </div>

        <style>
            .rotate-45 {
            @apply transform rotate-45;
            transition: transform 0.1s ease; /* ゆっくりと回転するアニメーションを設定 */
        }
        </style>


        <script>
        function rotateButton() {
            const icon = document.getElementById('dial-icon');
            icon.classList.toggle('rotate-45');
        }

            // ページのスクロールを監視し、特定の要素を非表示にする関数
            function hideElementOnScroll() {
                var specialElement = document.getElementById('dial');
                var scrollThreshold = 100; // スクロールの閾値（最下部からの距離）
    
                // スクロールイベントリスナーの追加
                window.addEventListener('scroll', function() {
                    // ページの最下部までスクロールしたかどうかをチェック
                    var isBottom = (window.innerHeight + window.scrollY) >= document.body.offsetHeight - scrollThreshold;
    
                    // 最下部までスクロールした場合は特定の要素を非表示にする
                    if (isBottom) {
                        specialElement.style.display = 'none';
                    } else {
                        specialElement.style.display = '';
                    }
                });
            }
    
            // ページ読み込み時に関数を呼び出す
            window.onload = hideElementOnScroll;
        </script>

        <script>
// スピードダイヤルを表示/非表示に切り替える関数
function toggleDialVisibility() {
    const speedDialButton = document.getElementById('speed-dial-button');
    speedDialButton.classList.toggle('hidden');
}

// スピードダイヤルトリガーボタンにクリックイベントリスナーを追加
const dialButton = document.getElementById('dial');
dialButton.addEventListener('click', toggleDialVisibility);
        </script>


        {{-- ダークモードスイッチャー --}}
        <script src="{{ asset('/assets/js/darkmodeswitcher.js') }}"></script>
        {{-- inputのEnter無効化 --}}
        <script src="{{ asset('/assets/js/allinputenterdisable.js') }}"></script>
        {{-- JQUERY --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        {{-- カナ補完 --}}
        <script type="text/javascript" src="{{ asset('/assets/js/jquery.autoKana.js') }}"></script>
        {{-- 住所補完 --}}
        <script type="text/javascript" src="{{ asset('/assets/js/jquery.zip2addr.js') }}"></script>
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        {{-- ショートカット --}}
        <script type="text/javascript" src="{{ asset('/assets/js/shortcut.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/assets/js/main.js') }}"></script>
        <!-- Select2を読み込む（CDNを使用する場合） -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/ja.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/libphonenumber-js/1.1.10/libphonenumber-js.min.js"></script>

    </body>
</html>




