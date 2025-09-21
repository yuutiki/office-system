<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('editClientContact') }}
            </h2>
            <div class="ml-auto flex justify-end items-center space-x-2">
                <form method="post" action="{{ route('client-contacts.update', $clientContact) }}" enctype="multipart/form-data" id="clientContactForm" class="flex items-center">
                    @csrf
                    @method('patch')
                    {{-- @can('storeUpdate_corporations') --}}
                        <x-button-save form-id="clientContactForm" id="saveButton" onkeydown="stopTab(event)">
                            <span class="ml-1 hidden md:inline text-sm">保存</span>
                        </x-button-save>
                    {{-- @endcan --}}
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
                {{-- <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="credit-tab" data-tabs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="false">与信情報</button>
                </li> --}}
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">

            <!-- 顧客検索ボタン(画面小) -->
            <button type="button" onclick="ClientSearchModal.show('clientSearchModal1')" class="md:ml-1 md:mt-1 mt-1 w-full md:w-auto whitespace-nowrap sm:hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                顧客検索
            </button>
            <div class="grid gap-4 md:grid-cols-3">
                <div class="flex md:mt-4 mt-4">
                    <div class="w-full flex flex-col">
                        <label for="client_num" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">顧客№<span class="text-red-500"> *</span></label>
                        <input type="text" form="clientContactForm" name="client_num" id="client_num" value="{{ old('client_num', $clientContact->client->client_num) }}" class="input-readonly pointer-events-none" placeholder="" readonly>
                    </div>
                    <!-- 顧客検索ボタン(画面中～) -->
                    <button type="button" onclick="ClientSearchModal.show('clientSearchModal1')" data-form="clientContactForm" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger hidden sm:block">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
            <div class="w-full flex flex-col md:mt-4">
                    <label for="client_name" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">顧客名称<span class="text-red-500"> *</span></label>
                    <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $clientContact->client->client_name) }}" class="input-readonly pointer-events-none" placeholder="" readonly>
                </div>
            <div class="w-full flex flex-col md:mt-4">
                    <label for="affiliation2_id" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">管轄事業部<span class="text-red-500"> *</span></label>
                    <input type="text" name="affiliation2_id" id="affiliation2_id" value="{{ old('affiliation2_id', $clientContact->client->affiliation2->affiliation2_name) }}" class="input-readonly pointer-events-none" placeholder="" readonly>
                </div>
                @error('client_num')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="mt-8">
                <span class="dark:text-white">担当者情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                {{-- <input type="hidden" name="is_retired" id="is_retired" value="0"> --}}
                <input type="checkbox" form="clientContactForm" name="is_retired" id="is_retired" value="1" @checked( old('is_retired', $clientContact->is_retired) == 1) class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">退職フラグ</span>
            </label>

            <div class="grid gap-4 sm:grid-cols-2 md:mx-4">
                <div>
                    <div class="w-full flex flex-col">
                        <label for="last_name" class="font-normal text-sm  dark:text-red-500 text-red-700 leading-none md:mt-4">氏名（姓）<span class="text-red-500"> *</span></label>
                        <input type="text" form="clientContactForm" name="last_name" id="last_name" value="{{ old('last_name', $clientContact->last_name) }}" class="input-secondary" placeholder="">
                    </div>
                    @error('last_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="first_name" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none md:mt-4">氏名（名）<span class="text-red-500"> *</span></label>
                        <input type="text" form="clientContactForm" name="first_name" id="first_name" value="{{ old('first_name', $clientContact->first_name) }}" class="input-secondary" placeholder="">
                    </div>
                    @error('first_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="last_name_kana" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">カナ氏名（姓）<span class="text-red-500"> *</span></label>
                        <input type="text" form="clientContactForm" name="last_name_kana" id="last_name_kana" value="{{ old('last_name_kana', $clientContact->last_name_kana) }}" class="input-secondary" placeholder="">
                    </div>
                    @error('last_name_kana')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="first_name_kana" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">カナ氏名（名）<span class="text-red-500"> *</span></label>
                        <input type="text" form="clientContactForm" name="first_name_kana" id="first_name_kana" value="{{ old('first_name_kana', $clientContact->first_name_kana) }}" class="input-secondary" placeholder="">
                    </div>
                    @error('first_name_kana')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="division_name" class="font-normal text-sm dark:text-white text-gray-900 leading-none">所属部署名</label>
                        <input type="text" form="clientContactForm" name="division_name" id="division_name" value="{{ old('division_name', $clientContact->division_name) }}" class="input-secondary" placeholder="">
                    </div>
                    @error('division_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="position_name" class="font-normal text-sm dark:text-white text-gray-900 leading-none">役職名</label>
                        <input type="text" form="clientContactForm" name="position_name" id="position_name" value="{{ old('position_name', $clientContact->position_name) }}" class="input-secondary" placeholder="">
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
                        <input type="text" form="clientContactForm" name="tel1" id="tel1" onchange="validateAndFormat('tel1')" value="{{ old('tel1', $clientContact->tel1) }}" class="input-secondary" placeholder="090-1234-5678">
                    </div>
                    @error('tel1')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                {{-- <div class="w-full flex flex-col">
                    <label for="tel2" class="font-normal text-sm dark:text-white text-gray-900 leading-none md:mt-4">電話番号2</label>
                    <input type="text" form="clientContactForm" name="tel2" id="tel2" value="{{ old('tel2', $clientContact->tel2) }}" class="input-secondary" placeholder="090-1234-5678">
                </div>
                @error('tel2')
                    <div class="text-red-500">{{$message}}</div>
                @enderror --}}
                <div>
                    <div class="w-full flex flex-col">
                        <label for="fax1" class="font-normal text-sm dark:text-white text-gray-900 leading-none">FAX番号</label>
                        <input type="text" form="clientContactForm" name="fax1" id="fax1" onchange="validateAndFormat('fax1')" value="{{ old('fax1', $clientContact->fax1) }}" class="input-secondary" placeholder="090-1234-5678">
                    </div>
                    @error('fax1')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                {{-- <div class="w-full flex flex-col">
                    <label for="fax2" class="font-normal text-sm dark:text-white text-gray-900 leading-none">FAX番号2</label>
                    <input type="text" form="clientContactForm" name="fax2" id="fax2" value="{{ old('fax2', $clientContact->fax2) }}" class="input-secondary" placeholder="090-1234-5678">
                </div>
                @error('fax2')
                    <div class="text-red-500">{{$message}}</div>
                @enderror --}}
                {{-- <div class="w-full flex flex-col">
                    <label for="int_tel" class="font-normal text-sm dark:text-white text-gray-900 leading-none">内線番号</label>
                    <input type="text" form="clientContactForm" name="int_tel" id="int_tel" value="{{ old('int_tel', $clientContact->int_tel) }}" class="input-secondary" placeholder="090-1234-5678">
                </div>
                @error('int_tel')
                    <div class="text-red-500">{{$message}}</div>
                @enderror --}}
                <div>
                    <div class="w-full flex flex-col">
                        <label for="phone" class="font-normal text-sm dark:text-white text-gray-900 leading-none">携帯番号</label>
                        <input type="text" form="clientContactForm" name="phone" id="phone" onchange="validateAndFormat('phone')" value="{{ old('phone', $clientContact->phone) }}" class="input-secondary" placeholder="090-1234-5678">
                    </div>
                    @error('phone')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="mail" class="font-normal text-sm dark:text-white text-gray-900 leading-none">Mail</label>
                        <input type="text" form="clientContactForm" name="mail" id="mail" value="{{ old('mail', $clientContact->mail) }}" class="input-secondary" placeholder="test@hoge.com">
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
                            <input type="text" form="clientContactForm" name="post_code" class="input-primary" id="post_code" value="{{ old('post_code', $clientContact->post_code) }}" placeholder="">
                        </div>
                        <button type="button" id="ajaxzip" data-form="clientContactForm" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="prefecture_id" class=" text-sm dark:text-gray-100 text-gray-900 leading-none" autocomplete="new-password">都道府県</label>
                    <select id="prefecture_id" form="clientContactForm" name="prefecture_id" class="input-secondary">
                        <option selected value="">未選択</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}" @if( $prefecture->id ==  old('prefecture_id', $clientContact->prefecture_id) ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full flex flex-col md:col-span-3">
                    <div class="w-full flex flex-col">
                        <label for="address_1" class=" text-sm dark:text-gray-100 text-gray-900 leading-none" autocomplete="new-password">代表所在地</label>
                        <input type="text" form="clientContactForm" name="address_1" id="address_1" value="{{ old('address_1', $clientContact->address_1) }}" class="input-secondary" placeholder="">
                    </div>
                    @error('address_1')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>



            <div>
                <div class=" flex flex-col md:mx-4">
                    <label for="client_contact_memo" class="font-normal text-sm dark:text-gray-100 text-gray-900 leading-none mt-8">担当者備考</label>
                    <textarea name="client_contact_memo" form="clientContactForm" id="client_contact_memo" value="" class="input-secondary" cols="30" rows="5" data-auto-resize="true" placeholder="">{{ old('client_contact_memo', $clientContact->client_contact_memo) }}</textarea>
                </div>           
                @error('client_contact_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="md:px-4">
                <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 md:border-b-0 md:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_billing_receiver" form="clientContactForm" name="is_billing_receiver" type="checkbox" value="1" {{ old('is_billing_receiver', $clientContact->is_billing_receiver) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_billing_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 whitespace-nowrap">請求先</label>
                        </div>
                        @error('is_billing_receiver')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-gray-200 dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_payment_receiver" form="clientContactForm" name="is_payment_receiver" type="checkbox" value="1" {{ old('is_payment_receiver', $clientContact->is_payment_receiver) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_payment_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 whitespace-nowrap">支払先</label>
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
                        <li class="w-full @if ($loop->last) border-0 @else border-b border-gray-200 dark:border-gray-600 @endif">
                            <div class="flex items-center pl-3">
                                <input id="{{ $option->name }}" 
                                    form="clientContactForm" 
                                    name="{{ $option->name }}" 
                                    type="checkbox" 
                                    value="1" 
                                    @if(isset($clientContact) && $clientContact->checkboxOptions->contains($option->id) && $clientContact->checkboxOptions->find($option->id)->pivot->value)
                                    checked
                                    @elseif(old($option->name))
                                    checked
                                    @endif
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
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

        {{-- 各画面のBladeテンプレート --}}
        <x-modals.client-search-modal
        modalId="clientSearchModal1"
        screenId="order_entry"
        :users="$users"
        onSelectCallback="handleClientSelect"
    />

    <script>
        // コールバック関数の定義
        function handleClientSelect(client) {
            document.getElementById('client_num').value = client.client_num;
            document.getElementById('client_name').value = client.client_name;
            // document.getElementById('sales_user').value = client.user.user_name;
            document.getElementById('affiliation2_id').value = client.affiliation2.affiliation2_name;
        }
        // モーダルのコールバック関数を設定
        window.clientSearchModal1_onSelect = handleClientSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/assets/js/addresssearchbutton.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/libphonenumber-js/1.1.10/libphonenumber-js.min.js"></script>
    <script>
        // バリデーション関数
        var validateTelNeo = function (value) {
            return /^[0０]/.test(value) && libphonenumber.isValidNumber(value, 'JP');
        }

        // 整形関数
        var formatTel = function (value) {
            return new libphonenumber.AsYouType('JP').input(value);
        }

        var validateAndFormat = function (inputId) {
            var phoneInput = document.getElementById(inputId);
            if (!phoneInput) {
                console.error('ERROR: Phone input element not found!');
                return;
            }
            var tel = phoneInput.value.trim().replace(/[０-９]/g, function(char) {
                // 全角数字を半角に変換
                return String.fromCharCode(char.charCodeAt(0) - 65248);
            }).replace(/\D/g, ''); // 数字以外の文字を削除
            
            if (!validateTelNeo(tel)) {
                console.error('ERROR: Invalid phone number!');
                return;
            }
            var formattedTel = formatTel(tel);
            console.log('Formatted Phone Number:', formattedTel);
            
            // 入力フィールドに整形された電話番号を表示
            phoneInput.value = formattedTel;
            
            // 以降 formattedTel を使って登録処理など進める
        }
    </script>
</x-app-layout>