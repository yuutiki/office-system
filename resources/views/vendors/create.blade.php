<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createVendor') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">

            <form id="form1" method="post" action="{{route('vendors.store')}}" enctype="multipart/form-data" autocomplete="new-password">
                @csrf
                <div class="grid gap-4 mb-4 sm:grid-cols-2">

                    <div class="flex">
                        <div class="w-full flex flex-col">
                            <label for="corporation_num" class="block text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">法人No.<span class="text-red-500"> *</span></label>
                            <input type="text" name="corporation_num" class="input-readonly cursor-not-allowed" id="corporation_num" value="{{old('corporation_num')}}" placeholder="法人検索してください" readonly>
                            @error('corporation_num')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- 法人検索ボタン -->
                        <button type="button" id="corporationSearch" onclick="showModal()" class="p-2.5 text-sm font-medium h-[34px] text-white mt-[34px]  ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
                        <input type="text" name="vendor_name" class="input-secondary" id="vendor_name" value="{{old('vendor_name')}}" placeholder="">
                        @error('vendor_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="vendor_kana_name" class="block  text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">業者カナ名称<span class="text-red-500"> *</span></label>
                        <input type="text" name="vendor_kana_name" class="input-secondary" id="vendor_kana_name" value="{{old('vendor_kana_name')}}" placeholder="">
                        @error('vendor_kana_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="grid gap-4 mb-4 lg:grid-cols-5 grid-cols-2">
                    <div>
                        <label for="vendor_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">業者種別<span class="text-red-500"> *</span></label>
                        <select id="vendor_type_id" name="vendor_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        <select id="affiliation2" name="affiliation2" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm     dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">導入システム</button>
                        </li>
                        <li role="presentation">
                            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">環境情報</button>
                        </li> --}}
                    </ul>
                </div>
                <div id="myTabContent">
                    <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="grid gap-4 mb-4 sm:grid-cols-5 mt-2">
                            <div>
                                <label for="head_post_code" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">郵便番号</label>
                                <div class="relative w-full">
                                    <input type="text" name="head_post_code" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="head_post_code" value="{{old('head_post_code')}}" placeholder="">
                                    <button type="button" id="ajaxzip3" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-[34px] text-white mt-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="head_prefecture" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">都道府県</label>
                                <select id="head_prefecture" name="head_prefecture" class="w-full py-1.5  text-sm mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">未選択</option>
                                    @foreach($prefectures as $prefecture)
                                        <option value="{{ $prefecture->id }}" @if( $prefecture->id == old('head_prefecture') ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-3">
                                <label for="head_addre1" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表所在地</label>
                                <input type="text" name="head_addre1" id="head_addre1" value="{{old('head_addre1')}}" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" placeholder="">
                            </div>
                            <div>
                                <label for="head_tel" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表TEL（-）</label>
                                <input type="text" name="head_tel" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" id="head_tel" value="{{old('head_tel')}}" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" placeholder="">
                            </div>
                            <div>
                                <label for="head_fax" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表FAX（-）</label>
                                <input type="tel" name="head_fax" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" id="head_fax" value="{{old('head_fax')}}" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded"  placeholder="">
                            </div>
                        </div>
    
                        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
    
                        <div class="grid gap-4 mb-1 sm:grid-cols-5 mt-1">
                            <div class="w-full flex flex-col">
                                <label for="number_of_employees" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">従業員数</label>
                                <input type="number" min="0" name="number_of_employees" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="number_of_employees" value="{{old('number_of_employees')}}">
                            </div>
                        </div>
    
                        <div class="w-full flex flex-col">
                            <label for="memo" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">備考</label>
                            <textarea name="memo" data-auto-resize="true" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="auto-resize-textarea-client_memo" value="{{old('memo')}}" cols="30" rows="5">{{old('memo')}}</textarea>
                        </div>

                        <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="is_dealer" name="is_dealer" type="checkbox" value="1" {{ old('is_dealer') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_dealer" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">ディーラ</label>
                                </div>
                                @error('is_dealer')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="is_supplier" name="is_supplier" type="checkbox" value="1" {{ old('is_supplier') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_supplier" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">仕入外注先</label>
                                </div>
                                @error('is_supplier')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="is_lease" name="is_lease" type="checkbox" value="1" {{ old('is_lease') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_lease" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">リース会社</label>
                                </div>
                                @error('is_lease')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="is_other_partner" name="is_other_partner" type="checkbox" value="1" {{ old('is_other_partner') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_other_partner" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">その他協業</label>
                                </div>
                                @error('is_other_partner')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </li>
                        </ul>
                        <x-primary-button class="mt-4" id="saveButton">
                            新規登録する
                        </x-primary-button>
            </form>
                    </div>




                    <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                        {{-- content --}}
                    </div>
                    <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                        {{-- content --}}
                    </div>
                    <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                        {{-- content --}}
                    </div>
            </div>
        </div>
    </div>

    <!-- 法人検索 Modal -->
    <div id="corporationSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        法人検索画面
                    </h3>
                    <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="#" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="grid gap-4 mb-4 sm:grid-cols-2 mt-2">
                    {{-- <div class="flex flex-wrap justify-start mx-5"> --}}
                        <div>
                            <label for="corporationName" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">法人名称</label>
                            <input type="text" name="corporationName" id="corporationName" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div>
                            <label for="corporationNumber" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">法人番号</label>
                            <input type="text" name="corporationNumber" id="corporationNumber" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                    </div>
                </form>
                <div class=" max-h-80 overflow-y-auto overflow-x-hidden mt-4">
                    <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                        <thead>
                        <tr>
                            {{-- <th class="py-1"></th> --}}
                            <th class="py-1 pl-5">法人名称</th>
                            <th class="py-1 whitespace-nowrap">法人番号</th>
                        </tr>
                        </thead>
                        <tbody id="searchResultsContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="searchCorporation()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        検索
                    </button>
                    <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                </div>
            </div>
        </div>
    </div>




<script>
    // モーダルを表示するための関数
    function showModal() {
        // モーダルの要素を取得
        const modal = document.getElementById('corporationSearchModal');
        //背後の操作不可を有効
        const overlay = document.getElementById('overlay').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // モーダルを表示するためのクラスを追加
        modal.classList.remove('hidden');
    }

    // モーダルを非表示にするための関数
    function hideModal() {
        // モーダルの要素を取得
        const modal = document.getElementById('corporationSearchModal');
        //背後の操作不可を解除
        const overlay = document.getElementById('overlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');

        // モーダルを非表示にするためのクラスを削除
        modal.classList.add('hidden');
    }

    // 検索ボタンを押した時の処理
    function searchCorporation() {
        const corporationName = document.getElementById('corporationName').value;
        const corporationNumber = document.getElementById('corporationNumber').value;

        fetch('/corporations/search', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ corporationName, corporationNumber })
        })
        .then(response => response.json())
            .then(data => {
                const searchResultsContainer = document.getElementById('searchResultsContainer');
                searchResultsContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td tabindex="1" class="py-2 pl-5 cursor-pointer" onclick="setCorporation('${result.corporation_name}', '${result.corporation_num}')">${result.corporation_short_name}</td>
                    <td class="py-2 ml-2">${result.corporation_num}</td>
                    `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
        }

        function setCorporation(name, number) {
            document.getElementById('corporation_num').value = number;
            document.getElementById('corporation_name').value = name;
            // document.getElementById('corporation_name').textContent = name;
            // document.getElementById('corporation_num').textContent = number;
            hideModal();
        }
</script>

<script type="text/javascript" src="{{ asset('/assets/js/addresssearchbutton.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
</x-app-layout>