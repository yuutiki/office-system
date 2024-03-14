<x-app-layout>
    {{-- <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                契約詳細登録
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot> --}}
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('CreateContractDetail', $contract) }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">

            <form id="form1" method="post" action="{{route('client-product.store')}}" enctype="multipart/form-data" autocomplete="new-password">
                @csrf
                <!-- 顧客検索ボタン -->
                {{-- <button type="button"  onclick="showModal()" tabindex="-1" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    顧客検索
                </button>

                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div class="">
                        <label for="client_num" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客番号</label>
                        <input type="text" name="client_num" tabindex="-1" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_num" value="{{ $clientNum }}" placeholder="顧客検索してください" readonly>
                    </div>
                    @error('client_num')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror   
                    <div class="">
                        <label for="client_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                        <input type="text" name="client_name" tabindex="-1" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_name" value="{{ $clientName }}" readonly>
                    </div>
                    @error('client_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div> --}}


                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">追加フォーム</button>
                        </li>
                    </ul>
                </div>
                <div id="myTabContent">
                    <div class="hidden p-8 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <!-- header -->
                        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                導入システム追加
                            </h3>
                        </div>
                        <!-- body -->
                        {{-- <button type="button" id="searchProductButton" onclick="showProductModal()" autofocus tabindex="1" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span class="text-ms">製品検索</span>
                        </button>
                        <div class="grid gap-4 mb-4 sm:grid-cols-4 mt-2" inert>
                            <div>
                                <label for="productSeries" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">シリーズ</label>
                                <select id="productSeries" name="productSeries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed pointer-events-none" readonly>
                                    <option value="" >未選択</option>
                                    @foreach ($productSeries as $productSeries1)
                                        <option value="{{ $productSeries1->id }}" @selected($productSeries1->id == old('productSeries')) >
                                            {{ $productSeries1->series_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('productSeries')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="split_type_name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">内訳種別</label>
                                <select id="split_type_name" name="split_type_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed pointer-events-none" readonly>
                                    <option value="" >未選択</option>
                                    @foreach ($productSplitTypes as $productSplitType)
                                    <option value="{{ $productSplitType->id }}" @selected($productSplitType->id == old('productSplitTypeId')) disabled>
                                        {{ $productSplitType->split_type_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div hidden>
                                <label for="product_code" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">製品コード</label>
                                <input type="text" name="product_code" id="product_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed" placeholder="Type product code" readonly>
                            </div>
                            <div class="col-span-2">
                                <label for="product_name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">製品名称</label>
                                <input type="text" name="product_name" id="product_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed" placeholder="製品検索をしてください" inert>
                            </div>
                        </div>

                        <div class="grid gap-4 mb-4 sm:grid-cols-4 mt-8">
                            <div>
                                <label for="product_version_id" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">バージョン</label>
                                <select id="product_version_id" name="product_version_id" tabindex="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option selected value="">未選択</option>
                                    @foreach ($productVersions as $productVersion)
                                        <option value = "{{ $productVersion->id }}" @selected($productVersion->id == old('product_version_id')) >
                                            {{ $productVersion->version_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_version_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="is_customized" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">CUSフラグ</label>
                                <select id="is_customized" name="is_customized" tabindex="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option selected value="0">標準</option>
                                    <option value="1">CUS</option>
                                </select>
                                @error('is_customized')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="is_contracted" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">契約区分</label>
                                <select id="is_contracted" name="is_contracted" tabindex="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="0">未契約</option>
                                    <option selected value="1">契約済</option>
                                </select>
                                @error('is_contracted')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="quantity" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">数量</label>
                                <input type="number" min="1" tabindex="4" name="quantity" id="quantity" value="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                            </div>
                            @error('quantity')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <div class="sm:col-span-4">
                                <label for="install_memo" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">備考</label>
                                <textarea id="install_memo" name="install_memo" tabindex="5" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Write product description here"></textarea>                    
                            </div>
                            @error('install_memo')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <input checked id="checked-checkbox" type="checkbox" name="action" value="save_and_continue" tabindex="6" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checked-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">続けて登録</label>
                        </div> --}}
                        <div class="grid gap-4 my-4 md:grid-cols-2">
                            <div>
                                <div class="w-full flex flex-col col-span-2 mt-4">
                                    <label for="contract_start_at" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">契約開始日</label>
                                    <input type="date" min="1900-01-01" max="2200-12-31" name="contract_start_at" id="contract_start_at" value="{{old('contract_start_at')}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                                </div>
                                @error('contract_start_at')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <div class="w-full flex flex-col col-span-2 mt-4">
                                    <label for="contract_end_at" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">契約終了日</label>
                                    <input type="date" min="1900-01-01" max="2200-12-31" name="contract_end_at" id="contract_end_at" value="{{old('contract_end_at')}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                                </div>
                                @error('contract_end_at')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <div class="w-full flex flex-col col-span-2 mt-4">
                                <label for="contract_amount" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">契約金額</label>
                                <input type="text" maxlength="100" name="contract_amount" id="contract_amount" value="{{old('contract_amount')}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                            </div>
                            @error('contract_amount')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="w-full flex flex-col">
                            <label for="target_system" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">対象システム</label>
                            <textarea name="target_system" id="target_system" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('target_system') }}</textarea>
                            @error('target_system_')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="target_system" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">契約詳細備考</label>
                            <textarea name="target_system" id="target_system" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('target_system') }}</textarea>
                            @error('target_system_')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="grid gap-4 my-4 md:grid-cols-2">
                            <div class="w-full flex flex-col">
                                <label for="contract_update_type_id" class="block font-medium text-gray-900 dark:text-white">契約更新区分</label>
                                <select name="contract_update_type_id" id="contract_update_type_id" value="{{old('contract_update_type_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    @foreach($contractUpdateTypes as $contractUpdateType)
                                    <option value="{{ $contractUpdateType->id }}"  @selected($contractUpdateType->id == old('contract_update_type_id'))>{{ $contractUpdateType->contract_update_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('contract_update_type_id_')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                            <div class="w-full flex flex-col">
                                <label for="contract_sheet_status_id" class="block font-medium text-gray-900 dark:text-white">契約書状態</label>
                                <select name="contract_sheet_status_id" id="contract_sheet_status_id" value="{{old('contract_sheet_status_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    @foreach($contractSheetStatuses as $contractSheetStatus)
                                    <option value="{{ $contractSheetStatus->id }}"  @selected($contractSheetStatus->id == old('contract_sheet_status_id'))>{{ $contractSheetStatus->contract_sheet_status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('contract_sheet_status_id_')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                            <div class="w-full flex flex-col">
                                <label for="contract_partner_type_id" class="block font-medium text-gray-900 dark:text-white">契約先区分</label>
                                <select name="contract_partner_type_id" id="contract_partner_type_id" value="{{old('contract_partner_type_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    @foreach($contractPartnerTypes as $contractPartnerType)
                                    <option value="{{ $contractPartnerType->id }}"  @selected($contractPartnerType->id == old('contract_partner_type_id'))>{{ $contractPartnerType->contract_partner_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('contract_partner_type_id_')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                            <div class="w-full flex flex-col">
                                <label for="contract_change_type_id" class="block font-medium text-gray-900 dark:text-white">契約先区分</label>
                                <select name="contract_change_type_id" id="contract_change_type_id" value="{{old('contract_change_type_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    @foreach($contractChangeTypes as $contractChangeType)
                                    <option value="{{ $contractChangeType->id }}"  @selected($contractChangeType->id == old('contract_change_type_id'))>{{ $contractChangeType->contract_change_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('contract_change_type_id_')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        <x-primary-button class="mt-4" tabindex="6">
                            新規登録する
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>







    <script>
        // 顧客検索モーダルを表示するための関数
        function showModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('clientSearchModal');
            //背後の操作不可を有効
            const overlay = document.getElementById('overlay').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
        }

        // 顧客検索モーダルを非表示にするための関数
        function hideModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('clientSearchModal');
            //背後の操作不可を解除
            const overlay = document.getElementById('overlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // モーダルを非表示にするためのクラスを削除
            modal.classList.add('hidden');
        }

    // 顧客検索ボタンを押した時の処理
        function searchClient() {
            const clientName = document.getElementById('clientName').value;
            const clientNumber = document.getElementById('clientNumber').value;
            const departmentId = document.getElementById('departmentId').value;

            fetch('/client/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ clientName, clientNumber, departmentId })
            })
            .then(response => response.json())
            .then(data => {
                const searchResultsContainer = document.getElementById('searchResultsContainer');
                searchResultsContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td class="py-2 pl-5 cursor-pointer" onclick="setCorporation('${result.client_name}', '${result.client_num}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department.department_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setCorporation(name, number) {
            document.getElementById('client_num').value = number;
            document.getElementById('client_name').value = name;

            hideModal();
            }


    // 製品検索モーダルを表示するための関数
        function showProductModal() {
        // モーダルの要素を取得
        const modal = document.getElementById('searchProduct');
        // 背後の操作不可を有効
        const overlay = document.getElementById('overlay').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // モーダルを表示するためのクラスを追加
        modal.classList.remove('hidden');

        // モーダル内のコンテンツ要素を取得
        const modalContent = modal.querySelector('.bg-blue-400');

        // Tabキーによるフォーカス移動をトラップする関数
        function trapTabKey(e) {
            if (e.key === 'Tab') {
                const focusableElements = modalContent.querySelectorAll(
                    'a[href], button:not([disabled]), textarea, input:not([disabled]), select:not([disabled])'
                );

                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            }
        }

        // Tabキーイベントをモーダル内で捕捉
        modalContent.addEventListener('keydown', trapTabKey);

        // モーダルが開かれたときに最初のフォーカス可能な要素にフォーカスを当てる
        const productNameInput = document.getElementById('productName');
        productNameInput.focus();
    }

    // 製品検索モーダルを非表示にするための関数
        function hideProductModal() {
        // モーダルの要素を取得
        const modal = document.getElementById('searchProduct');
        // 背後の操作不可を解除
        const overlay = document.getElementById('overlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');

        // モーダルを非表示にするためのクラスを追加
        modal.classList.add('hidden');


        const ProductButton = document.getElementById('searchProductButton');
        ProductButton.focus();

        // モーダル内のコンテンツ要素からTabキーイベントリスナーを削除
        const modalContent = modal.querySelector('.bg-blue-400');
        modalContent.removeEventListener('keydown', trapTabKey);
    }


    //製品検索ボタンを押下した際の処理
        function searchProduct() {
            const productName = document.getElementById('productName').value;
            const productSeriesId = document.getElementById('productSeriesId').value;
            const productSplitTypeId = document.getElementById('productSplitTypeId').value;

            fetch('/product/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ productName, productSeriesId, productSplitTypeId })
            })
            .then(response => response.json())
            .then(data => {
                const searchResultsProductContainer = document.getElementById('searchResultsProductContainer');
                searchResultsProductContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td class="py-2 pl-5 cursor-pointer" onclick="setProduct('${result.product_name}', '${result.product_series_id}', '${result.product_split_type_id}', '${result.product_code}')">${result.product_name}</td>
                    <td class="py-2 ml-2">${result.product_series.series_name}</td>
                    <td class="py-2 ml-2">${result.product_split_type.split_type_name}</td>
                `;
                searchResultsProductContainer.appendChild(resultElement);
                });
            });
            }

            function setProduct(name, series, split, code) {
            document.getElementById('product_name').value = name;
            document.getElementById('productSeries').value = series;
            document.getElementById('split_type_name').value = split;
            document.getElementById('product_code').value = code;


            hideProductModal();
            }
    </script>

</x-app-layout>