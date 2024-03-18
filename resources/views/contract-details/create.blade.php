<x-app-layout>
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-4">
        <form id="form1" method="post" action="{{ route('contracts.details.store', ['contract' => $contract]) }}" enctype="multipart/form-data">
            @csrf
            <div class="p-2 md:p-8 rounded-lg bg-gray-50 shadow-md dark:bg-gray-800" >
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
                        <select name="contract_change_type_id" id="contract_change_type_id" value="{{old('contract_change_type_id')}}" class="input-primary">
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
                        <select name="contract_update_type_id" id="contract_update_type_id" value="{{old('contract_update_type_id')}}" class="input-primary">
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
                        <select name="contract_sheet_status_id" id="contract_sheet_status_id" value="{{old('contract_sheet_status_id')}}" class="input-primary">
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
                        <select name="contract_partner_type_id" id="contract_partner_type_id" value="{{old('contract_partner_type_id')}}" class="input-primary">
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
                        <input type="date" min="1900-01-01" max="2200-12-31" name="contract_start_at" id="contract_start_at" value="{{old('contract_start_at')}}" class="input-primary">
                        @error('contract_start_at')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="contract_end_at" class="dark:text-gray-100 text-gray-900">契約終了日</label>
                        <input type="date" min="1900-01-01" max="2200-12-31" name="contract_end_at" id="contract_end_at" value="{{old('contract_end_at')}}" class="input-primary">
                        @error('contract_end_at')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="contract_amount" class="dark:text-gray-100 text-gray-900">契約金額</label>
                    <input type="text" onblur="formatNumberInput(this);" maxlength="100" name="contract_amount" id="contract_amount" value="{{old('contract_amount')}}" class="input-primary">
                    @error('contract_amount')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

    
                <div class="w-full flex flex-col">
                    <label for="target_system" class="dark:text-gray-100 text-gray-900 leading-none mt-4 mb-1">対象システム</label>
                    <textarea name="target_system" id="target_system" class="input-primary" data-auto-resize="true"  cols="30" rows="4" data-auto-resize="true">{{ old('target_system') }}</textarea>
                    @error('target_system')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="contract_detail_memo" class="dark:text-gray-100 text-gray-900 leading-none mt-4 mb-1">契約詳細備考</label>
                    <textarea name="contract_detail_memo" id="contract_detail_memo" class="input-primary" data-auto-resize="true"  cols="30" rows="4" data-auto-resize="true">{{ old('contract_detail_memo') }}</textarea>
                    @error('contract_detail_memo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid gap-4 my-4 md:grid-cols-5">
                    <div class="">
                        <label for="project_num" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクト№</label>
                        <div class="relative w-full">
                            <input type="text" name="project_num"  id="project_num" value="{{old('project_num')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" readonly>
                            <button type="button" id="searchProjectButton" onclick="showProjectModal()" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-[34px] text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="hidden">
                        <label for="project_id" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクトID（非表示）</label>
                        <input type="text" maxlength="100" name="project_id" id="project_id" value="{{old('project_id')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1">
                        @error('project_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div  class="md:col-span-2">
                        <label for="project_name" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクト名称</label>
                        <input type="text" maxlength="100" name="project_name" id="project_name" value="{{old('project_name')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                        @error('project_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="account_user" class="dark:text-gray-100 text-gray-900 leading-none mt-1">営業担当</label>
                        <input type="text" maxlength="100" name="account_user" id="account_user" value="{{old('account_user')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                        @error('account_user')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="sales_stage_name" class="dark:text-gray-100 text-gray-900 leading-none mt-1">営業段階</label>
                        <input type="text" maxlength="100" name="sales_stage_name" id="sales_stage_name" value="{{old('sales_stage_name')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                        @error('sales_stage_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <x-primary-button class="mt-4" onkeydown="stopTab(event)" id="saveButton">
                    保存(S)
                </x-primary-button>
            </div>
        </form>
    </div>


    <!-- PJ検索 Modal -->
    <div id="projectSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-2xl">
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        プロジェクト検索画面
                    </h3>
                </div>

                <!-- Modal body -->
                <form action="#" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="grid gap-4 mb-4 sm:grid-cols-2 mt-2">
                        <div class="">
                            <label for="projectNumber" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none">プロジェクト№</label>
                            <input type="text" name="projectNumber" id="projectNumber" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="">
                            <label for="projectName" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none">プロジェクト名称</label>
                            <input type="text" name="projectName" id="projectName" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                    </div>
                </form>
                <div class=" max-h-80 overflow-y-auto overflow-x-hidden mt-4">
                    <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                        <thead>
                        <tr>
                            <th class="py-1 pl-5 whitespace-nowrap">プロジェクト№</th>
                            <th class="py-1">プロジェクト名称</th>
                        </tr>
                        </thead>
                        <tbody class="" id="searchResultsProjectContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="searchProject()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        検索
                    </button>
                    <button type="button" onclick="hideProjectModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                </div>
            </div>
        </div>
    </div>




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

</x-app-layout>