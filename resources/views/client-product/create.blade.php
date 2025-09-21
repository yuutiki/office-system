<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createClientProduct') }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')"/>
                <form method="post" action="{{ route('client-products.store') }}" enctype="multipart/form-data" id="createForm" class="flex">
                    @csrf
                    @can('storeUpdate_client_products')
                        <div class="flex">
                            <x-buttons.save-button form-id="createForm" id="saveButton" class="">
                                {{ __("save") }}
                            </x-buttons.save-button>
                            <div class="flex items-center ml-4 ">
                                <input form="createForm" checked id="checked-checkbox" type="checkbox" name="action" value="save_and_continue" tabindex="6" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checked-checkbox" class="ml-1 text-sm text-gray-900 dark:text-gray-300">続けて登録</label>
                            </div>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        @csrf

        <div class="grid gap-4 mb-2 md:grid-cols-2">
            <div class="flex">
                <div class="w-full flex flex-col">
                    <label for="client_num" class="block dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">顧客番号</label>
                    <input type="text" form="createForm" name="client_num" tabindex="-1" class="input-secondary cursor-not-allowed" id="client_num" value="{{ $clientNum }}" placeholder="顧客検索してください">
                </div>

                <button type="button" onclick="ClientSearchModal.show('clientSearchModal1')" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[34px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>

            <div>
                <div class="">
                    <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4 text-sm">顧客名称</label>
                    <input type="text" form="createForm" name="client_name" tabindex="-1" class="input-secondary cursor-not-allowed" id="client_name" value="{{ $clientName }}" readonly>
                </div>
                @error('client_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">追加フォーム</button>
                </li>
            </ul>
        </div>

        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <button type="button" id="searchProductButton" onclick="ProductSearchModal.show('productSearchModal1')" autofocus tabindex="1" class="sm:hidden md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <span class="text-ms">製品検索</span>
            </button>

            <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-3 mt-2">
                <div class="flex">
                    <div class="w-full">
                        <label for="product_series_id" class="block mb-1 text-sm text-gray-900 dark:text-white">シリーズ</label>
                        <select form="createForm" id="product_series_id" name="product_series_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed pointer-events-none" readonly>
                            <option value="" >---</option>
                            @foreach ($productSeries as $productSeries1)
                                <option value="{{ $productSeries1->id }}" @selected($productSeries1->id == old('product_series_id')) >
                                    {{ $productSeries1->series_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_series_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" onclick="ProductSearchModal.show('productSearchModal1')" class="hidden sm:block p-2.5 text-sm font-medium h-[35px] text-white mt-[26px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>


                <div>
                    <label for="product_type_id" class="block mb-1 text-sm text-gray-900 dark:text-white">製品種別</label>
                    <select form="createForm" id="product_type_id" name="product_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed pointer-events-none" readonly>
                        <option value="" >---</option>
                        @foreach ($productTypes as $productType)
                        <option value="{{ $productType->id }}" @selected($productType->id == old('product_type_id')) disabled>
                            {{ $productType->type_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="product_split_type_id" class="block mb-1 text-sm text-gray-900 dark:text-white">製品内訳種別</label>
                    <select form="createForm" id="product_split_type_id" name="product_split_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed pointer-events-none" readonly>
                        <option value="" >---</option>
                        @foreach ($productSplitTypes as $productSplitType)
                        <option value="{{ $productSplitType->id }}" @selected($productSplitType->id == old('product_split_type_id')) disabled>
                            {{ $productSplitType->split_type_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div hidden>
                    <label for="product_id">製品ID</label>
                    <input type="text" form="createForm" name="product_id" id="product_id">
                </div>
                <div>
                    <div class="col-span-1 md:col-span-3">
                        <label for="product_name" class="block mb-1 text-sm text-gray-900 dark:text-white">製品名称</label>
                        <input type="text" form="createForm" name="product_name" id="product_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed" placeholder="製品検索をしてください" inert>
                    </div>
                    @error('product_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-4 mt-4">
                <div>
                    <label for="product_version_id" class="block text-sm text-gray-900 dark:text-white">バージョン</label>
                    <select form="createForm" id="product_version_id" name="product_version_id" tabindex="1" class="input-primary">
                        <option selected value="">---</option>
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
                    <label for="is_customized" class="block text-sm text-gray-900 dark:text-white">CUSフラグ</label>
                    <select form="createForm" id="is_customized" name="is_customized" tabindex="2" class="input-primary">
                        <option selected value="0">標準</option>
                        <option value="1">CUS</option>
                    </select>
                    @error('is_customized')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="is_contracted" class="block text-sm text-gray-900 dark:text-white">契約区分</label>
                    <select form="createForm" id="is_contracted" name="is_contracted" tabindex="3" class="input-primary">
                        <option value="0">未契約</option>
                        <option selected value="1">契約済</option>
                    </select>
                    @error('is_contracted')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <div>
                        <label for="quantity" class="block text-sm text-gray-900 dark:text-white">数量</label>
                        <input type="number" form="createForm" min="1" tabindex="4" name="quantity" id="quantity" value="1" class="input-secondary" required="">
                    </div>
                    @error('quantity')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
                <div class="sm:col-span-4">
                    <label for="install_memo" class="block text-sm text-gray-900 dark:text-white">備考</label>
                    <textarea id="install_memo" form="createForm" name="install_memo" tabindex="5" rows="4" class="input-primary"></textarea>
                </div>
                @error('install_memo')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
        </div>
    </div>




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
        }
        // モーダルのコールバック関数を設定
        window.clientSearchModal1_onSelect = handleClientSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>



    <x-modals.product-search-modal
        modalId="productSearchModal1"
        screenId="order_entry"
        :productSeries="$productSeries"
        :productTypes="$productTypes"
        :productSplitTypes="$productSplitTypes"
        onSelectCallback="handleProductSelect"
    />

    <script>
        // コールバック関数の定義
        function handleProductSelect(products) {
            document.getElementById('product_id').value = products.id;
            document.getElementById('product_name').value = products.product_name;
            document.getElementById('product_series_id').value = products.product_series.id;
            document.getElementById('product_type_id').value = products.product_type.id;
            document.getElementById('product_split_type_id').value = products.product_split_type.id;
        }
        // モーダルのコールバック関数を設定
        window.productSearchModal1_onSelect = handleProductSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/product-search-modal.js') }}"></script>
</x-app-layout>