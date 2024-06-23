<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createCorporation', $searchParams) }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />

                <form method="post" action="{{ route('corporations.store') }}" enctype="multipart/form-data" id="corporationForm" class="flex items-center">
                    @csrf
                    @can('storeUpdate_corporations')
                        <x-button-save form-id="corporationForm" id="saveButton" onkeydown="stopTab(event)">
                            <span class="ml-1 hidden md:inline text-sm">保存</span>
                        </x-button-save>
                    @endcan
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">基本情報</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="credit-tab" data-tabs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="false">与信情報</button>
                </li>
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">

            <div class="w-full flex flex-col">
                <label for="corporation_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人名称<span class="text-red-500"> *</span></label>
                <input type="text" form="corporationForm" name="corporation_name" class="input-secondary" id="corporation_name" value="{{old('corporation_name')}}" placeholder="学校法人 烏丸学園">
                @error('corporation_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div  class="w-full flex flex-col">
                    <label for="corporation_kana_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人カナ名称<span class="text-red-500"> *</span></label>
                    <input type="text" form="corporationForm" name="corporation_kana_name" class="input-secondary" id="corporation_kana_name" value="{{old('corporation_kana_name')}}" placeholder="ガッコウホウジン カラスマガクエン">
                </div>
                @error('corporation_kana_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div class="w-full flex flex-col">
                    <label for="corporation_short_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人略称<span class="text-red-500"> *</span></label>
                    <input type="text" form="corporationForm" name="corporation_short_name" id="corporation_short_name" value="{{old('corporation_short_name')}}" class="input-secondary" placeholder="烏丸学園">
                </div>
                @error('corporation_short_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-2 mt-6">
                <div>
                    <div class="flex">
                        <div class="w-full flex flex-col">
                            <label for="invoice_num" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">インボイス番号</label>
                            <input type="text" form="corporationForm" name="invoice_num" id="invoice_num" value="{{old('invoice_num')}}" class="input-primary" placeholder="T123456789123">
                        </div>

                        {{-- APIRequest用のボタン --}}
                        <button type="button" id="invoiceApi" class="p-2.5 text-sm font-medium h-[34px] text-white mt-[34px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                    @error('invoice_num')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="invoice_at" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">インボイス登録日</label>
                        <input type="date" min="1900-01-01" max="2200-12-31" form="corporationForm" name="invoice_at" id="invoice_at" value="{{old('invoice_at')}}" class="input-primary">
                    </div>
                    @error('invoice_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 mb-4 sm:grid-cols-5 mt-4">
                <div class="flex">
                    <div class="w-full flex flex-col">
                        <label for="corporation_post_code" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1" autocomplete="new-password">郵便番号</label>
                        <input type="text" form="corporationForm" name="corporation_post_code" class="input-primary" id="corporation_post_code" value="{{old('corporation_post_code')}}" placeholder="">
                    </div>
                    <button type="button" id="ajaxzip3" data-form="corporationForm" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[21px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>

                <div class="w-full flex flex-col">
                    <label for="corporation_prefecture_id" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1">都道府県</label>
                    <select id="corporation_prefecture_id" form="corporationForm" name="corporation_prefecture_id" class="input-primary">
                        <option selected value="">未選択</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}" @if( $prefecture->id == old('corporation_prefecture_id') ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full flex flex-col sm:col-span-3">
                    <label for="corporation_address1" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1">所在地</label>
                    <input type="text" form="corporationForm" name="corporation_address1" id="corporation_address1" value="{{old('corporation_address1')}}" class="input-primary" placeholder="">
                </div>
            </div>

            <div>
                <div class="w-full flex flex-col">
                    <label for="corporation_memo" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人備考</label>
                    <textarea name="corporation_memo" form="corporationForm" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="corporation_memo" data-auto-resize="true" cols="30" rows="5" placeholder="">{{old('corporation_memo')}}</textarea>
                </div>
                @error('corporation_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="w-auto flex flex-col mt-6">
                <label class="flex items-center me-5 cursor-pointer w-30">
                    <input type="checkbox" form="corporationForm" value="1" @if (old('is_stop_trading')) checked @endif name="is_stop_trading" id="is_stop_trading" class="sr-only peer">
                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">取引停止</span>
                    <button data-tooltip-target="tooltip-right" data-tooltip-placement="right" type="button" class="ms-3 mb-2 md:mb-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-1.5 py-[1px] text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        ?
                    </button>
                    <div id="tooltip-right" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-1.5 text-sm font-medium text-white bg-gray-900 rounded-xl shadow-sm opacity-0 tooltip dark:bg-gray-600">
                        <span class="text-xs">
                            取引停止中は検索結果に
                            <br>
                            表示されなくなります。
                        </span>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </label>
            </div>

            <div>
                <div class="w-full flex flex-col">
                    <label for="stop_trading_reason" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">取引停止理由</label>
                    <input type="text" form="corporationForm" name="stop_trading_reason" id="stop_trading_reason" value="{{ old('stop_trading_reason') }}" class="input-primary" disabled>
                </div>
                @error('stop_trading_reason')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
        </div>

        {{-- 与信情報タブ --}}
        <div class="hidden md:p-4 p-2 rounded bg-gray-50 dark:bg-gray-800" id="credit" role="tabpanel" aria-labelledby="credit-tab">
            <div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="credit_limit" class="dark:text-gray-100 text-gray-900 leading-none mt-4">与信限度額</label>
                        <input type="text" form="corporationForm" onblur="formatNumberInput(this);" name="credit_limit" id="credit_limit" value="{{old('credit_limit',0)}}" class="input-primary" placeholder="">
                    </div>
                    @error('credit_limit')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="h-[550px]">
                    <span class="hidden">ダミー</span>
                </div>
            </div>

    <!-- タブ -->
    <ul id="tabList">
        <li><a href="#tab1" data-tab="tab1">Tab 1</a></li>
        <li><a href="#tab2" data-tab="tab2">Tab 2</a></li>
        <li><a href="#tab3" data-tab="tab3">Tab 3</a></li>
    </ul>

    <!-- タブコンテンツ -->
    <div id="tabContent">
        <div class="tab-content hidden" id="tab1">Tab 1 content</div>
        <div class="tab-content hidden" id="tab2">Tab 2 content</div>
        <div class="tab-content hidden" id="tab3">Tab 3 content</div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var tabs = document.querySelectorAll('[data-tab]');
        var tabContents = document.querySelectorAll('.tab-content');

        // URLのクエリパラメータを解析して、初期状態のタブを設定
        var urlParams = new URLSearchParams(window.location.search);
        var activeTab = urlParams.get('tab');
        if (activeTab) {
            var tabContent = document.getElementById(activeTab);
            if (tabContent) {
                tabContent.classList.remove('hidden');
            }
        }

        // タブがクリックされたときの処理
        tabs.forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                event.preventDefault();
                var tabId = this.getAttribute('data-tab');
                showTab(tabId);
                // URLを更新して状態を反映
                var state = { tab: tabId };
                history.pushState(state, '', '?tab=' + tabId);
            });
        });

        // ブラウザの戻るボタンで状態を更新する処理
        window.onpopstate = function(event) {
            var tabId = event.state ? event.state.tab : null;
            if (tabId) {
                showTab(tabId);
            }
        };

        // タブを表示する関数
        function showTab(tabId) {
            tabContents.forEach(function(tabContent) {
                if (tabContent.id === tabId) {
                    tabContent.classList.remove('hidden');
                } else {
                    tabContent.classList.add('hidden');
                }
            });
        }
    });
    </script>
        </div>
    </div>


    <script>
        // チェックボックスの要素を取得
        const isStopTradingCheckbox = document.getElementById('is_stop_trading');
        // 取引停止理由の入力フィールドを取得
        const stopTradingReasonField = document.getElementById('stop_trading_reason');

        // チェックボックスの状態が変更されたときのイベントリスナーを追加
        isStopTradingCheckbox.addEventListener('change', function() {
        // チェックボックスがチェックされているかどうかを確認
        if (this.checked) {
            // チェックされている場合、取引停止理由の入力フィールドを有効化
            stopTradingReasonField.disabled = false;
            stopTradingReasonField.style.backgroundColor = ''; 
        } else {
            // チェックされていない場合、取引停止理由の入力フィールドを無効化
            stopTradingReasonField.disabled = true;
            stopTradingReasonField.style.backgroundColor = 'rgba(107, 114, 128, 1)'; 
        }
        });

        // ページ読み込み時に、チェックボックスの状態に基づいて入力フィールドを有効/無効化
        if (isStopTradingCheckbox.checked) {
            stopTradingReasonField.disabled = false;
            stopTradingReasonField.style.backgroundColor = ''; 
        } else {
            stopTradingReasonField.disabled = true;
            stopTradingReasonField.style.backgroundColor = 'rgba(107, 114, 128, 1)'; 

        }
    </script>


    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/addresssearchbutton.js') }}"></script>
</x-app-layout>