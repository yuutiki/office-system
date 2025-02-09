<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editCorporation', $corporation, $searchParams) }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />
                <div class="flex justify-between">
                    @if ($prevId)
                        <a href="{{ route('corporations.edit', ['corporation' => $prevId]) }}" class="px-2 py-2 dark:bg-gray-600 rounded">
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/>
                            </svg>
                        </a>
                    @endif
                
                    @if ($nextId)
                        <a href="{{ route('corporations.edit', ['corporation' => $nextId]) }}" class="px-2 py-2 ml-2 dark:bg-gray-600 rounded">
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                            </svg>
                        </a>
                    @endif
                </div>
                <form method="post" action="{{ route('corporations.update', $corporation) }}" enctype="multipart/form-data" id="corporationForm" class="flex items-center">
                    @csrf
                    @method('put')
                    @can('storeUpdate_corporations')
                        <x-button-save form-id="corporationForm" id="saveButton" onkeydown="stopTab(event)">
                            {{ __("Update") }}
                        </x-button-save>
                    @endcan
                </form>

                <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-600" type="button">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </button>
            </div>

            <!-- Dropdown menu -->
            <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                    <li>
                        <button type="button" data-modal-target="deleteModal-{{$corporation->id}}" data-modal-show="deleteModal-{{$corporation->id}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full dark:text-red-500">
                            <div class="flex">
                                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span class="font-semibold">削除</span>
                            </div>
                        </button>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新日：{{ $corporation->updated_at }}</span>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新者：{{ $corporation->updatedBy->user_name }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button onclick="changeTab('base')" class="inline-block p-4 border-b-2 rounded-t-md {{ $activeTab === 'base' ? 'border-blue-500' : '' }}" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="{{ $activeTab === 'base' ? 'true' : 'false' }}">基本情報</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button onclick="changeTab('credit')" class="inline-block p-4 border-b-2 rounded-t-md {{ $activeTab === 'credit' ? 'border-blue-500' : '' }}" id="credit-tab" data-tabs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="{{ $activeTab === 'credit' ? 'true' : 'false' }}">与信情報</button>
                </li>
            </ul>
        </div>

        <!-- 基本情報タブ -->
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">
            <div class="relative z-0 mt-2">
                <input type="text" id="corporation_num" value="{{old('corporation_num',$corporation->corporation_num)}}" class="block text-lg px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                <label for="corporation_num" name="corporation_num" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">法人No.</label>
            </div>
            <div class="w-full flex flex-col">
                <label for="corporation_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人名称<span class="text-red-500"> *</span></label>
                <input type="text" form="corporationForm" name="corporation_name" class="input-secondary" id="corporation_name" value="{{old('corporation_name',$corporation->corporation_name)}}" placeholder="学校法人 烏丸学園">
                @error('corporation_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div class="w-full flex flex-col">
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
            <div class="w-full flex flex-col">
                <label for="corporation_number" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人番号（国税庁）</label>
                <input type="text" form="corporationForm" name="corporation_number" id="corporation_number" value="{{old('corporation_number',$corporation->corporation_number)}}" class="input-primary" placeholder="123456789123">
                @error('corporation_number')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>


            <ul class="grid w-full gap-6 lg:grid-cols-3 mt-12">
                <li>
                    <input type="radio" form="corporationForm" id="unconfirmed" name="tax_status" value="0" class="peer sr-only" {{ $corporation->tax_status == 0 ? 'checked' : '' }} required tabindex="-1">
                    <label for="unconfirmed" tabindex="0" role="radio" aria-checked="{{ $corporation->tax_status == 0 ? 'true' : 'false' }}" class="inline-flex items-center justify-center w-full px-5 py-3 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer dark:hover:text-gray-300 dark:border-indigo-700 dark:peer-checked:text-white dark:peer-checked:bg-indigo-700 peer-checked:border-indigo-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">                           
                        <div class="block">
                            <div class="w-full text-md">未確認</div>
                        </div>
                    </label>
                </li>
                <li>
                    <input type="radio" form="corporationForm" id="tax_payer" name="tax_status" value="1" class="peer sr-only" {{ $corporation->tax_status == 1 ? 'checked' : '' }} tabindex="-1">
                    <label for="tax_payer" tabindex="0" role="radio" aria-checked="{{ $corporation->tax_status == 1 ? 'true' : 'false' }}" class="inline-flex items-center justify-center w-full px-5 py-3 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer dark:hover:text-gray-300 dark:border-indigo-700 dark:peer-checked:text-white dark:peer-checked:bg-indigo-700 peer-checked:border-indigo-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <div class="block">
                            <div class="w-full text-md">課税事業者</div>
                        </div>
                    </label>
                </li>
                <li>
                    <input type="radio" form="corporationForm" id="tax_exempt" name="tax_status" value="2" class="peer sr-only" {{ $corporation->tax_status == 2 ? 'checked' : '' }} tabindex="-1">
                    <label for="tax_exempt" tabindex="0" role="radio" aria-checked="{{ $corporation->tax_status == 2 ? 'true' : 'false' }}" class="inline-flex items-center justify-center w-full px-5 py-3 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer dark:hover:text-gray-300 dark:border-indigo-700 dark:peer-checked:text-white dark:peer-checked:bg-indigo-700 peer-checked:border-indigo-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <div class="block">
                            <div class="w-full text-md">免税事業者</div>
                        </div>
                    </label>
                </li>
            </ul>

            @error('tax_status')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <div class="flex">
                        <div class="w-full flex flex-col relative"> <!-- relative クラスを追加 -->
                            <label for="invoice_num" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">インボイス番号</label>
                            <input type="text" form="corporationForm" name="invoice_num" id="invoice_num" value="{{ old('invoice_num', $corporation->invoice_num) }}" class="input-primary pr-10" placeholder="T123456789123">
                            <!-- インボイス番号の有効チェックマーク -->
                            @if ($corporation->invoice_num && $corporation->is_active_invoice)
                            <span class="absolute right-2 top-10 inline-flex items-center justify-center w-5 h-5 text-sm font-semibold text-white bg-green-500 rounded-full dark:bg-green-500">
                                <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M1 5.917 5.724 10.5 15 1.5"/>
                                </svg>
                            </span>
                            @endif
                        </div>

                        {{-- APIRequest用のボタン --}}
                        {{-- <button type="button" id="invoiceApi" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[34px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none  dark:bg-blue-600 dark:hover:bg-blue-700  dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button> --}}
                    </div>
                    @error('invoice_num')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror

                    @if ($corporation->invoice_num && !$corporation->is_active_invoice)
                        <div class="text-red-500">無効なインボイス番号です。</div>
                    @endif

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

            <div class="grid gap-4 md:grid-cols-5 mb-4 mt-4">
                <div class="flex">
                    <div class="w-full flex flex-col">
                        <label for="corporation_post_code" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1" autocomplete="new-password">郵便番号</label>
                        <input type="text" form="corporationForm" name="corporation_post_code" class="input-primary" id="corporation_post_code" value="{{old('corporation_post_code',$corporation->corporation_post_code)}}" placeholder="">
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
                            <option value="{{ $prefecture->id }}" @if( $prefecture->id == old('corporation_prefecture_id',$corporation->corporation_prefecture_id) ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full flex flex-col md:col-span-3">
                    <label for="corporation_address1" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1">所在地</label>
                    <input type="text" form="corporationForm" name="corporation_address1" id="corporation_address1" value="{{old('corporation_address1',$corporation->corporation_address1)}}" class="input-primary" placeholder="">
                </div>
            </div>

            <div>
                <div class="w-full flex flex-col">
                    <label for="corporation_memo" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">法人備考</label>
                    <textarea name="corporation_memo" form="corporationForm" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" id="corporation_memo" data-auto-resize="true" cols="30" rows="5" placeholder="">{{old('corporation_memo',$corporation->corporation_memo)}}</textarea>
                </div>
                @error('corporation_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="w-auto flex flex-col mt-6">

                <label class="flex items-center me-5 cursor-pointer w-36">
                    <input type="checkbox" form="corporationForm" value="1" @checked(old('is_stop_trading', $corporation->is_stop_trading)) name="is_stop_trading" id="is_stop_trading" class="sr-only peer">

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
                    <input type="text" form="corporationForm" name="stop_trading_reason" id="stop_trading_reason" value="{{ old('stop_trading_reason',$corporation->stop_trading_reason) }}" class="input-primary" disabled>
                </div>
                @error('stop_trading_reason')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
        </div>

        <!-- 与信情報タブ -->
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="credit" role="tabpanel" aria-labelledby="credit-tab">
            <div>
                <div class="relative bg-white dark:bg-gray-700 rounded-t md:w-auto shadow-md  dark:text-gray-900 mt-4 border border-gray-600">
                    <div class="flex flex-col justify-end p-2 space-y-1 md:flex-row md:space-y-0 md:space-x-4">

                        <!-- ユーザ検索モーダルを表示するボタン -->
                        <div class="flex flex-col items-stretch flex-shrink-0 w-full md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <button type="button"  onclick="showRoleGroupsSearchModal()" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                {{ __('限度額更新') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-x-auto">
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
                                    評価点
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    評価会社
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    削除
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($credits as $credit)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                                <td class="px-6 py-2 whitespace-nowrap border border-gray-600">
                                    {{ $credit->created_at }}
                                </td>
                                <td class="px-2 py-2 text-right border border-gray-600">
                                    {{ number_format($credit->credit_limit) }}
                                </td>
                                <td class="px-2 py-2 text-center border border-gray-600">
                                    {{ optional($credit->createdBy)->user_name }}
                                </td>
                                <td class="px-2 py-2 border border-gray-600">
                                    {{ $credit->credit_reason }}
                                </td>
                                <td class="px-2 py-2 border border-gray-600">
                                    {{ $credit->credit_rate }}
                                </td>
                                <td class="px-2 py-2 border border-gray-600">
                                    {{ $credit->credit_rater }}
                                </td>
                                <td class="text-center border border-gray-600">
                                    <form method="post" action="{{ route('corporation-credits.destroy', $credit) }}">
                                        @csrf
                                        @method('delete')
                                        {{-- <input type="hidden" name="user_id" value="{{ $user->id }}"> --}}
                                        {{-- <input type="hidden" name="role_group_id" value="{{ $roleGroup->id }}"> --}}
                                        <button type="submit" class="delete-row p-1 text-sm font-medium text-white bg-red-700 rounded border border-red-700 hover:bg-red-800 focus:outline-none dark:bg-red-600 dark:hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" tabindex="-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="h-[300px]">
                    <span class="hidden">ダミー</span>
                </div>
            </div>
        </div>
    </div>





    <!-- 削除モーダル -->
    <div id="deleteModal-{{ $corporation->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                    <div class="flex justify-center">
                        <form action="{{ route('corporations.destroy', $corporation->id) }}" method="POST" class="">
                            @csrf
                            @method('delete')
                            <button type="submit" data-modal-hide="deleteModal-{{ $corporation->id }}" class="text-white  bg-red-600 hover:bg-red-800 focus:outline-none font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 dark:focus:ring-red-500 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                {{ __('delete') }} <!--削除-->
                            </button>
                        </form>
                        <button id="cancelButton-{{ $corporation->id }}" data-modal-hide="deleteModal-{{ $corporation->id }}" type="button" data-modal-cancel class="text-gray-500 bg-white hover:bg-gray-100 focus:outline-none rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            やっぱやめます
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 与信情報更新モーダル（更新といいつつ新規登録） -->
    <div id="creditUpdateModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-5xl">
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- モーダル header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        与信情報更新
                    </h3>

                    <button type="button" onclick="hideCreditUpdateModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- モーダル body -->
                <form method="post" action="{{route('corporation-credits.store')}}" enctype="multipart/form-data" id="creditForm">
                    @csrf
                    <input type="hidden" name="corporation_id" form="creditForm" value="{{ $corporation->id }}">

                    <div class="grid gap-2 sm:grid-cols-5 my-2">
                        <div>
                            <div class="w-full">
                                <label for="credit_limit" class="dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">更新額</label>
                                <input type="text" form="creditForm" onblur="formatNumberInput(this);" name="credit_limit" id="credit_limit" value="{{old('credit_limit', $latestCredit ? $latestCredit->credit_limit : '')}}" class="input-primary text-right" placeholder="" required>
                            </div>
                            @error('credit_limit')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <div class="w-full">
                                <label for="credit_rate" class="dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">評価点</label>
                                <input type="number" min="0" max="100" form="creditForm" name="credit_rate" id="credit_rate" value="{{old('credit_rate', $latestCredit ? $latestCredit->credit_rate : '')}}" class="input-primary text-right" placeholder="" required>
                            </div>
                            @error('credit_rate')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-span-3 mr-2">
                            <div class="w-full">
                                <label for="credit_rater" class="dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">評価者（外部/内部）</label>
                                <input type="text" form="creditForm" name="credit_rater" id="credit_rater" value="{{old('credit_rater', $latestCredit ? $latestCredit->credit_rater : '')}}" class="input-primary" placeholder="" required>
                            </div>
                            @error('credit_rater')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mr-2">
                        <div class="w-full flex flex-col">
                            <label for="credit_reason" class="dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">与信根拠</label>
                            <input type="text" form="creditForm" name="credit_reason" id="credit_reason" value="{{old('credit_reason', $latestCredit ? $latestCredit->credit_reason : '')}}" class="input-primary" placeholder="" required>
                        </div>
                        @error('credit_reason')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- モーダル footer -->
                    <div class="flex items-center p-6 space-x-2 border-t mt-4 border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" form-id="creditForm" id="saveModalButton" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 hidden transition-opacity duration-1000 opacity-0">
                            登録
                        </button>
                        <button type="button" onclick="hideCreditUpdateModal()"  onkeydown="stopTab(event)" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            閉じる
                        </button> 
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- 削除モーダルの設定 -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setupModal('deleteModal-{{ $corporation->id }}', '{{ $corporation->id }}');
    });
</script>


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


    <script>
        const overlay2 = document.getElementById('overlay');
        const modal2 = document.getElementById('creditUpdateModal');

        // 権限グループ検索モーダルを開く関数
        function showRoleGroupsSearchModal() {
            overlay2.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            modal2.classList.remove('hidden');
        }

        // 権限グループ検索モーダルを開く関数
        function hideCreditUpdateModal() {
            //背後の操作不可を解除
            overlay2.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            modal2.classList.add('hidden');
        }
    </script>

    <script>
        function changeTab(tabName) {
            // タブ切り替え時にクエリパラメータを更新してページ遷移を回避
            window.history.pushState({ tab: tabName }, '', `?tab=${tabName}`);

            // 全tab切り替えボタンをfalseにする
            document.querySelectorAll('[role="tab"]').forEach(tabButton => {
                tabButton.setAttribute('aria-selected', 'false');
            });
            // 押下されたtab切り替えボタンのみtrueにする
            document.getElementById(`${tabName}-tab`).setAttribute('aria-selected', 'true');
        }

        function changeTabReload(tabName) {
            // タブ切り替え時にクエリパラメータを更新してページ遷移を回避
            window.history.pushState({ tab: tabName }, '', `?tab=${tabName}`);
            // 画面をリロード
        window.location.reload();

            // ボタンの状態を更新
            document.querySelectorAll('[role="tab"]').forEach(tabButton => {
                tabButton.setAttribute('aria-selected', 'false');
            });
            document.getElementById(`${tabName}-tab`).setAttribute('aria-selected', 'true');
        }

        // ページ読み込み時と履歴操作時にタブの状態を復元する
        window.onload = function() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const activeTab = urlParams.get('tab');
            const tabName = activeTab || 'base';
            changeTab(tabName);
        };

        // ブラウザの戻る・進む操作時にタブの状態を復元する
        window.onpopstate = function(event) {
            if (event.state && event.state.tab) {
                changeTabReload(event.state.tab);
            } else {
                // event.stateがnullまたはtabが存在しない場合はデフォルトのタブを選択する
                changeTabReload('base');
            }
        };
    </script>

    <script>
    // 与信情報更新モーダルのinput要素を監視し、登録ボタンを表示させる
        document.addEventListener('DOMContentLoaded', (event) => {
            const creditLimitInput = document.getElementById('credit_limit');
            const creditRateInput = document.getElementById('credit_rate');
            const creditRaterInput = document.getElementById('credit_rater');
            const creditReasonInput = document.getElementById('credit_reason');
            const saveModalButton = document.getElementById('saveModalButton');

            // 初期状態ではボタンを非表示にする
            saveModalButton.classList.add('hidden', 'transition-opacity', 'duration-1000', 'opacity-0');

            // 初期値を記憶
            const initialValues = {
                credit_limit: creditLimitInput.value,
                credit_rate: creditRateInput.value,
                credit_rater: creditRaterInput.value,
                credit_reason: creditReasonInput.value,
            };

            // 入力フィールドの変更を監視
            const inputs = [creditLimitInput, creditRateInput, creditRaterInput, creditReasonInput];
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    const currentValues = {
                        credit_limit: creditLimitInput.value,
                        credit_rate: creditRateInput.value,
                        credit_rater: creditRaterInput.value,
                        credit_reason: creditReasonInput.value,
                    };
                    // 初期値と現在の値を比較して異なる場合のみボタンを表示
                    const isModified = Object.keys(initialValues).some(key => initialValues[key] !== currentValues[key]);
                    if (isModified) {
                        saveModalButton.classList.remove('hidden', 'opacity-0');
                    } else {
                        saveModalButton.classList.add('hidden', 'opacity-0');
                    }
                });
            });
        });
    </script>

<script>
    // ラジオボタンのタブ移動用
    document.addEventListener('DOMContentLoaded', function() {
        const radioLabels = document.querySelectorAll('label[for^="unconfirmed"], label[for^="tax_payer"], label[for^="tax_exempt"]');
        
        function updateCheckedState(label) {
            const associatedRadio = document.getElementById(label.getAttribute('for'));
            associatedRadio.checked = true;
            label.setAttribute('aria-checked', 'true');
            
            radioLabels.forEach(otherLabel => {
                if (otherLabel !== label) {
                    otherLabel.setAttribute('aria-checked', 'false');
                }
            });
        }

        radioLabels.forEach(label => {
            label.addEventListener('keydown', function(e) {
                if (e.key === ' ' || e.key === 'Enter') {
                    e.preventDefault();
                    updateCheckedState(this);
                }
            });

            label.addEventListener('click', function() {
                updateCheckedState(this);
            });
        });
    });
</script>


    <script src="{{ asset('assets/js/stopTab.js') }}"></script>
    <script src="{{ asset('assets/js/autoresizetextarea.js') }}"></script>
    <script src="{{ asset('assets/js/addresssearchbutton.js') }}"></script>
    <script src="{{ asset('assets/js/modal/delete-modal.js') }}"></script>
    {{-- <script src="{{ asset('/assets/js/main.js') }}"></script> --}}


</x-app-layout>