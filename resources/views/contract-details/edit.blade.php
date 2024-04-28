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
        <form id="form1" method="post" action="{{ route('contracts.details.update', ['contract' => $contract, 'contractDetail' => $contractDetail]) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
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
                            <option value="{{ $contractChangeType->id }}"  @selected($contractChangeType->id == old('contract_change_type_id', $contractDetail->contract_change_type_id))>{{ $contractChangeType->contract_change_type_name }}</option>
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
                            <option value="{{ $contractUpdateType->id }}"  @selected($contractUpdateType->id == old('contract_update_type_id', $contractDetail->contract_update_type_id))>{{ $contractUpdateType->contract_update_type_name }}</option>
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
                            <option value="{{ $contractSheetStatus->id }}"  @selected($contractSheetStatus->id == old('contract_sheet_status_id', $contractDetail->contract_sheet_status_id))>{{ $contractSheetStatus->contract_sheet_status_name }}</option>
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
                            <option value="{{ $contractPartnerType->id }}"  @selected($contractPartnerType->id == old('contract_partner_type_id', $contractDetail->contract_partner_type_id))>{{ $contractPartnerType->contract_partner_type_name }}</option>
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
                        <input type="date" min="1900-01-01" max="2200-12-31" name="contract_start_at" id="contract_start_at" value="{{ old('contract_start_at', $contractDetail->contract_start_at) }}" class="input-primary">
                        @error('contract_start_at')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="contract_end_at" class="dark:text-gray-100 text-gray-900">契約終了日</label>
                        <input type="date" min="1900-01-01" max="2200-12-31" name="contract_end_at" id="contract_end_at" value="{{ old('contract_end_at', $contractDetail->contract_end_at) }}" class="input-primary">
                        @error('contract_end_at')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="contract_amount" class="dark:text-gray-100 text-gray-900">契約金額</label>
                    <input type="text" onblur="formatNumberInput(this);" maxlength="100" name="contract_amount" id="contract_amount" value="{{old('contract_amount', number_format($contractDetail->contract_amount))}}" class="input-primary">
                    @error('contract_amount')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

    
                <div class="w-full flex flex-col">
                    <label for="target_system" class="dark:text-gray-100 text-gray-900 leading-none mt-4 mb-1">対象システム</label>
                    <textarea name="target_system" id="target_system" class="input-primary" data-auto-resize="true"  cols="30" rows="4" data-auto-resize="true">{{ old('target_system', $contractDetail->target_system) }}</textarea>
                    @error('target_system')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="contract_detail_memo" class="dark:text-gray-100 text-gray-900 leading-none mt-4 mb-1">契約詳細備考</label>
                    <textarea name="contract_detail_memo" id="contract_detail_memo" class="input-primary" data-auto-resize="true"  cols="30" rows="4" data-auto-resize="true">{{ old('contract_detail_memo', $contractDetail->contract_detail_memo) }}</textarea>
                    @error('contract_detail_memo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid gap-4 my-4 md:grid-cols-5">
                    <div class="">
                        <label for="project_num" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクト№</label>
                        <div class="relative w-full">
                            <input type="text" name="project_num" id="project_num" value="{{old('project_num', optional($contractDetail->project)->project_num)}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" readonly>
                            <button type="button" onclick="showProjectModal()" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-[34px] text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="hidden">
                        <label for="project_id" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクトID（非表示）</label>
                        <input type="text" maxlength="100" name="project_id" id="project_id" value="{{old('project_id', $contractDetail->project_id)}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1">
                        @error('project_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div  class="md:col-span-2">
                        <label for="project_name" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクト名称</label>
                        <input type="text" maxlength="100" name="project_name" id="project_name" value="{{old('project_name', optional($contractDetail->project)->project_name)}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                        @error('project_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="account_user" class="dark:text-gray-100 text-gray-900 leading-none mt-1">営業担当</label>
                        <input type="text" maxlength="100" name="account_user" id="account_user" value="{{ old('account_user', optional(optional($contractDetail->project)->accountUser)->user_name) }}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                        @error('account_user')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="sales_stage_name" class="dark:text-gray-100 text-gray-900 leading-none mt-1">営業段階</label>
                        <input type="text" maxlength="100" name="sales_stage_name" id="sales_stage_name" value="{{old('sales_stage_name', optional(optional($contractDetail->project)->salesStage)->sales_stage_name)}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                        @error('sales_stage_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="hidden">
                        <div class="w-full flex flex-col">
                            <label for="client_name" class="dark:text-white text-red-700 leading-none text-sm">顧客名称（非表示）<span class="text-red-500"> *</span></label>
                            <input type="text" name="client_name" class="input-primary" id="client_name" value="{{old('client_name')}}" placeholder="">
                        </div>
                        @error('client_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                </div>


                <div class="flex">
                    <div class="dark:text-white text-red-700 leading-none text-sm mt-4 mb-1">契約書</div>
                    <button data-tooltip-target="tooltip-right" data-tooltip-placement="top" data-tooltip-trigger="hover" type="button" class="ms-3 my-auto mb-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-1.5 py-[1px] text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        ?
                    </button>
                </div>
    
                <div id="tooltip-right" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-1.5 text-sm font-medium text-white bg-gray-900 rounded-xl shadow-sm opacity-0 tooltip dark:bg-gray-600">
                    <span class="text-xs">
                        ファイル名は自動生成されます。
                        <br>
                        例）PJ№_顧客名称_消去予定日_アップロード日時.pdf
                    </span>
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <div class="relative flex items-center justify-center w-full">
                    <input type="file" name="attachments" id="file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 z-10 " onchange="displayFileInfo()" />
                    <label for="attachments" class="dark:bg-gray-900flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-bray-800 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p id="file-info" class="mb-2 text-xs md:text-sm text-gray-500 dark:text-gray-400 font-semibold">
                                クリックもしくはドラッグ＆ドロップでファイルを選択してください
                            </p>
                            <div class="md:w-auto md:ml-14" id="fileError">
                                @error('attachments')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </div> 
                        </div>
                    </label>
                </div>
    
                <div class="relative overflow-x-auto mt-8">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                            <tr>
                                <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">
                                    File name
                                </th>
                                <th scope="col" class="px-3 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    File size
                                </th>
                                <th scope="col" class="px-3 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    download
                                </th>
                                <th scope="col" class="px-3 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attachments as $attachment)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white border-x border-gray-600">
                                    {{ basename($attachment->file_path) }}
                                </th>
                                <td class="px-3 py-2 border-x text-center border-gray-600">
                                    {{ \App\Common\CommonFunction::formatBytes($attachment->file_size) }}
                                </td>
                                <td class="px-3 py-2 text-center border-x border-gray-600">
                                    @if ($contractDetail->contract_pdf) 
                                    {{-- ブラウザの別タブで一旦表示ボタン --}}
                                        <button type="button" class="button-edit" onclick="window.open('{{ asset('storage/' . $attachment->file_path) }}', '_blank');">
                                            <div class="flex items-center">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/>
                                                </svg>
                                            </div>
                                        </button>
    
                                    {{-- 直ダウンロードボタン --}}
                                        {{-- <a href="{{ asset('storage/' . $contractDetail->pdf_file) }}" download class="button-edit inline-block">
                                            <div class="flex items-center">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/>
                                                </svg>
                                            </div>
                                        </a> --}}
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-center">
                                    @if ($contractDetail->contract_pdf)
                                        <button type="button" data-modal-target="deleteModal" data-modal-show="deleteModal" class="button-delete-primary">
                                            <div class="flex">
                                                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                <span class="text-ms ">削除</span>
                                            </div>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        function displayFileInfo() {
            const fileInput = document.getElementById('file');
            const fileInfo = document.getElementById('file-info');
            const ErrorMessage =   document.getElementById('fileError');

            ErrorMessage.style.display = 'none';
        
            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                const fileSize = (fileInput.files[0].size / 1024).toFixed(2); // Convert to KB with 2 decimal places
                const fileType = fileInput.files[0].type;
        
                fileInfo.innerHTML = `<span class="font-semibold text-md text-blue-600">ファイル名称： ${fileName}</span></br><span class="font-semibold text-md text-blue-600">ファイルサイズ： ${fileSize} KB</span></br><span class="font-semibold text-md text-blue-600">ファイル形式： ${fileType}</span>`;
            }
        }
    </script>

    <script>
        // 新規登録ボタンにフォーカスが当たった時に呼び出される関数
        function stopTab(event) {
            if (event.keyCode === 9 && !event.shiftKey) { // タブキーが押された場合かつShiftキーが押されていない場合
                event.preventDefault(); // イベントをキャンセルする
            }
        }
    </script>

</x-app-layout>