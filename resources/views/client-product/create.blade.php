<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                顧客導入システム追加
            </h2>
            <div class="flex justify-end">
                <x-general-button tabindex="-1" onclick="location.href='{{ route('clients.edit', ['client'=> $clientId]) }}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>
    {{-- <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createClientProduct', $client) }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot> --}}

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <form id="form1" method="post" action="{{route('client-product.store')}}" enctype="multipart/form-data" autocomplete="new-password">
            @csrf

            <div class="grid gap-4 mb-2 sm:grid-cols-2">
                <div class="flex">
                    <div class="w-full flex flex-col">
                        <label for="client_num" class="block dark:text-gray-100 text-gray-900 leading-none mt-4 text-sm">顧客番号</label>
                        <input type="text" name="client_num" tabindex="-1" class="input-primary cursor-not-allowed" id="client_num" value="{{ $clientNum }}" placeholder="顧客検索してください" readonly>
                    </div>

                    <button type="button" onclick="showModal()" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[34px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>

                <div class="">
                    <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4 text-sm">顧客名称</label>
                    <input type="text" name="client_name" tabindex="-1" class="input-primary cursor-not-allowed" id="client_name" value="{{ $clientName }}" readonly>
                </div>
                @error('client_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">追加フォーム</button>
                    </li>
                </ul>
            </div>

            <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                {{-- <button type="button" id="searchProductButton" onclick="showProductModal()" autofocus tabindex="1" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <span class="text-ms">製品検索</span>
                </button> --}}

                <div class="grid gap-4 mb-4 sm:grid-cols-4 mt-2">
                    <div class="flex">
                        <div class="w-full">
                            <label for="productSeries" class="block mb-1 text-sm text-gray-900 dark:text-white">シリーズ</label>
                            <select id="productSeries" name="productSeries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed pointer-events-none" readonly>
                                <option value="" >---</option>
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
                        <button type="button" onclick="showProductModal()" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[26px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>


                    <div>
                        <label for="split_type_name" class="block mb-1 text-sm text-gray-900 dark:text-white">内訳種別</label>
                        <select id="split_type_name" name="split_type_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed pointer-events-none" readonly>
                            <option value="" >---</option>
                            @foreach ($productSplitTypes as $productSplitType)
                            <option value="{{ $productSplitType->id }}" @selected($productSplitType->id == old('productSplitTypeId')) disabled>
                                {{ $productSplitType->split_type_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div hidden>
                        <label for="product_code" class="block mb-1 text-sm text-gray-900 dark:text-white">製品コード</label>
                        <input type="text" name="product_code" id="product_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed" readonly>
                    </div>
                    <div class="col-span-2">
                        <label for="product_name" class="block mb-1 text-sm text-gray-900 dark:text-white">製品名称</label>
                        <input type="text" name="product_name" id="product_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed" placeholder="製品検索をしてください" inert>
                    </div>
                </div>

                <div class="grid gap-4 mb-4 sm:grid-cols-4 mt-4">
                    <div>
                        <label for="product_version_id" class="block text-sm text-gray-900 dark:text-white">バージョン</label>
                        <select id="product_version_id" name="product_version_id" tabindex="1" class="input-primary">
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
                        <select id="is_customized" name="is_customized" tabindex="2" class="input-primary">
                            <option selected value="0">標準</option>
                            <option value="1">CUS</option>
                        </select>
                        @error('is_customized')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="is_contracted" class="block text-sm text-gray-900 dark:text-white">契約区分</label>
                        <select id="is_contracted" name="is_contracted" tabindex="3" class="input-primary">
                            <option value="0">未契約</option>
                            <option selected value="1">契約済</option>
                        </select>
                        @error('is_contracted')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="quantity" class="block text-sm text-gray-900 dark:text-white">数量</label>
                        <input type="number" min="1" tabindex="4" name="quantity" id="quantity" value="1" class="input-primary" required="">
                    </div>
                    @error('quantity')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="sm:col-span-4">
                        <label for="install_memo" class="block text-sm text-gray-900 dark:text-white">備考</label>
                        <textarea id="install_memo" name="install_memo" tabindex="5" rows="4" class="input-primary"></textarea>
                    </div>
                    @error('install_memo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex">
                    <x-primary-button class="" tabindex="6">
                        新規登録する
                    </x-primary-button>
                    <div class="flex items-center ml-4 ">
                        <input checked id="checked-checkbox" type="checkbox" name="action" value="save_and_continue" tabindex="6" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ms-2 text-sm text-gray-900 dark:text-gray-300">続けて登録</label>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Extra Large Modal -->
    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-7xl">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl text-gray-900 dark:text-white">
                        顧客検索画面
                    </h3>
                    <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="#">
                    <!-- 検索条件入力フォーム -->
                    <div class="grid gap-2 mb-4 sm:grid-cols-3">
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientName" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                            <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientNumber" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                            <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="departmentId" class=" dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
                            <select id="departmentId" name="departmentId" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}" @selected($department->id == Auth::user()->affiliation2->id)>
                                    {{ $department->department_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                <div class=" max-h-80 overflow-y-auto overflow-x-hidden">
                    <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                        <thead>
                        <tr>
                            {{-- <th class="py-1"></th> --}}
                            <th class="py-1 pl-5">顧客名称</th>
                            <th class="py-1 whitespace-nowrap">顧客番号</th>
                            <th class="py-1 whitespace-nowrap">管轄事業部</th>
                        </tr>
                        </thead>
                        <tbody class="" id="searchResultsContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="searchClient()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        検索
                    </button>
                    <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                </div>
            </div>
        </div>
    </div>


    <!-- Main modal -->
    <div id="searchProduct" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-blue-400  rounded dark:bg-gray-800 sm:p-5 shadow-xl ">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg text-gray-900 dark:text-white">
                        製品検索
                    </h3>
                    {{-- <button type="button" onclick="hideProductModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button> --}}
                </div>
                <!-- Modal body -->
                <form action="#">
                    <div class="grid gap-4 mb-4 sm:grid-cols-3">
                        <div>
                            <label for="productName" class="block mb-2 text-sm text-gray-900 dark:text-white">製品名称</label>
                            <input type="text" id="productName" name="productName"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="製品名称">
                        </div>
                        <div>
                            <label for="productSeriesId" class="block mb-2 text-sm text-gray-900 dark:text-white">シリーズ</label>
                            <select id="productSeriesId" name="productSeriesId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="" value="">未選択</option>
                                @foreach ($productSeries as $productSeries)
                                    <option value="{{ $productSeries->id }}" @selected($productSeries->id == old('productSeriesId'))>
                                        {{ $productSeries->series_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="productSplitTypeId" class="block mb-2 text-sm text-gray-900 dark:text-white">内訳種別</label>
                            <select id="productSplitTypeId" name="productSplitTypeId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="" value="">未選択</option>
                                @foreach ($productSplitTypes as $productSplitType)
                                    <option value="{{ $productSplitType->id }}" @selected($productSplitType->id == old('productSplitTypeId'))>
                                        {{ $productSplitType->split_type_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                <div class=" max-h-80 overflow-y-auto overflow-x-hidden">
                    <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                        <thead>
                        <tr>
                            {{-- <th class="py-1"></th> --}}
                            <th class="py-1 pl-5">製品名称</th>
                            <th class="py-1 whitespace-nowrap">シリーズ</th>
                            <th class="py-1 whitespace-nowrap">内訳種別</th>
                        </tr>
                        </thead>
                        <tbody class="" id="searchResultsProductContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="searchProduct()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        検索
                    </button>
                    <button type="button" id="closeModalBtn" onclick="hideProductModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                </div>
            </div>
        </div>
    </div>


    <script>
        const overlay = document.getElementById('overlay')
        const clientSearchModal =document.getElementById('clientSearchModal')
        const searchProductModal = document.getElementById('searchProduct');

        // 顧客検索モーダルを表示するための関数
        function showModal() {
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            clientSearchModal.classList.remove('hidden');
        }

        // 顧客検索モーダルを非表示にするための関数
        function hideModal() {
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            clientSearchModal.classList.add('hidden');
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
                        <td class="py-2 ml-2">${result.affiliation2.affiliation2_name}</td>
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
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            searchProductModal.classList.remove('hidden');

            // モーダル内のコンテンツ要素を取得
            const modalContent = searchProductModal.querySelector('.bg-blue-400');

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

    // 製品検索モーダルを非表示にする
        function hideProductModal() {
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            searchProductModal.classList.add('hidden');

            const ProductButton = document.getElementById('searchProductButton');
            ProductButton.focus();

            // モーダル内のコンテンツ要素からTabキーイベントリスナーを削除
            const modalContent = searchProductModal.querySelector('.bg-blue-400');
            modalContent.removeEventListener('keydown', trapTabKey);
        }


    //製品検索ボタンを押下した際の処理
        function searchProduct() {
            const productName = document.getElementById('productName').value;
            const productSeriesId = document.getElementById('productSeriesId').value;
            const productSplitTypeId = document.getElementById('productSplitTypeId').value;

            fetch('/products/search', {
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