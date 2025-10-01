<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('CreateContractDetail', $contract) }}
            </h2>
            <div class="ml-auto flex ">
                <form id="createForm" method="post" action="{{ route('contracts.details.store', ['contract' => $contract]) }}" enctype="multipart/form-data">
                    @csrf
                    <x-buttons.save-button form-id="createForm" onkeydown="stopTab(event)" id="saveButton">
                        {{ __('save') }}
                    </x-buttons.save-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-4">
        <div class="p-2 md:p-8 rounded bg-gray-50 shadow-md dark:bg-gray-800" >
            <!-- header -->
            <div class="flex justify-between items-center md:pb-4 pb-2 rounded-t border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    契約詳細
                </h3>
            </div>
            <!-- body -->

            <div class="grid gap-4 my-4 md:grid-cols-4">
                <div>
                    <label for="contract_change_type_id" class="text-gray-900 dark:text-white">更新種別</label>
                    <select form="createForm" name="contract_change_type_id" id="contract_change_type_id" value="{{old('contract_change_type_id')}}" class="input-primary">
                        @foreach($contractChangeTypes as $contractChangeType)
                        <option value="{{ $contractChangeType->id }}"  @selected($contractChangeType->id == old('contract_change_type_id'))>{{ $contractChangeType->contract_change_type_name }}</option>
                        @endforeach
                    </select>
                    @error('contract_change_type_id_')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <label for="contract_update_type_id" class="text-gray-900 dark:text-white">自動 / 都度</label>
                    <select form="createForm" name="contract_update_type_id" id="contract_update_type_id" value="{{old('contract_update_type_id')}}" class="input-primary">
                        @foreach($contractUpdateTypes as $contractUpdateType)
                        <option value="{{ $contractUpdateType->id }}"  @selected($contractUpdateType->id == old('contract_update_type_id'))>{{ $contractUpdateType->contract_update_type_name }}</option>
                        @endforeach
                    </select>
                    @error('contract_update_type_id_')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <label for="contract_sheet_status_id" class="text-gray-900 dark:text-white">契約書状態</label>
                    <select form="createForm" name="contract_sheet_status_id" id="contract_sheet_status_id" value="{{old('contract_sheet_status_id')}}" class="input-primary">
                        @foreach($contractSheetStatuses as $contractSheetStatus)
                        <option value="{{ $contractSheetStatus->id }}"  @selected($contractSheetStatus->id == old('contract_sheet_status_id'))>{{ $contractSheetStatus->contract_sheet_status_name }}</option>
                        @endforeach
                    </select>
                    @error('contract_sheet_status_id_')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <label for="contract_partner_type_id" class="text-gray-900 dark:text-white">契約先区分</label>
                    <select form="createForm" name="contract_partner_type_id" id="contract_partner_type_id" value="{{old('contract_partner_type_id')}}" class="input-primary">
                        @foreach($contractPartnerTypes as $contractPartnerType)
                        <option value="{{ $contractPartnerType->id }}"  @selected($contractPartnerType->id == old('contract_partner_type_id'))>{{ $contractPartnerType->contract_partner_type_name }}</option>
                        @endforeach
                    </select>
                    @error('contract_partner_type_id_')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>

            </div>

            <div class="grid gap-4 md:grid-cols-2 mt-4">
                <div>
                    <label for="contract_start_at" class="dark:text-gray-100 text-gray-900">契約開始日</label>
                    <input form="createForm" type="date" min="1900-01-01" max="2200-12-31" 
                        name="contract_start_at" id="contract_start_at" 
                        value="{{ old('contract_start_at') }}" 
                        class="input-primary">
                    @error('contract_start_at')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="contract_end_at" class="dark:text-gray-100 text-gray-900">契約終了日</label>
                    <input form="createForm" type="date" min="1900-01-01" max="2200-12-31" 
                        name="contract_end_at" id="contract_end_at" 
                        value="{{ old('contract_end_at') }}" 
                        class="input-primary">
                    @error('contract_end_at')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="contract_amount" class="dark:text-gray-100 text-gray-900">契約金額</label>
                <input form="createForm" type="text" onblur="formatNumberInput(this);" maxlength="100" name="contract_amount" id="contract_amount" value="{{old('contract_amount')}}" class="input-primary">
                @error('contract_amount')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>


            <div class="w-full flex flex-col">
                <label for="target_system" class="dark:text-gray-100 text-gray-900 leading-none mt-4 mb-1">対象システム</label>
                <textarea form="createForm" name="target_system" id="target_system" class="input-primary" data-auto-resize="true"  cols="30" rows="4" data-auto-resize="true">{{ old('target_system') }}</textarea>
                @error('target_system')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full flex flex-col">
                <label for="contract_detail_memo" class="dark:text-gray-100 text-gray-900 leading-none mt-4 mb-1">契約詳細備考</label>
                <textarea form="createForm" name="contract_detail_memo" id="contract_detail_memo" class="input-primary" data-auto-resize="true"  cols="30" rows="4" data-auto-resize="true">{{ old('contract_detail_memo') }}</textarea>
                @error('contract_detail_memo')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid gap-4 my-4 md:grid-cols-5">
                <div class="">
                    <label for="project_num" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクト№</label>
                    <div class="relative w-full">
                        <input form="createForm" type="text" name="project_num"  id="project_num" value="{{old('project_num')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" readonly>
                        <button type="button" id="searchProjectButton" onclick="ProjectSearchModal.show('projectSearchModal1')" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-[34px] text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="hidden">
                    <label for="project_id" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクトID（非表示）</label>
                    <input form="createForm" type="text" maxlength="100" name="project_id" id="project_id" value="{{old('project_id')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1">
                    @error('project_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div  class="md:col-span-2">
                    <label for="project_name" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクト名称</label>
                    <input form="createForm" type="text" maxlength="100" name="project_name" id="project_name" value="{{old('project_name')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                    @error('project_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="account_user" class="dark:text-gray-100 text-gray-900 leading-none mt-1">営業担当</label>
                    <input form="createForm" type="text" maxlength="100" name="account_user" id="account_user" value="{{old('account_user')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                    @error('account_user')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="sales_stage_name" class="dark:text-gray-100 text-gray-900 leading-none mt-1">営業段階</label>
                    <input form="createForm" type="text" maxlength="100" name="sales_stage_name" id="sales_stage_name" value="{{old('sales_stage_name')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                    @error('sales_stage_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>



    <x-modals.project-search-modal 
    modalId="projectSearchModal1" 
    screenId="keepfile_create" 
    :users="$users" 
    onSelectCallback="handleProjectSelect" 
    />

    <script>
        // プロジェクト選択時の処理を定義
        function handleProjectSelect(project) {
            // 選択されたプロジェクトの情報を各フィールドに設定
            document.getElementById('project_id').value = project.id;
            document.getElementById('project_num').value = project.project_num;
            document.getElementById('project_name').value = project.project_name;
            // document.getElementById('project_client_name').value = project.client.client_name;
            document.getElementById('account_user').value = project.account_user.user_name;
            document.getElementById('sales_stage_name').value = project.sales_stage.sales_stage_name;
        }
        // モーダルのコールバック関数を設定
        window.projectSearchModal1_onSelect = handleProjectSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/project-search-modal.js') }}"></script>



    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/searchProject.js') }}"></script>


    <script>
        // 新規登録ボタンにフォーカスが当たった時に呼び出される関数
        function stopTab(event) {
            if (event.keyCode === 9 && !event.shiftKey) { // タブキーが押された場合かつShiftキーが押されていない場合
                event.preventDefault(); // イベントをキャンセルする
            }
        }
    </script>



<script>
    document.getElementById('contract_start_at').addEventListener('change', function () {
        const startDate = this.value;
        if (!startDate) return;

        let start = new Date(startDate);
        // 1年後に設定
        let end = new Date(start);
        end.setFullYear(end.getFullYear() + 1);
        // 1日引く
        end.setDate(end.getDate() - 1);

        // 日付をYYYY-MM-DD形式に整形
        const yyyy = end.getFullYear();
        const mm = String(end.getMonth() + 1).padStart(2, '0');
        const dd = String(end.getDate()).padStart(2, '0');
        document.getElementById('contract_end_at').value = `${yyyy}-${mm}-${dd}`;
    });
</script>

</x-app-layout>