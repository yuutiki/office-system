<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createCorporation') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">基本情報</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="credit-tab" data-tabs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="false">与信情報</button>
                </li>
            </ul>
        </div>
        
        {{-- <div id="myTabContent"> --}}
            <div class="hidden md:p-4 p-2 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                <div class="w-full flex flex-col">
                    <label for="corporation_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人名称</label>
                    <input type="text" form="corporationForm" name="corporation_name" class="input-primary" id="corporation_name" value="{{old('corporation_name')}}" placeholder="学校法人 烏丸学園">
                    @error('corporation_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div  class="w-full flex flex-col">
                        <label for="corporation_kana_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人カナ名称</label>
                        <input type="text" form="corporationForm" name="corporation_kana_name" class="input-primary" id="corporation_kana_name" value="{{old('corporation_kana_name')}}" placeholder="ガッコウホウジン カラスマガクエン">
                    </div>
                    @error('corporation_kana_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="corporation_short_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人略称</label>
                        <input type="text" form="corporationForm" name="corporation_short_name" id="corporation_short_name" value="{{old('corporation_short_name')}}" class="input-primary" placeholder="烏丸学園">
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

                <div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="dark:text-gray-100 text-gray-900 leading-none mt-4">備考</label>
                        <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="memo" data-auto-resize="true"  cols="30" rows="5" placeholder="法人に関するメモ...">{{old('memo')}}</textarea>
                    </div>
                    @error('memo')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>

                <div class="w-auto flex flex-col mt-6">
                    <label class="flex items-center me-5 cursor-pointer w-36">
                        <input type="checkbox" form="corporationForm" value="" name="is_stop_trading" id="is_stop_trading" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">取引停止</span>
                        <button data-tooltip-target="tooltip-right" data-tooltip-placement="right" type="button" class="ms-3 mb-2 md:mb-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-1.5 py-[1px] text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            ?
                        </button>
                        <div id="tooltip-right" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-1.5 text-sm font-medium text-white bg-gray-900 rounded-xl shadow-sm opacity-0 tooltip dark:bg-gray-600">
                            <span class="text-xs">
                                取引停止中は検索時に非表示になります。
                            </span>
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </label>
                </div>

                <div>
                    <div class="w-full flex flex-col">
                        <label for="stop_trading_reason" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">取引停止理由</label>
                        <input type="text" form="corporationForm" name="stop_trading_reason" id="stop_trading_reason" value="{{old('stop_trading_reason')}}" class="input-primary" disabled>
                    </div>
                    @error('stop_trading_reason')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                
                <form id="corporationForm" method="post" action="{{route('corporations.store')}}" enctype="multipart/form-data">
                    @csrf
                    <x-primary-button class="mt-4" form-id="corporationForm" id="saveButton" onkeydown="stopTab(event)">
                        保存(S)
                    </x-primary-button>
                </form>
            </div>


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
            </div>

        {{-- </div> --}}
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
                // 入力フィールドの背景色とテキストの色を元に戻す
                stopTradingReasonField.style.setProperty('background-color', '', 'important');
                stopTradingReasonField.style.setProperty('color', '', 'important');
            } else {
                // チェックされていない場合、取引停止理由の入力フィールドを無効化し、値をクリア
                stopTradingReasonField.disabled = true;
                stopTradingReasonField.value = '';
                // 入力フィールドの背景色をグレーに設定し、テキストの色を調整する
                stopTradingReasonField.style.setProperty('background-color', '#f2f2f2', 'important');
                stopTradingReasonField.style.setProperty('color', '#666', 'important');
            }
        });
    </script>

    <script>
        // 新規登録ボタンにフォーカスが当たった時に呼び出される関数
        function stopTab(event) {
            if (event.keyCode === 9 && !event.shiftKey) { // タブキーが押された場合かつShiftキーが押されていない場合
                event.preventDefault(); // イベントをキャンセルする
            }
        }
    </script>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/main.js') }}"></script>

</x-app-layout>