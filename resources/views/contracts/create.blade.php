<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="text-sm text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('createContract') }}
            </h2>
        </div>
    </x-slot>

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

                
            <input type="text" form="storeForm" name="client_id" id="client_id" class="hidden" value="{{old('client_id')}}" placeholder="顧客ID（非表示）">
            
            <div>
                <div>
                    <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                    <input type="text" name="client_name" class="input-readonly" id="client_name" value="{{old('client_name')}}" placeholder="顧客検索してください" readonly>
                </div>
                @error('client_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="department_path" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">所属部門</label>
                <input type="text" id="department_path" name="department_path" class="input-readonly" value="{{ old('department_path') }}" placeholder="顧客検索してください" readonly>
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

        <form id="storeForm" method="post" action="{{route('contracts.store')}}" enctype="multipart/form-data">
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
            document.getElementById('department_path').value = client.department ? client.department.path : '';
            // document.getElementById('sales_user').value = client.user.user_name;
        }

        // モーダルのコールバック関数を設定
        window.clientSearchModal1_onSelect = handleClientSelect;
    </script>

    <script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>

</x-app-layout>