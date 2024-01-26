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
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-blue-100 dark:bg-gray-900 ">
            @include('layouts.drawernavigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-gray-300  dark:bg-gray-800 shadow mt-12">
                    <div class=" ml-9 py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            
            <!-- Page Content -->
            <main class="h-auto">
                {{ $slot }}
            </main>
        </div>
        <footer class="bg-white dark:bg-gray-800">
            <div class="w-full mx-auto justify-end">
                <div class="text-sm text-right text-gray-500  dark:text-gray-400 px-2" tabindex="-1">
                    © 2023 <a href="#" class="hover:underline" tabindex="-1">Yuu™</a>. All Rights Reserved.
                </div>
                <div class="text-sm text-right text-gray-500 dark:text-gray-400 px-2">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </footer>
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
    </body>
</html>




