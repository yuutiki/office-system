<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full whitespace-nowrap items-center">
            <h2 class="text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('notifications') }} 
            </h2>
            <div class="ml-auto flex w-auto md:flex-row md:space-y-0 space-x-2 items-center">
                <button type="button" onclick="location.href='{{ route('projects.create') }}'" class="flex items-center pl-2 sm:px-4 py-2 text-sm font-medium text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="h-5 w-5 sm:h-3.5 sm:w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    <div class="hidden sm:block">{{ __('Add') }}</div>
                </button>
                <button type="button" onclick="location.href='{{ route('projects.create') }}'" class="flex items-center pl-2 sm:px-4 py-2 text-sm font-medium text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="h-5 w-5 sm:h-3.5 sm:w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    <div class="hidden sm:block">{{ __('既読にする') }}</div>
                </button>
            </div>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    {{-- <button onclick="changeTab('base')" class="inline-block p-4 border-b-2 rounded-t-md {{ $activeTab === 'base' ? 'border-blue-500' : '' }}" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="{{ $activeTab === 'base' ? 'true' : 'false' }}">基本情報</button> --}}
                    <button onclick="changeTab('base')" class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" >すべて</button>
                </li>
                <li class="mr-2" role="presentation">
                    {{-- <button onclick="changeTab('credit')" class="inline-block p-4 border-b-2 rounded-t-md {{ $activeTab === 'credit' ? 'border-blue-500' : '' }}" id="credit-tab" data-tabs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="{{ $activeTab === 'credit' ? 'true' : 'false' }}">与信情報</button> --}}
                    <button onclick="changeTab('credit')" class="inline-block p-4 border-b-2 rounded-t-md" id="credit-tab" data-tabs-target="#credit" type="button" role="tab" aria-controls="credit" >システム通知</button>
                </li>
                <li class="mr-2" role="presentation">
                    {{-- <button onclick="changeTab('credit')" class="inline-block p-4 border-b-2 rounded-t-md {{ $activeTab === 'credit' ? 'border-blue-500' : '' }}" id="credit-tab" data-tabs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="{{ $activeTab === 'credit' ? 'true' : 'false' }}">与信情報</button> --}}
                    <button onclick="changeTab('credit')" class="inline-block p-4 border-b-2 rounded-t-md" id="message-tab" data-tabs-target="#message" type="button" role="tab" aria-controls="message" >メッセージ</button>
                </li>
            </ul>
        </div>

        {{-- <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md  dark:text-gray-900 mt-4"> --}}
            <div class="flex flex-col items-center justify-between pb-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                <!-- ヘッダ：検索欄 -->
                <div class="w-full">
                    <form method="GET" action="{{ route('corporations.index') }}" id="search_form" class="flex items-center">
                        @csrf
                        <div class="flex flex-col md:flex-row w-full">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="search" id="corporation_num" name="corporation_num" value="" class="block w-full p-2 pl-10 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" placeholder="キーワード/カテゴリ（セレクト）/既読も含む（トグル）">
                            </div>
    
                            <div class="flex mt-2 md:mt-0">
                                <div class="flex flex-col justify-end  w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                                    <div class="flex mt-4 md:mt-0">
                                        <!-- 検索ボタン -->
                                        <x-buttons.search-button />
                                        <!-- リセットボタン -->
                                        {{-- <x-buttons.reset-button /> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        {{-- </div> --}}

        <!-- 基本情報タブ -->
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-3 py-3">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-1 py-3 ">
                                
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                タイトル
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                通知元
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                種別
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                通知日時
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                重要度
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                詳細
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-3">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td class="px-1 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if (!$notification->read_at)
                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>                                     
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                {{ Str::limit($notification->data['notification_data']['notification_title'] ?? 'No Message', 100) }}
                            </td>
                            <th scope="row" class="flex items-center px-3 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($notification->data['notification_from']['id'])
                                    <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $notification->data['notification_from']['image']) }}?{{ time() }}" alt="">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-500"></div>
                                @endif
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{ $notification->data['notification_from']['name'] }}</div>
                                </div>

                            </th>
                            <td class="px-3 py-2 whitespace-nowrap">
                                システム通知
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <span>{{ $notification->created_at->format('n月j日 H:i') }}</span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> 通常
                                </div>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <!-- Modal toggle -->
                                <button type="button" data-modal-target="detail-{{$notification->id}}" data-modal-show="detail-{{$notification->id}}" class="" tabindex="-1">
                                    <div class="flex items-center">
                                        <span class="font-medium text-blue-600 dark:text-blue-500 hover:underline">詳細確認</span>
                                    </div>
                                </button>
                            </td>
                        </tr>


                        <!-- 詳細モーダル -->
                        <div id="detail-{{ $notification->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-2xl max-h-full">
                                <div class="relative bg-white rounded shadow dark:bg-gray-700">
                                    <div class="p-6 text-center">
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">{{ Str::limit($notification->data['notification_data']['notification_title'] ?? 'No Message', 100) }}</h3>
                                        <div class="flex justify-center">
                                            <!-- Modal body -->
                                            <div class="p-6 space-y-6">
                                                    {{-- @if (!$notification->read_at)
                                                        <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="text-blue-400 hover:text-blue-300">既読にする</button>
                                                        </form>
                                                    @endif --}}
                                                    <a href="{{ $notification->data['notification_data']['action_url'] }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">見に行く</a>
                                            </div>
                                            <!-- Modal footer -->
                                            {{-- <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save all</button>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </table>

            </div>
        </div>

        <!-- 与信情報タブ -->
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="credit" role="tabpanel" aria-labelledby="credit-tab">
            営業報告、サポート履歴、営業報告コメント、申請通知、承認通知、預託期限リマインド、（通常メッセージ）※一括既読機能、詳細画面から既読ボタンで既読
        </div>





        <!-- 基本情報タブ -->
        <div class="hidden p-2 pb-4 rounded bg-gray-50 dark:bg-gray-800" id="message" role="tabpanel" aria-labelledby="message-tab">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-3 py-3">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-1 py-3 ">
                                
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                タイトル
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                通知元
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                種別
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                通知日時
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                重要度
                            </th>
                            <th scope="col" class="px-3 py-3 whitespace-nowrap">
                                詳細
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-3">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td class="px-1 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if (!$notification->read_at)
                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>                                     
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                {{ Str::limit($notification->data['notification_data']['notification_title'] ?? 'No Message', 100) }}
                                {{-- {{ $notification->data['notification_data']['content_title'] ?? 'No Title' }} --}}
                            </td>
                            <th scope="row" class="flex items-center px-3 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="Jese image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">Neil Sims</div>
                                </div>
                                <div class="flex-shrink-0">
                                    {{-- @if ($notification->data['content_data']['reporter']['user_name'])
                                        <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $notification->data['content_data']['reporter']['profile_image']) }}?{{ time() }}" alt="">
                                        {{ asset('storage/' . Auth::user()->profile_image) }}?{{ time() }}
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-500"></div>
                                    @endif --}}
                                </div>
                                <div>
                                    {{-- {{ $notification->data['content_data']['reporter']['user_name'] }} --}}
                                </div>

                            </th>
                            <td class="px-3 py-2 whitespace-nowrap">
                                システム通知
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <span>{{ $notification->created_at->format('n月j日 H:i') }}</span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> 通常
                                </div>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <!-- Modal toggle -->
                                <button type="button" data-modal-target="detail-{{$notification->id}}" data-modal-show="detail-{{$notification->id}}" class="" tabindex="-1">
                                    <div class="flex items-center">
                                        {{-- <svg aria-hidden="true" class="w-[17px] h-[17px] mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> --}}
                                        <span class="font-medium text-blue-600 dark:text-blue-500 hover:underline">詳細確認</span>
                                    </div>
                                </button>
                            </td>
                        </tr>


                        <!-- 詳細モーダル -->
                        <div id="detail-{{ $notification->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-2xl max-h-full">
                                <div class="relative bg-white rounded shadow dark:bg-gray-700">
                                    <div class="p-6 text-center">
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">{{ Str::limit($notification->data['notification_data']['message'] ?? 'No Message', 100) }}</h3>
                                        <div class="flex justify-center">
                                            <!-- Modal body -->
                                            <div class="p-6 space-y-6">
                                                    {{-- @if (!$notification->read_at)
                                                        <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="text-blue-400 hover:text-blue-300">既読にする</button>
                                                        </form>
                                                    @endif --}}
                                            </div>
                                            <!-- Modal footer -->
                                            {{-- <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save all</button>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>