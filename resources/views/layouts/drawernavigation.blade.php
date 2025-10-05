{{-- Start 画面上部のナビゲーション --}}
<div class="flex justify-between w-full fixed top-0 z-50 bg-[#4b576b] dark:bg-gray-800 border-b border-gray-500 dark:border-gray-700">
    {{-- スマホ用drawerサイドメニュー表示ボタン --}}
    <div class="flex">
        <div class="flex items-center">
            <button  class="inline-flex items-center p-1 rounded-sm ml-[1px] text-gray-900 dark:text-gray-500 hover:text-gray-500  dark:hover:text-gray-400 hover:bg-gray-500 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-500 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out" type="button" data-active-classes="bg-gray-400" data-drawer-target="sm-accordion-collapse" data-drawer-toggle="sm-accordion-collapse" aria-controls="sm-accordion-collapse" data-drawer-trigger="hover"  tabindex="-1">
                <div class="flex items-center">
                    <x-icon name="icons/logo" class="h-full w-[38px] fill-current text-gray-100 dark:fill-gray-300" />
                </div>
            </button>
            <!-- Page Heading -->
            <h5 class="ml-2 text-base font-semibold text-gray-100 dark:text-gray-400 hidden md:block">Orphice</h5>
        </div>
    </div>

    <div class="flex items-center">

        <h5 class="mr-3 text-base font-semibold text-gray-100 dark:text-gray-400 hidden md:block">
            @if(Auth::check())
            {{ Auth::user()->department->root_name }}
            @endif
        </h5>


        
        {{-- 共通リンク一覧 --}}
        <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" tabindex="-1" class="inline-flex mx-0.5 items-center p-2 text-sm font-medium text-center text-gray-900 rounded-sm hover:bg-gray-500 focus:ring-2 focus:outline-none dark:text-white focus:ring-gray-500 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button"> 
            <svg class="w-6 h-6 text-gray-100 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 19 19">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.013 7.962a3.519 3.519 0 0 0-4.975 0l-3.554 3.554a3.518 3.518 0 0 0 4.975 4.975l.461-.46m-.461-4.515a3.518 3.518 0 0 0 4.975 0l3.553-3.554a3.518 3.518 0 0 0-4.974-4.975L10.3 3.7"/>
            </svg>
        </button>
          
        <!-- Dropdown menu -->
        <div id="dropdownDots" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
            @if ($links->isNotEmpty())
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                    @foreach ($links as $link)
                    <li>
                        <a href="{{ $link->url }}" target="_blank" class="block px-4 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $link->display_name }}</a>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- ダークモードスイッチャー
        <button id="theme-toggle" type="button" class="h-10 p-2.5 my-auto text-sm rounded-sm text-gray-800 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 dark:focus:ring-gray-700" tabindex="-1">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
        </button> --}}

        {{-- 通知ボックス --}}
        <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider" class="relative flex items-end h-10 p-2.5 my-auto text-sm rounded-sm font-medium px-3 mr-4 text-right text-white focus:ring-2 hover:bg-gray-500 dark:hover:bg-gray-700 focus:outline-none focus:ring-gray-500" tabindex="-1" type="button">
            <svg class="w-[19px] h-[19px] my-auto text-gray-100 dark:text-gray-400 focus:text-green-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
            </svg>
            <span class="sr-only">Notifications</span>
            <div id="notification-counter" class="absolute inline-flex items-center justify-center w-5 h-5 text-xs text-white bg-red-500 border-1 border-gray-300 rounded-full -top-0.5 -right-0.5 dark:border-gray-900">
                {{ count($unreadNotifications) }}
            </div>
        </button>


        @if(isset($notificationUpdated) && $notificationUpdated)
        <script>
            // ページ読み込み完了後に実行
            window.addEventListener('load', function() {
                console.log('通知更新スクリプトが実行されました');
                console.log('新しい通知数: {{ $afterCount }}');
                
                // IDで要素を特定
                const notificationCounter = document.getElementById('notification-counter');
                
                if (notificationCounter) {
                    console.log('通知カウンター要素が見つかりました');
                    notificationCounter.textContent = '{{ $afterCount }}';
                    
                    // カウントが0の場合は非表示にする
                    if ({{ $afterCount }} === 0) {
                        notificationCounter.classList.add('hidden');
                    } else {
                        notificationCounter.classList.remove('hidden');
                    }
                    console.log('通知カウンターを更新しました');
                } else {
                    console.error('通知カウンター要素が見つかりません');
                }
            });
        </script>
        @endif
        
        <!-- 通知ボックスDropdown -->
        <div id="dropdownDivider" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-auto dark:bg-gray-700 dark:divide-gray-600 whitespace-nowrap">
            @if ($unreadNotifications->isNotEmpty())
                <ul class="py-2 text-sm text-gray-900 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                    @foreach ($unreadNotifications  as $notification)
                        <li class="flex justify-between hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                            {{-- <p  class="block px-4 py-2">{{ $notification->data['notification_data']['reporter'] }}</p> --}}
                            <form action="{{ route('notifications.read', $notification) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="{{ is_null($notification->read_at) ? 'un-read' : '' }}">
                                    <div class="flex justify-between hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        {{-- <p class="block px-4 py-2">{{ $notification->data['content_data']['reporter']['user_name'] }}</p> --}}
                                        <p class="block px-4 py-2">{{ $notification->data['notification_data']['notification_title'] }}</p>
                                    </div>
                                </button>
                            </form>
                            {{-- <a href="{{ $notification->data['notification_data']['action_url'] }}" class="block px-4 py-2">{{ $notification->data['notification_data']['message'] }}</a> --}}
                            <div class="px-4 py-2">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <div class="py-1">
                <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    すべてのメッセージを見る
                </a>
            </div>
        </div>

        {{-- <img class="w-10 h-10 rounded border-gray-500 border" src="{{ asset('storage/' . Auth::user()->profile_image) }}?{{ time() }}" alt="プロフィール画像"> --}}
        @if (Auth::check() && Auth::user()->profile_image)
            <img class="w-10 h-10 rounded border-gray-500 border"
                src="{{ asset('storage/' . Auth::user()->profile_image) }}?{{ time() }}"
                alt="プロフィール画像">
        @else
            <img class="w-10 h-10 rounded border-gray-500 border"
                src="{{ asset('images/default-profile.png') }}"
                alt="デフォルトプロフィール画像">
        @endif

        {{-- ユーザ設定 --}}
        <div class=" sm:flex sm:items-center sm:ml-1">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center bg-[#4b576b] px-3 py-4 border border-transparent text-sm leading-4 font-medium rounded-sm text-gray-100 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-300 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150" tabindex="-1">
                        {{-- <svg class="sm:hidden w-6 h-6 text-gray-800 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                        </svg> --}}
                        <div class="whitespace-nowrap">
                            @if(Auth::check())
                            {{ Auth::user()->user_name }}
                            @endif
                        </div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</div>
{{-- End 画面上部のナビゲーション --}}


<nav X-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

{{-- デスクトップ画面用 --}}
<div id="accordion-collapse" data-accordion="collapse" data-active-classes="bg-gray-500 dark:bg-gray-800 text-blue-600 dark:text-white" class="fixed mt-10 pt-4 dark:bg-gray-800 bg-primary h-screen w-12 overflow-x-hidden hover:w-52 whitespace-nowrap transition-all duration-500 ease-in-out z-40 invisible md:visible border-r border-gray-200 dark:border-gray-700">

        <div class="py-4 pl-2">
        <ul class="space-y-1">
            <li>
                <x-nav-link :href="route('dashboard')" :tabindex="-1" :active="request()->routeIs('dashboard')" class="flex w-full items-center p-2 text-white rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                    <x-icon name="icons/nav-dashboard" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                    <span class="flex-1 ml-3 whitespace-nowrap" tabindex="-1">{{ __('ホーム') }}</span>
                </x-nav-link>
            </li>
            @canany(['view_corporations', 'view_clients', 'view_vendors', 'view_client_contacts', 'view_vendor_persons', ])
                <li>
                    <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm text-white transition duration-75 rounded-sm group  hover:bg-gray-500 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#accordion-body-1" aria-expanded="false" aria-controls="accordion-body-1">
                        <x-icon name="icons/nav-client" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('取引先管理') }}</span>
                        <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                    </button>
                    <ul class="hidden py-1 space-y-1 text-white" id="accordion-body-1" aria-labelledby="accordion-heading-1">
                        <li>
                            @can('view_corporations')
                            <x-nav-link :href="route('corporations.index')" :active="request()->routeIs('corporations.index')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 ml-10 whitespace-nowrap">{{ __('法人一覧') }}</span>
                            </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            @can('view_clients')
                                <x-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('顧客一覧') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            @can('view_vendors')
                                <x-nav-link :href="route('vendors.index')" :active="request()->routeIs('vendors.index')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('業者一覧') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            @can('view_client_contacts')
                                <x-nav-link :href="route('client-contacts.index')" :active="request()->routeIs('client-contacts.index')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('顧客担当者一覧') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            @can('view_vendor_persons')
                                <x-nav-link :href="route('client-contacts.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('業者担当者一覧') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            @can('view_vendor_persons')
                                <x-nav-link :href="route('client-products.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('導入製品一覧') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                    </ul>
                </li>
            @endcanany
            @canany(['view_projects', 'view', 'delete'])
                <li>
                    <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-white transition duration-75 rounded-sm group hover:bg-gray-500 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#accordion-body-3" aria-expanded="false" aria-controls="accordion-body-3">
                        <x-icon name="icons/nav-project" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('プロジェクト管理') }}</span>
                        <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                    </button>
                    <ul  class="hidden py-1 space-y-1" id="accordion-body-3" aria-labelledby="accordion-heading-3">
                        <li>
                            @can('view_projects')
                                <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('プロジェクト一覧') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        {{-- <li>
                            <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 ml-10 whitespace-nowrap">{{ __('受注情報一覧') }}</span>
                            </x-nav-link>
                        </li> --}}
                        <li>
                            {{-- TODO:functon_menuに発注情報、営業経費、社内工数を追加する --}}
                            @can('view_projects')
                                <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('発注情報一覧') }}</span>
                                </x-nav-link>                            
                            @endcan
                        </li>
                        <li>
                            @can('view_projects')
                                <x-nav-link :href="route('project-expense.index')" :active="request()->routeIs('project-expense.index')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('営業経費一覧') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            @can('view_projects')
                                <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('社内工数一覧') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                    </ul>
                </li>
            @endcanany
            @canany(['view_supports', 'view_contracts'])
                <li>
                    <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-white transition duration-75 rounded-sm group hover:bg-gray-500 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#support-body" aria-expanded="false" aria-controls="support-body">
                        <x-icon name="icons/nav-support" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('サポート管理') }}</span>
                        <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                    </button>
                    <ul  class="hidden py-1 space-y-1" id="support-body" aria-labelledby="support-heading">
                        @can('view_supports')
                            <li>
                                <x-nav-link :href="route('supports.index')" :active="request()->routeIs('supports.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('サポート一覧') }}</span>
                                </x-nav-link>
                            </li>
                        @endcan
                        @can('view_contracts')
                            <li>
                                <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('契約一覧') }}</span>
                                </x-nav-link>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['view_reports',])
                <li>
                    <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-white transition duration-75 rounded-sm group hover:bg-gray-500 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#report-body" aria-expanded="false" aria-controls="report-body">
                        <x-icon name="icons/nav-report" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('営業報告管理') }}</span>
                        <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                    </button>
                    <ul  class="hidden py-1 space-y-1" id="report-body" aria-labelledby="report-heading">
                        @can('view_reports')
                        <li>
                            <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 ml-10 whitespace-nowrap">{{ __('営業報告一覧') }}</span>
                            </x-nav-link>
                        </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            {{-- <li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('#')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 5 4 4-4 4m5 0h5M2 1h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">{{ __('工数管理') }}</span>
                </x-nav-link>
            </li> --}}
            @canany(['view_keepfiles',])
                <li>
                    <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-white transition duration-75 rounded-sm group hover:bg-gray-500 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#keepfile-body" aria-expanded="false" aria-controls="keepfile-body">
                        <x-icon name="icons/nav-keepfile" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('預託管理') }}</span>
                        <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                    </button>
                    <ul  class="hidden py-1 space-y-1" id="keepfile-body" aria-labelledby="keepfile-heading">
                        @can('view_keepfiles')
                        <li>
                            <x-nav-link :href="route('keepfiles.index')" :active="request()->routeIs('keepfiles.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 ml-10 whitespace-nowrap">{{ __('預託情報一覧') }}</span>
                            </x-nav-link>
                        </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['view_workflows',])
                <li>
                    <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-white transition duration-75 rounded-sm group hover:bg-gray-500 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#workflow-body" aria-expanded="false" aria-controls="workflow-body">
                        <x-icon name="icons/nav-workflow" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('ワークフロー') }}</span>
                        <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                    </button>
                    <ul  class="hidden py-1 space-y-1" id="workflow-body" aria-labelledby="workflow-heading">
                        <li>
                            <x-nav-link :href="route('supports.index')" :active="request()->routeIs('supports.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 ml-10 whitespace-nowrap">{{ __('テンプレート一覧') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 ml-10 whitespace-nowrap">{{ __('申請一覧') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 ml-10 whitespace-nowrap">{{ __('代理申請一覧') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 ml-10 whitespace-nowrap">{{ __('確認一覧') }}</span>
                            </x-nav-link>
                        </li>
                    </ul>
                </li>
            @endcanany
            @canany(['view_products',])
                <li>
                    <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-white transition duration-75 rounded-sm group hover:bg-gray-500 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#product-body" aria-expanded="false" aria-controls="product-body">
                        <x-icon name="icons/nav-product" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('製品管理') }}</span>
                        <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                    </button>
                    <ul  class="hidden py-1 space-y-1" id="product-body" aria-labelledby="product-heading">
                        @can('view_products')
                        <li>
                            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-[#3e4858] dark:hover:bg-gray-700">
                                <span class="flex-1 ml-10 whitespace-nowrap">{{ __('製品一覧') }}</span>
                            </x-nav-link>
                        </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <ul class="pt-4 mt-4 space-y-2 border-t border-gray-500 dark:border-gray-700">

            @canany(['view_users', 'view_role_groups', 'view_links', 'view_masters', 'view_password_policies', 'view_operation_logs',])
                <li>
                    <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-white transition duration-75 rounded-sm group hover:bg-[#3e4858] dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#accordion-body-90" aria-expanded="false" aria-controls="accordion-body-90">
                        <x-icon name="icons/nav-setting" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('共通機能') }}</span>
                        <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 text-gray-100 transition-transform" />
                    </button>
                    <ul  class="hidden py-1 space-y-1" id="accordion-body-90" aria-labelledby="accordion-heading-90">
                        <li>
                            @can('view_users')
                                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-[#3e4858] dark:hover:bg-gray-700">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('ユーザ管理') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            @can('view_role_groups')
                                <x-nav-link :href="route('role-groups.index')" :active="request()->routeIs('role-groups.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-[#3e4858] dark:hover:bg-gray-700">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('権限設定') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            @can('view_masters')
                                <x-nav-link :href="route('masters.index')" :active="request()->routeIs('masters.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-[#3e4858] dark:hover:bg-gray-700">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('Master Setting') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        {{-- TODO:システム設定用の権限やFunctionMenuの作成(デスクトップ)--}}
                        <li>
                            @can('view_password_policies')
                                <x-nav-link :href="route('app-settings.index')" :active="request()->routeIs('app-settings.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-[#3e4858] dark:hover:bg-gray-700">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('System Setting') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            @can('view_operation_logs')
                                <x-nav-link :href="route('logs.index')" :active="request()->routeIs('logs.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-[#3e4858] dark:hover:bg-gray-700">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('操作ログ') }}</span>
                                </x-nav-link>
                            @endcan
                        </li>
                        @if(Auth::user()->role == 'system_admin')
                            <li>
                                <x-nav-link :href="url('/log-viewer')" :active="request()->routeIs('log-viewer')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('システムログ') }}</span>
                                </x-nav-link>
                            </li>
                        @endif
                    </ul>
                </li>
            @endcanany
        </ul>
    </div>
</div>





    <!-- スマホ画面 -->
    <div id="sm-accordion-collapse" data-accordion="sm-collapse" class="mt-12  fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full w-60 bg-white dark:bg-gray-800"  tabindex="-1">
        <div class="py-4 overflow-y-auto">
            <ul class="space-y-1 font-medium">
                <li>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <x-icon name="icons/nav-dashboard" class="flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400" />
                        <span class="flex-1 ml-6 whitespace-nowrap">{{ __('ホーム') }}</span>
                    </x-nav-link>
                </li>
                @canany(['view_corporations', 'view_clients', 'view_vendors', 'view_client_contacts', 'view_vendor_persons', ])
                    <li>
                        <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#sm-client-body" aria-expanded="false" aria-controls="sm-client-body">
                            <x-icon name="icons/nav-client" class="flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('取引先管理') }}</span>
                            <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                        </button>
                        <ul class="hidden py-1 space-y-1" id="sm-client-body" aria-labelledby="sm-client-heading">
                            <li>
                                @can('view_corporations')
                                <x-nav-link :href="route('corporations.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('法人一覧') }}</span>
                                </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_clients')
                                    <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('顧客一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_vendors')                                
                                    <x-nav-link :href="route('vendors.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('業者一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_client_contacts')
                                    <x-nav-link :href="route('client-contacts.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('顧客担当者一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_vendor_persons')
                                    <x-nav-link :href="route('client-contacts.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('業者担当者一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_client_products')
                                    <x-nav-link :href="route('client-products.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-100 rounded-sm dark:text-white hover:bg-gray-500 dark:hover:bg-gray-700" tabindex="-1">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('導入製品一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                        </ul>
                    </li>
                @endcanany

                @canany(['view_projects', ])
                    <li>
                        <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#sm-project-body" aria-expanded="false" aria-controls="sm-project-body">
                            <x-icon name="icons/nav-project" class="flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('プロジェクト管理') }}</span>
                            <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                        </button>
                        <ul class="hidden py-1 space-y-1" id="sm-project-body" aria-labelledby="sm-project-heading">
                            <li>
                                @can('view_projects')
                                    <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('プロジェクト一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                {{-- TODO:maintenance --}}
                                @can('view_projects')
                                    <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('発注情報一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_projects')
                                    <x-nav-link :href="route('project-expense.index')" :active="request()->routeIs('project-expense.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('営業経費一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_projects')
                                    <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('社内工数一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany(['view_supports', 'view_contracts',])
                    <li>
                        <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#sm-support-body" aria-expanded="false" aria-controls="sm-support-body">
                            <x-icon name="icons/nav-support" class="flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('サポート管理') }}</span>
                            <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                        </button>
                        <ul class="hidden py-1 space-y-1" id="sm-support-body" aria-labelledby="sm-support-heading">
                            <li>
                                @can('view_supports')
                                    <x-nav-link :href="route('supports.index')" :active="request()->routeIs('supports.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('サポート一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_contracts')
                                    <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('契約一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany(['view_reports',])
                    <li>
                        <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#sm-report-body" aria-expanded="false" aria-controls="sm-report-body">
                            <x-icon name="icons/nav-report" class="flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('営業報告管理') }}</span>
                            <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                        </button>
                        <ul  class="hidden py-1 space-y-1" id="sm-report-body" aria-labelledby="sm-report-heading">
                            <li>
                                @can('view_reports')
                                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('営業報告一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                        </ul>
                    </li>
                @endcanany
                {{-- <li>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('#')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 5 4 4-4 4m5 0h5M2 1h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ __('工数管理') }}</span>
                    </x-nav-link>
                </li> --}}
                @canany(['view_keepfiles',], )
                    <li>
                        <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#sm-keepfile-body" aria-expanded="false" aria-controls="sm-keepfile-body">
                            <x-icon name="icons/nav-keepfile" class="flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('預託管理') }}</span>
                            <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                        </button>
                        <ul  class="hidden py-1 space-y-1" id="sm-keepfile-body" aria-labelledby="sm-keepfile-heading">
                            <li>
                                @can('view_keepfiles')
                                    <x-nav-link :href="route('keepfiles.index')" :active="request()->routeIs('keepfiles.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('預託情報一覧') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany(['view_workflows',])
                    <li>
                        <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#sm-workflow-body" aria-expanded="false" aria-controls="sm-workflow-body">
                            <x-icon name="icons/nav-workflow" class="flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('ワークフロー') }}</span>
                            <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                        </button>
                        <ul  class="hidden py-1 space-y-1" id="sm-workflow-body" aria-labelledby="sm-workflow-heading">
                            <li>
                                <x-nav-link :href="route('supports.index')" :active="request()->routeIs('supports.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('テンプレート一覧') }}</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('申請一覧') }}</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('代理申請一覧') }}</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('確認一覧') }}</span>
                                </x-nav-link>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany(['view_products',])
                    <li>
                        <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-white transition duration-75 rounded-sm group hover:bg-gray-500 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#sm-product-body" aria-expanded="false" aria-controls="sm-product-body">
                            <x-icon name="icons/nav-product" class="flex-shrink-0 w-6 h-6 text-gray-100 dark:text-gray-400" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('製品管理') }}</span>
                            <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                        </button>
                        <ul  class="hidden py-1 space-y-1" id="sm-product-body" aria-labelledby="sm-product-heading">
                            @can('view_products')
                            <li>
                                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="flex w-full items-center px-2 pb-1 text-white rounded-sm dark:text-white hover:bg-[#3e4858] dark:hover:bg-gray-700">
                                    <span class="flex-1 ml-10 whitespace-nowrap">{{ __('製品一覧') }}</span>
                                </x-nav-link>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">

                @canany(['view_users', 'view_role_groups', 'view_links', 'view_masters', 'view_password_policies', 'view_operation_logs',])
                    <li>
                        <button type="button" class="flex items-center w-full py-1.5 pr-1 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#sm-admin-body" aria-expanded="false" aria-controls="sm-admin-body">
                            <x-icon name="icons/nav-setting" class="flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('共通機能') }}</span>
                            <x-icon name="ui/accordion-arrow" class="w-3 h-3 mr-1 shrink-0 transition-transform" />
                        </button>
                        <ul  class="hidden py-1 space-y-1" id="sm-admin-body" aria-labelledby="sm-admin-heading">
                            <li>
                                @can('view_users')
                                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('ユーザ管理') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_role_groups')
                                    <x-nav-link :href="route('role-groups.index')" :active="request()->routeIs('role-groups.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        {{-- <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg> --}}
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('権限設定') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_masters')
                                    <x-nav-link :href="route('masters.index')" :active="request()->routeIs('masters.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('Master Setting') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>


                            {{-- TODO:システム設定用の権限やFunctionMenuの作成(スマホ)--}}
                            <li>
                                @can('view_password_policies')
                                    <x-nav-link :href="route('password-policy.edit', 1)" :active="request()->routeIs('password-policy.edit', 1)" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('System Setting') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @can('view_operation_logs')
                                    <x-nav-link :href="route('logs.index')" :active="request()->routeIs('logs.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('操作ログ') }}</span>
                                    </x-nav-link>
                                @endcan
                            </li>
                            <li>
                                @if (Auth::user()->role == 'system_admin')
                                    <x-nav-link :href="url('/log-viewer')" :active="request()->routeIs('log-viewer')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="flex-1 ml-10 whitespace-nowrap">{{ __('システムログ') }}</span>
                                    </x-nav-link>
                                @endif
                            </li>
                        </ul>
                    </li>
                @endcanany
            </ul>
        </div>
    </div>
</nav>