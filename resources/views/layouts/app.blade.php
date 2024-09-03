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

        <!-- jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- 郵便番号 -->
        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
        <!-- Darkモード用 -->
        <script>
            // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>

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

        <!-- PDFのプレビュー表示用 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-blue-100 dark:bg-gray-900 ">
            @include('layouts.drawernavigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="fixed top-12 left-0 right-0 z-10 bg-gray-100 dark:bg-gray-800 shadow-md">
                    <div class="md:ml-9 py-3 px-4">
                        {{ $header }}
                    </div>
                </header>
            @endif
            
            <!-- Page Content -->
            <main class="h-auto mt-28">
                {{ $slot }}
            </main>


            <div id="rap" class="fixed bottom-11 right-6 z-50">
                <div id="speed-dial-button" class="flex flex-col items-center hidden mb-4 space-y-2">
                    <button type="button" onclick="location.href='{{route('support.create')}}'" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <span class="block mb-px text-xs font-medium">サポート</span>
                    </button>
                    <button type="button" onclick="location.href='{{route('reports.create')}}'" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <span class="block mb-px text-xs font-medium">営業報告</span>
                    </button>
                    <button type="button" onclick="location.href='{{route('projects.create')}}'" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <span class="block mb-px text-xs font-medium">プロジェクト</span>
                    </button>
                    <button type="button" onclick="location.href='{{route('keepfile.create')}}'" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <span class="block mb-px text-xs font-medium">預託情報</span>
                    </button>
                    <button type="button" onclick="location.href='{{route('client-person.create')}}'" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <span class="block mb-px text-xs font-medium">顧客<br>担当者</span>
                    </button>
                    <button type="button" onclick="location.href='{{route('dashboard')}}'" class="w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 shadow-sm dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                        <span class="block mb-px text-xs font-medium">Home</span>
                    </button>
                </div>
                <button type="button" id="dial" onclick="toggleDialVisibility()" class="relative w-14 h-14 bg-blue-600 rounded-full focus:outline-none">
                    <span class="block absolute left-4 top-[19px] w-6 h-0.5 bg-white transition-all duration-300 ease-in-out" id="line1"></span>
                    <span class="block absolute left-4 top-[27px] w-4 h-0.5 bg-white transition-all duration-300 ease-in-out" id="line2"></span>
                    <span class="block absolute left-4 top-[35px] w-2 h-0.5 bg-white transition-all duration-300 ease-in-out" id="line3"></span>
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

        {{-- <style>
            .rotate-45 {
            @apply transform rotate-45;
            transition: transform 0.1s ease; /* ゆっくりと回転するアニメーションを設定 */
        }
        </style> --}}


    <script>
        function toggleDialVisibility() {
            const speedDialButton = document.getElementById('speed-dial-button');
            const dial = document.getElementById('dial');
            const line1 = document.getElementById('line1');
            const line2 = document.getElementById('line2');
            const line3 = document.getElementById('line3');
        
            speedDialButton.classList.toggle('hidden');
            dial.classList.toggle('active');
        
            if (dial.classList.contains('active')) {
                line1.classList.remove('top-[19px]','left-3');
                line1.classList.add('top-[50%]', 'translate-y-[0px]', 'rotate-[-45deg]', 'w-[50%]', 'left-3.5');
                
                line2.classList.add('opacity-0');

                line3.classList.remove('top-[35px]','left-3');
                line3.classList.add('top-[50%]', '-translate-y-[0px]', 'rotate-[45deg]', 'w-[50%]', 'left-3.5');
            } else {
                line1.classList.remove('top-[50%]', 'translate-y-[0px]', 'rotate-[-45deg]', 'w-[50%]', 'left-3.5');
                line1.classList.add('top-[19px]','left-3');

                line2.classList.remove('opacity-0');
                
                line3.classList.remove('top-[50%]', '-translate-y-[0px]', 'rotate-[45deg]', 'w-[50%]', 'left-3.5');
                line3.classList.add('top-[35px]','left-3');
            }
        }
        
        // スクロール時の動作
        function hideElementOnScroll() {
            const rap = document.getElementById('rap');
            const scrollThreshold = 1;
        
            window.addEventListener('scroll', function() {
                const isBottom = (window.innerHeight + window.scrollY) >= document.body.offsetHeight - scrollThreshold;
                rap.style.display = isBottom ? 'none' : '';
            });
        }
        
        window.onload = hideElementOnScroll;
    </script>

    



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




