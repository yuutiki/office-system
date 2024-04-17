<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editCorporation', $corporation, $searchParams) }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
            <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                    {{-- <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                    </li> --}}
                    <li>
                        <button type="button" data-modal-target="deleteModal-{{$corporation->id}}" data-modal-show="deleteModal-{{$corporation->id}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full dark:text-red-500">
                            <div class="flex">
                                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span class="">削除</span>
                            </div>
                        </button>
                    </li>
                </ul>
                {{-- <div class="py-2">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Separated link</a>
                </div> --}}
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


            <div class="relative z-0">
                <input type="text" id="corporation_num" value="{{old('corporation_num',$corporation->corporation_num)}}" class="block text-lg px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                <label for="corporation_num" name="corporation_num" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">法人番号</label>
            </div>

            <div class="w-full flex flex-col">
                <label for="corporation_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人名称<span class="text-red-500"> *</span></label>
                <input type="text" form="corporationForm" name="corporation_name" class="input-secondary" id="corporation_name" value="{{old('corporation_name',$corporation->corporation_name)}}" placeholder="学校法人 烏丸学園">
                @error('corporation_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div  class="w-full flex flex-col">
                    <label for="corporation_kana_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人カナ名称<span class="text-red-500"> *</span></label>
                    <input type="text" form="corporationForm" name="corporation_kana_name" class="input-secondary" id="corporation_kana_name" value="{{old('corporation_kana_name',$corporation->corporation_kana_name)}}" placeholder="ガッコウホウジン カラスマガクエン">
                </div>
                @error('corporation_kana_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div class="w-full flex flex-col">
                    <label for="corporation_short_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人略称<span class="text-red-500"> *</span></label>
                    <input type="text" form="corporationForm" name="corporation_short_name" id="corporation_short_name" value="{{old('corporation_short_name',$corporation->corporation_short_name)}}" class="input-secondary" placeholder="烏丸学園">
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
                            <input type="text" form="corporationForm" name="invoice_num" id="invoice_num" value="{{old('invoice_num',$corporation->invoice_num)}}" class="input-primary" placeholder="T123456789123">
                        </div>

                        {{-- APIRequest用のボタン --}}
                        <button type="button" id="invoiceApi" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[34px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
                        <input type="date" min="1900-01-01" max="2200-12-31" form="corporationForm" name="invoice_at" id="invoice_at" value="{{old('invoice_at',$corporation->invoice_at)}}" class="input-primary">
                    </div>
                    @error('invoice_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 mb-4 sm:grid-cols-5 mt-4">
                <div class="w-full flex flex-col">
                    <label for="corporation_post_code" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1" autocomplete="new-password">郵便番号</label>
                    <div class="relative w-full">
                        <input type="text" form="corporationForm" name="corporation_post_code" class="input-primary" id="corporation_post_code" value="{{old('corporation_post_code',$corporation->corporation_post_code)}}" placeholder="">
                        <button type="button" id="ajaxzip3" data-form="corporationForm" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-[35px] text-white mt-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 zip2addr-trigger">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="corporation_prefecture_id" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1">都道府県</label>
                    <select id="corporation_prefecture_id" form="corporationForm" name="corporation_prefecture_id" class="input-primary">
                        <option selected value="">未選択</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}" @if( $prefecture->id == old('corporation_prefecture_id',$corporation->corporation_prefecture_id) ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full flex flex-col sm:col-span-3">
                    <label for="corporation_address1" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1">所在地</label>
                    <input type="text" form="corporationForm" name="corporation_address1" id="corporation_address1" value="{{old('corporation_address1',$corporation->corporation_address1)}}" class="input-primary" placeholder="">
                </div>
            </div>

            <div>
                <div class="w-full flex flex-col">
                    <label for="corporation_memo" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人備考</label>
                    <textarea name="corporation_memo" form="corporationForm" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="corporation_memo" data-auto-resize="true" cols="30" rows="5" placeholder="">{{old('corporation_memo',$corporation->corporation_memo)}}</textarea>
                </div>
                @error('corporation_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="w-auto flex flex-col mt-6">

                {{-- <input type="checkbox" form="corporationForm" value="0" name="is_stop_trading" class="hidden"> --}}

                <label class="flex items-center me-5 cursor-pointer w-36">
                    @if ($corporation->is_stop_trading)
                    <input type="checkbox" form="corporationForm" value="1" checked name="is_stop_trading" id="is_stop_trading" class="sr-only peer">
                    @else
                    <input type="checkbox" form="corporationForm" value="1" name="is_stop_trading" id="is_stop_trading" class="sr-only peer">
                    @endif

                    {{-- <input type="checkbox" form="corporationForm" value="1" @if (old('is_stop_trading',$corporation->is_stop_trading)) checked @endif name="is_stop_trading" id="is_stop_trading" class="sr-only peer"> --}}
                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">取引停止</span>


                    <button data-tooltip-target="tooltip-right" data-tooltip-placement="right" type="button" class="ms-3 mb-2 md:mb-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-1.5 py-[1px] text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        ?
                    </button>
                    <div id="tooltip-right" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-1.5 text-sm font-medium text-white bg-gray-900 rounded-xl shadow-sm opacity-0 tooltip dark:bg-gray-600">
                        <span class="text-xs">
                            取引停止中は検索時に
                            <br>
                            非表示になります。
                        </span>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </label>
            </div>

            <div>
                <div class="w-full flex flex-col">
                    <label for="stop_trading_reason" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">取引停止理由</label>
                    <input type="text" form="corporationForm" name="stop_trading_reason" id="stop_trading_reason" value="{{ old('stop_trading_reason',$corporation->stop_trading_reason) }}" class="input-primary" disabled>
                </div>
                @error('stop_trading_reason')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            
            <form method="post" action="{{route('corporations.update',$corporation)}}" enctype="multipart/form-data" id="corporationForm">
                @csrf
                @method('patch')
                @can('storeUpdate_corporations')
                    <x-primary-button class="mt-4" form-id="corporationForm" id="saveButton" onkeydown="stopTab(event)">
                        保存(S)
                    </x-primary-button>
                @endcan
            </form>
        </div>

        {{-- 与信情報タブ --}}
        <div class="hidden md:p-4 p-2 rounded bg-gray-50 dark:bg-gray-800" id="credit" role="tabpanel" aria-labelledby="credit-tab">
            <div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="credit_limit" class="dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">更新額</label>
                        <input type="text" form="corporationForm" onblur="formatNumberInput(this);" name="credit_limit" id="credit_limit" value="{{old('credit_limit',$corporation->credit_limit)}}" class="input-primary" placeholder="">
                    </div>
                    @error('credit_limit')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="credit_limit_reason" class="dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">評価点（リスク）</label>
                        <input type="text" form="corporationForm" name="credit_limit_reason" id="credit_limit_reason" value="{{old('credit_limit_reason')}}" class="input-primary" placeholder="">
                    </div>
                    @error('credit_limit_reason')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="credit_limit_reason" class="dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">評価者（外部/内部）</label>
                        <input type="text" form="corporationForm" name="credit_limit_reason" id="credit_limit_reason" value="{{old('credit_limit_reason')}}" class="input-primary" placeholder="">
                    </div>
                    @error('credit_limit_reason')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="credit_limit_reason" class="dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">根拠</label>
                        <input type="text" form="corporationForm" name="credit_limit_reason" id="credit_limit_reason" value="{{old('credit_limit_reason')}}" class="input-primary" placeholder="">
                    </div>
                    @error('credit_limit_reason')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>

                <div class="relative overflow-x-auto mt-8">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                            <tr>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center w-40">
                                    更新日時
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center w-40">
                                    更新後与信額
                                </th>
                                <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600 text-center w-40">
                                    更新者
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    根拠
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($users as $user) --}}
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                                <td class="px-6 py-2 whitespace-nowrap border border-gray-600">
                                    {{ '2024-04-01' }}
                                </td>
                                <td class="px-2 py-2 text-right border border-gray-600">
                                    {{ '10,000,000' }}
                                </td>
                                <td class="px-2 py-2 text-center border border-gray-600">
                                    {{ Auth()->user()->last_name }}
                                </td>
                                <td class="px-2 py-2 border border-gray-600">
                                    {{ '大学なので標準です' }}
                                </td>
                                <td class="text-center border border-gray-600">
                                    {{-- <form method="post" action="{{ route('group.delete_user') }}">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="role_group_id" value="{{ $roleGroup->id }}">
                                        <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm1-7a1 1 0 01-2 0V7a1 1 0 012 0v2z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>


                <div class="h-[350px]">
                    <span class="hidden">ダミー</span>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal-{{$corporation->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <button data-modal-hide="deleteModal-{{$corporation->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                    <div class="flex justify-center">
                        <form action="{{route('corporations.destroy',$corporation->id)}}" method="POST" class="">
                            @csrf
                            @method('delete')
                            <button type="submit" data-modal-hide="deleteModal-{{$corporation->id}}" class="text-white  bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                削除
                            </button>
                        </form>
                        <button data-modal-hide="deleteModal-{{$corporation->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            やっぱやめます
                        </button>
                    </div>
                </div>
            </div>
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
    {{-- <script type="text/javascript" src="{{ asset('/assets/js/main.js') }}"></script> --}}

</x-app-layout>