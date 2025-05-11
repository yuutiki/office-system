<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('createVendor') }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')"/>
                <form method="post" action="{{ route('vendors.store') }}" enctype="multipart/form-data" id="vendorForm" class="flex">
                    @csrf
                    <x-button-save form-id="vendorForm" id="saveButton" onkeydown="stopTab(event)">
                        {{ __('登録') }}
                    </x-button-save>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14 mb-4">
        <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div class="flex">

                <input type="text" form="vendorForm" name="corporation_id" class="hidden" id="corporation_id" value="{{old('corporation_id')}}">


                <div class="w-full flex flex-col">
                    <label for="corporation_num" class="block text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">法人No.<span class="text-red-500"> *</span></label>
                    <input type="text" form="vendorForm" name="corporation_num" class="input-readonly cursor-not-allowed" id="corporation_num" value="{{old('corporation_num')}}" placeholder="法人検索してください" readonly>
                    @error('corporation_num')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <!-- 法人検索ボタン -->
                <button type="button" id="corporationSearch" onclick="CorporationSearchModal.show('corporationSearchModal1')" class="p-2.5 text-sm font-medium h-[34px] text-white mt-[34px]  ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>

            <div>
                <label for="corporation_name" class="block  text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">法人名称<span class="text-red-500"> *</span></label>
                <input type="text" name="corporation_name" class="input-readonly cursor-not-allowed" id="corporation_name" value="{{old('corporation_name')}}" placeholder="法人検索してください" readonly>
                @error('corporation_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="vendor_name" class="block  text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">業者名称<span class="text-red-500"> *</span></label>
                <input type="text"  name="vendor_name" form="vendorForm" class="input-secondary" id="vendor_name" value="{{old('vendor_name')}}" placeholder="">
                @error('vendor_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="vendor_kana_name" class="block  text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">業者カナ名称<span class="text-red-500"> *</span></label>
                <input type="text" form="vendorForm" name="vendor_kana_name" class="input-secondary" id="vendor_kana_name" value="{{old('vendor_kana_name')}}" placeholder="">
                @error('vendor_kana_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="grid gap-4 mb-4 lg:grid-cols-2 grid-cols-2">
            <div>
                <label for="vendor_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">業者種別<span class="text-red-500"> *</span></label>
                <select form="vendorForm" id="vendor_type_id" name="vendor_type_id" class="input-secondary">
                    <option value="">未選択</option>
                    @foreach($vendorTypes as $vendorType)
                        <option value="{{ $vendorType->id }}" @selected($vendorType->id == old('vendor_type_id'))>{{ $vendorType->vendor_type_name }}</option>
                    @endforeach
                </select>
                @error('vendor_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            {{-- <div>
                <label for="trade_status_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">業者取引状態<span class="text-red-500"> *</span></label>
                <select id="trade_status_id" name="trade_status_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">未選択</option>
                    @foreach($tradeStatuses as $tradeStatus)
                    <option value="{{ $tradeStatus->id }}" @selected($tradeStatus->id == old('trade_status_id'))>{{ $tradeStatus->trade_status_name }}</option>
                    @endforeach
                </select>
                @error('trade_status_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div> --}}
            <div>
                <label for="affiliation2" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">管轄事業部<span class="text-red-500"> *</span></label>
                <select form="vendorForm" id="affiliation2" name="affiliation2" class="input-secondary">
                    <option value="">未選択</option>
                    @foreach($affiliation2s as $affiliation2)
                    <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('affiliation2', Auth::user()->affiliation2->id))>{{ $affiliation2->affiliation2_name }}</option>
                    @endforeach
                </select>
                @error('affiliation2')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">基本情報</button>
                </li>
                {{-- <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">契約情報</button>
                </li> --}}
            </ul>
        </div>
        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="grid gap-4 mb-4 sm:grid-cols-4 mt-2">
                <div>
                    <label for="head_post_code" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">郵便番号</label>
                    <div class="relative w-full">
                        <input type="text" form="vendorForm" name="head_post_code" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="head_post_code" value="{{old('head_post_code')}}" placeholder="">
                        <button type="button" id="ajaxzip3" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-[34px] text-white mt-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="head_prefecture" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">都道府県</label>
                    <select form="vendorForm" id="head_prefecture" name="head_prefecture" class="w-full py-1.5  text-sm mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}" @if( $prefecture->id == old('head_prefecture') ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label for="head_addre1" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表所在地</label>
                    <input type="text" form="vendorForm" name="head_addre1" id="head_addre1" value="{{old('head_addre1')}}" class="input-secondary" placeholder="">
                </div>
                <div class="col-span-2">
                    <label for="head_tel" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表TEL</label>
                    <input type="tel" form="vendorForm" name="head_tel" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" id="head_tel" value="{{old('head_tel')}}" onchange="validateAndFormat('head_tel')" class="input-secondary" placeholder="">
                </div>
                <div class="col-span-2">
                    <label for="head_fax" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表FAX</label>
                    <input type="tel" form="vendorForm" name="head_fax" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" id="head_fax" value="{{old('head_fax')}}" onchange="validateAndFormat('head_fax')" class="input-secondary"  placeholder="">
                </div>
            </div>

            <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>

            <div class="grid gap-4 mb-1 sm:grid-cols-2 mt-1">
                <div class="w-full flex flex-col">
                    <label for="number_of_employees" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">従業員数</label>
                    <input type="number" form="vendorForm" min="0" name="number_of_employees" class="input-secondary" id="number_of_employees" value="{{old('number_of_employees')}}">
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="memo" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">備考</label>
                <textarea name="memo" form="vendorForm" data-auto-resize="true" class="input-secondary" value="{{old('memo')}}" cols="30" rows="5">{{old('memo')}}</textarea>
            </div>

            <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input form="vendorForm" id="is_dealer" name="is_dealer" type="checkbox" value="1" {{ old('is_dealer') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="is_dealer" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">ディーラ</label>
                    </div>
                    @error('is_dealer')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </li>
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input form="vendorForm" id="is_supplier" name="is_supplier" type="checkbox" value="1" {{ old('is_supplier') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="is_supplier" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">仕入外注先</label>
                    </div>
                    @error('is_supplier')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </li>
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input form="vendorForm" id="is_lease" name="is_lease" type="checkbox" value="1" {{ old('is_lease') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="is_lease" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">リース会社</label>
                    </div>
                    @error('is_lease')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </li>
                <li class="w-full dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input form="vendorForm" id="is_other_partner" name="is_other_partner" type="checkbox" value="1" {{ old('is_other_partner') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="is_other_partner" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">その他協業</label>
                    </div>
                    @error('is_other_partner')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </li>
            </ul>
        </div>

        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            {{-- content --}}
        </div>
    </div>




    {{-- 各画面のBladeテンプレート --}}
    <x-modals.corporation-search-modal
        modalId="corporationSearchModal1"
        screenId="order_entry"
        :users="$users"
        onSelectCallback="handleClientSelect"
    />
        
    <script>
        // コールバック関数の定義
        function handleClientSelect(corporation) {
            document.getElementById('corporation_num').value = corporation.corporation_num;
            document.getElementById('corporation_id').value = corporation.corporation_id;
            document.getElementById('corporation_name').value = corporation.corporation_name;
        }
        // モーダルのコールバック関数を設定
        window.corporationSearchModal1_onSelect = handleClientSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/corporation-search-modal.js') }}"></script>

<script type="text/javascript" src="{{ asset('/assets/js/addresssearchbutton.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
</x-app-layout>