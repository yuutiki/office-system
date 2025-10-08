<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('createClientContact') }}
            </h2>
            <div class="ml-auto flex justify-end items-center space-x-2">
                <form method="post" action="{{ route('client-contacts.store') }}" enctype="multipart/form-data" id="createForm" class="flex items-center">
                    @csrf
                    @can('storeUpdate_corporations')
                        <x-buttons.save-button form-id="createForm" id="saveButton" onkeydown="stopTab(event)">
                            {{ __('save') }}
                        </x-buttons.save-button>
                    @endcan
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <!-- 顧客検索ボタン(画面小) -->
        <button type="button" onclick="ClientSearchModal.show('clientSearchModal')" class="md:ml-1 md:mt-1 mt-1 mb-4 w-full md:w-auto whitespace-nowrap md:hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            顧客検索
        </button>


        <div class="mx-auto my-4 rounded shadow-md overflow-hidden border border-gray-200 dark:border-gray-600">
            <table class="w-full text-sm text-left divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <tbody>
                    
                    <div class="hidden">
                        <label for="client_id">顧客ID（非表示）</label>
                        <input type="hidden" form="createForm" name="client_id" id="client_id" value="{{ old('client_id') }}">
                    </div>
                    <!-- 顧客No. -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:py-0.5  md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800">
                            <div class="flex items-center justify-between">
                                <span>顧客No.</span>
                                <button type="button" onclick="ClientSearchModal.show('clientSearchModal')"  data-form="createForm"
                                    class="ml-2 p-1.5 text-sm font-medium h-[30px] text-white bg-blue-700 rounded border border-blue-700 
                                        hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700
                                        dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 
                                        focus:ring-offset-2 dark:focus:ring-offset-gray-800 hidden md:block">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1.5 md:px-2 md:py-1">
                            <input type="text" form="createForm" name="client_num" id="client_num" value="{{ old('client_num') }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 @error('client_id') input-error @enderror" placeholder="" readonly tabindex="-1">
                        </td>
                    </tr>
                    
                    <!-- 顧客名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-48">
                            顧客名称
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1 md:px-2 md:py-1">
                            <input type="text" form="createForm" name="client_name" id="client_name" value="{{ old('client_name') }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 @error('client_id') input-error @enderror" placeholder="" readonly tabindex="-1">
                        </td>
                    </tr>
                    
                    <!-- 管轄部門 -->
                    <tr class=" dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800">
                            管轄部門
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1 md:px-2 md:py-1">
                            <input type="text" form="createForm" name="department" id="department" value="{{ old('department') }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 @error('client_id') input-error @enderror" placeholder="" readonly tabindex="-1">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @error('client_id')
            <div class="validate-message">{{ $message }}</div>
        @enderror




        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">基本情報</button>
                </li>
                {{-- <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="credit-tab" data-tabs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="false">与信情報</button>
                </li> --}}
            </ul>
        </div>
        
        <!-- 基本情報タブ -->
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">

            <div class="mt-8">
                <span class="dark:text-white">担当者情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" form="createForm" name="is_retired" id="is_retired" value="1" @checked(old('is_retired') == 1) class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">退職フラグ</span>
            </label>

            <div class="grid gap-4 sm:grid-cols-2 md:mx-4">
                <div>
                    <div class="w-full flex flex-col">
                        <label for="last_name" class="font-normal text-sm  dark:text-red-500 text-red-700 leading-none md:mt-4">氏名（姓）<span class="text-red-500"> *</span></label>
                        <input type="text" form="createForm" name="last_name" id="last_name" value="{{ old('last_name') }}" class="input-secondary" placeholder="">
                    </div>
                    @error('last_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="first_name" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none md:mt-4">氏名（名）<span class="text-red-500"> *</span></label>
                        <input type="text" form="createForm" name="first_name" id="first_name" value="{{ old('first_name') }}" class="input-secondary" placeholder="">
                    </div>
                    @error('first_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="last_name_kana" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">カナ氏名（姓）<span class="text-red-500"> *</span></label>
                        <input type="text" form="createForm" name="last_name_kana" id="last_name_kana" value="{{ old('last_name_kana') }}" class="input-secondary" placeholder="">
                    </div>
                    @error('last_name_kana')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="first_name_kana" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">カナ氏名（名）<span class="text-red-500"> *</span></label>
                        <input type="text" form="createForm" name="first_name_kana" id="first_name_kana" value="{{ old('first_name_kana') }}" class="input-secondary" placeholder="">
                    </div>
                    @error('first_name_kana')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="division_name" class="font-normal text-sm dark:text-white text-gray-900 leading-none">所属部署名</label>
                        <input type="text" form="createForm" name="division_name" id="division_name" value="{{ old('division_name') }}" class="input-secondary" placeholder="">
                    </div>
                    @error('division_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="position_name" class="font-normal text-sm dark:text-white text-gray-900 leading-none">役職名</label>
                        <input type="text" form="createForm" name="position_name" id="position_name" value="{{ old('position_name') }}" class="input-secondary" placeholder="">
                    </div>
                    @error('position_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-8">
                <span class="dark:text-white">連絡先情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 md:mx-4">
                <div>
                    <div class="w-full flex flex-col">
                        <label for="tel1" class="font-normal text-sm dark:text-white text-gray-900 leading-none">電話番号</label>
                        <input type="text" form="createForm" name="tel1" id="tel1" onchange="validateAndFormat('tel1')" value="{{ old('tel1') }}" class="input-secondary" placeholder="090-1234-5678">
                    </div>
                    @error('tel1')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                {{-- <div class="w-full flex flex-col">
                    <label for="tel2" class="font-normal text-sm dark:text-white text-gray-900 leading-none md:mt-4">電話番号2</label>
                    <input type="text" form="createForm" name="tel2" id="tel2" value="{{ old('tel2') }}" class="input-secondary" placeholder="090-1234-5678">
                </div>
                @error('tel2')
                    <div class="text-red-500">{{$message}}</div>
                @enderror --}}
                <div>
                    <div class="w-full flex flex-col">
                        <label for="fax1" class="font-normal text-sm dark:text-white text-gray-900 leading-none">FAX番号</label>
                        <input type="text" form="createForm" name="fax1" id="fax1" onchange="validateAndFormat('fax1')" value="{{ old('fax1') }}" class="input-secondary" placeholder="090-1234-5678">
                    </div>
                    @error('fax1')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                {{-- <div class="w-full flex flex-col">
                    <label for="fax2" class="font-normal text-sm dark:text-white text-gray-900 leading-none">FAX番号2</label>
                    <input type="text" form="createForm" name="fax2" id="fax2" value="{{ old('fax2') }}" class="input-secondary" placeholder="090-1234-5678">
                </div>
                @error('fax2')
                    <div class="text-red-500">{{$message}}</div>
                @enderror --}}
                {{-- <div class="w-full flex flex-col">
                    <label for="int_tel" class="font-normal text-sm dark:text-white text-gray-900 leading-none">内線番号</label>
                    <input type="text" form="createForm" name="int_tel" id="int_tel" value="{{ old('int_tel') }}" class="input-secondary" placeholder="090-1234-5678">
                </div>
                @error('int_tel')
                    <div class="text-red-500">{{$message}}</div>
                @enderror --}}
                <div>
                    <div class="w-full flex flex-col">
                        <label for="phone" class="font-normal text-sm dark:text-white text-gray-900 leading-none">携帯番号</label>
                        <input type="text" form="createForm" name="phone" id="phone" onchange="validateAndFormat('phone')" value="{{ old('phone') }}" class="input-secondary" placeholder="090-1234-5678">
                    </div>
                    @error('phone')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="mail" class="font-normal text-sm dark:text-white text-gray-900 leading-none">Mail</label>
                        <input type="text" form="createForm" name="mail" id="mail" value="{{ old('mail') }}" class="input-secondary" placeholder="test@hoge.com">
                    </div>
                    @error('mail')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-8">
                <span class="dark:text-white">住所情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 mb-4 lg:grid-cols-5 md:mx-4">
                <div class="col-span-1">
                    <div class="flex">
                        <div class="w-full flex flex-col">
                            <label for="post_code" class="dark:text-gray-100 text-gray-900 leading-none text-sm" autocomplete="new-password">郵便番号</label>
                            <input type="text" form="createForm" name="post_code" class="input-primary" id="post_code" value="{{ old('post_code') }}" placeholder="">
                        </div>
                        <button type="button" id="ajaxzip" data-form="createForm" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="w-full flex flex-col col-span-1">
                    <label for="prefecture_id" class="font-normal text-sm dark:text-gray-100 text-gray-900 leading-none">都道府県</label>
                    <select id="prefecture_id" form="createForm" name="prefecture_id" class="input-secondary">
                        <option selected value="">未選択</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}" @if( $prefecture->id == old('prefecture_id') ) selected @endif>
                                {{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full flex flex-col md:col-span-3">
                    <div class="w-full flex flex-col">
                        <label for="address_1" class="font-normal text-sm dark:text-gray-100 text-gray-900 leading-none">代表所在地</label>
                        <input type="text" form="createForm" name="address_1" id="address_1" value="{{ old('address_1') }}" class="input-secondary">
                    </div>
                    @error('address_1')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div>
                <div class="flex flex-col md:mx-4">
                    <label for="client_contact_memo" class="font-normal text-sm dark:text-gray-100 text-gray-900 leading-none mt-8">担当者備考</label>
                    <textarea form="createForm" name="client_contact_memo" id="client_contact_memo" value="" class="input-secondary" cols="30" rows="5" data-auto-resize="true" placeholder="">{{ old('client_contact_memo') }}</textarea>
                </div>           
                @error('client_contact_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="md:px-4">
                <ul class="mt-4 mb-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 md:border-b-0 md:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_billing_receiver" form="createForm" name="is_billing_receiver" type="checkbox" value="1" {{ old('is_billing_receiver') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_billing_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">請求先</label>
                        </div>
                        @error('is_billing_receiver')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-gray-200 md:border-b-0 dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_payment_receiver" form="createForm" name="is_payment_receiver" type="checkbox" value="1" {{ old('is_payment_receiver') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_payment_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">支払先</label>
                        </div>
                        @error('is_payment_receiver')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                </ul>
            </div>


            <div class="md:px-4">
                <ul class="mt-4 mb-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @foreach($checkboxOptions as $option)
                        <li class="w-full @if($loop->last) border-0 @else border-b border-gray-200 dark:border-gray-600 @endif">
                            <div class="flex items-center pl-3">
                                <input id="{{ $option->name }}" form="createForm" name="{{ $option->name }}" type="checkbox" value="1" 
                                    @if(isset($clientPerson) && $clientPerson->checkboxOptions->contains($option->id) && $clientPerson->checkboxOptions->find($option->id)->pivot->value)
                                    checked
                                    @elseif(old($option->name))
                                    checked
                                    @endif
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2">
                                <label for="{{ $option->name }}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 whitespace-nowrap">{{ $option->label }}</label>
                            </div>
                            @error($option->name)
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                    @endforeach
                </ul>
            </div>
        </div> 
    </div> 
    



    <!-- 各画面のBladeテンプレート -->
    <x-modals.client-search-modal
        modalId="clientSearchModal"
        screenId="order_entry"
        :users="$users"
        onSelectCallback="handleClientSelect"
    />
        
    <script>
        // コールバック関数の定義
        function handleClientSelect(client) {
            document.getElementById('client_id').value = client.id;
            document.getElementById('client_num').value = client.client_num;
            document.getElementById('client_name').value = client.client_name;
            // document.getElementById('sales_user').value = client.user.user_name;
            document.getElementById('department').value = client.department.path;
        }
        // モーダルのコールバック関数を設定
        window.clientSearchModal_onSelect = handleClientSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>



    <script src="{{ asset('/assets/js/addresssearchbutton.js') }}"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 自動補完を無効にしたい入力フィールドのセレクタ
            const addressFields = document.querySelectorAll('input[name*="address"], input[name*="city"], input[name*="prefecture"], input[name*="zip"], input[name*="post_code"]');
            
            addressFields.forEach(function(field) {
                // autocomplete属性を設定（複数の方法を試す）
                field.setAttribute('autocomplete', 'new-password');
                
                // フォーカスイベントで自動補完リストを非表示にする
                field.addEventListener('focus', function() {
                    // 現在の値を保存
                    const currentValue = this.value;
                    
                    // 一時的に値をクリアして自動補完を非表示にし、すぐに元の値を復元
                    setTimeout(() => {
                        // 自動補完が表示された瞬間に非表示にする
                        this.value = '';
                        setTimeout(() => {
                            this.value = currentValue;
                        }, 10);
                    }, 20);
                });
            });
        });
    </script>

    @push('scripts')
        @vite(['resources/js/pages/client-contacts/create.js'])
    @endpush
</x-app-layout>