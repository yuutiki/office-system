<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="text-sm text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('createContract') }}
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="mx-4 sm:pl-12 lg:w-1/2 lg:mx-auto">
        <!-- 顧客検索ボタン -->
        <button type="button" onclick="ClientSearchModal.show('clientSearchModal1')" class="md:ml-1 mt-12 mb-2 w-full whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            顧客検索
        </button>
        <div class="grid gap-4 mt-6 mb-4 sm:grid-cols-1">
            <div>
                <div class="">
                    <label for="corporation_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人名称</label>
                    <input type="text" name="corporation_name" class="input-readonly" id="corporation_name" value="{{old('corporation_name')}}" placeholder="顧客検索してください" readonly>
                </div>
                @error('corporation_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="hidden">
                <div>
                    <label for="client_id" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客ID（非表示）</label>
                    <input form="storeForm" type="text" name="client_id" id="client_id" value="{{old('client_id')}}" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1">
                </div>
                @error('client_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <div class="">
                    <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                    <input type="text" name="client_name" class="input-readonly" id="client_name" value="{{old('client_name')}}" placeholder="顧客検索してください" readonly>
                </div>
                @error('client_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="affiliation2_id" class="block text-sm  text-gray-900 dark:text-white leading-none md:mt-2">管轄事業部</label>
                <select id="affiliation2_id" name="affiliation2_id" class="input-readonly" readonly>
                    <option value="">未選択</option>
                    @foreach($affiliation2s as $affiliation2)
                    <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('affiliation2_id'))>{{ $affiliation2->affiliation2_name }}</option>
                    @endforeach
                </select>
                @error('affiliation2_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="contract_type_id" class="text-sm text-gray-900 dark:text-red-400 leading-none mt-4">契約種別</label>
                <select form="storeForm" id="contract_type_id" name="contract_type_id" class="input-primary">
                    <option value="">未選択</option>
                    @foreach($contractTypes as $contractType)
                    <option value="{{ $contractType->id }}" @selected($contractType->id == old('contract_type_id'))>{{ $contractType->contract_type_name }}</option>
                    @endforeach
                </select>
                @error('contract_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <form id="storeForm" method="post" action="{{route('contracts.store')}}" enctype="multipart/form-data" autocomplete="new-password">
            @csrf
            <x-primary-button class="mt-4 " form="storeForm" id="saveButton">
                登録して遷移(s)
            </x-primary-button>
        </form>
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
            // document.getElementById('client_num').value = client.client_num;
            document.getElementById('corporation_name').value = client.corporation.corporation_name;
            document.getElementById('client_id').value = client.id;
            document.getElementById('client_name').value = client.client_name;
            document.getElementById('affiliation2_id').value = client.affiliation2_id;
            // document.getElementById('sales_user').value = client.user.user_name;
        }

        // モーダルのコールバック関数を設定
        window.clientSearchModal1_onSelect = handleClientSelect;
    </script>

    <script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>



    {{-- <script>
        // モーダルを表示するための関数
        function showModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('clientSearchModal');
            //背後の操作不可を有効
            const overlay = document.getElementById('overlay').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
        }

        // モーダルを非表示にするための関数
        function hideModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('clientSearchModal');
            //背後の操作不可を解除
            const overlay = document.getElementById('overlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // モーダルを非表示にするためのクラスを削除
            modal.classList.add('hidden');
        }

        // 検索ボタンを押した時の処理
        function searchClient() {
            const clientName = document.getElementById('clientName').value;
            const clientNumber = document.getElementById('clientNumber').value;
            const affiliation2Id = document.getElementById('affiliation2Id').value;

            fetch('/client/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ clientName, clientNumber, affiliation2Id })
            })
            .then(response => response.json())
            .then(data => {
                const searchResultsContainer = document.getElementById('searchResultsContainer');
                searchResultsContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.corporation.corporation_name}', '${result.id}', '${result.client_name}', '${result.affiliation2_id}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.affiliation2.affiliation2_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setClient(corporationName, clientId, clientname, affiliation2) {
            document.getElementById('corporation_name').value = corporationName;
            document.getElementById('client_id').value = clientId;
            document.getElementById('client_name').value = clientname;
            document.getElementById('affiliation2_id').value = affiliation2;
            // document.getElementById('installation_type_id').value = installation;
            // document.getElementById('client_type_id').value = clienttype;
            // document.getElementById('user_id').value = user;

            hideModal();
            }
    </script> --}}

</x-app-layout>