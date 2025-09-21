<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('createKeepfile', $searchParams) }}
            </h2>
            <div class="ml-auto flex justify-end">
                <form method="post" action="{{route('keepfiles.store')}}" enctype="multipart/form-data" id="keepfileForm">
                    @csrf
                    <x-button-save form-id="keepfileForm" id="saveButton" onkeydown="stopTab(event)">
                        {{ __('save') }}
                    </x-button-save>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">基本情報</button>
                </li>
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">
            <label class="relative inline-flex items-center cursor-pointer my-6">
                <input type="hidden" form="keepfileForm" name="is_finished" id="is_finished" value="0">
                <input type="checkbox" form="keepfileForm" name="is_finished" id="is_finished" value="1" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">完了</span>
            </label>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="w-full flex">
                    <div class="w-full flex flex-col">
                        <label for="project_num" class="dark:text-white text-red-700 leading-none text-sm">プロジェクト№<span class="text-red-500"> *</span></label>
                        <input type="text" form="keepfileForm" name="project_num" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="project_num" value="{{old('project_num')}}" placeholder="検索してください" required readonly>
                        @error('project_num')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <button type="button" id="searchPJ" onclick="ProjectSearchModal.show('projectSearchModal1')" class="p-2.5 text-sm font-medium h-[34px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 pb-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
                <div class="hidden">
                    <label for="project_id" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクトID（非表示）</label>
                    <input type="text" form="keepfileForm" maxlength="100" name="project_id" id="project_id" value="{{ old('project_id') }}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1">
                    @error('project_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror   
                </div>
                {{-- <div class="hidden">
                    <label for="account_user" class="dark:text-gray-100 text-gray-900 leading-none mt-1">営業担当（非表示）</label>
                    <input type="text" maxlength="100" name="account_user" id="account_user" value="{{old('account_user')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1" readonly>
                    @error('account_user')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div> --}}
                <div class="w-full flex flex-col">
                    <label for="client_name" class="dark:text-white text-red-700 leading-none text-sm">顧客名称<span class="text-red-500"> *</span></label>
                    <input type="text" form="keepfileForm" name="client_name" class="input-readonly" id="client_name" value="{{old('client_name')}}" placeholder="" readonly>
                    @error('client_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="w-full flex flex-col mt-4">
                <label for="project_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm">プロジェクト名称<span class="text-red-500"> *</span></label>
                <input type="text" form="keepfileForm" maxlength="100" name="project_name" id="project_name" value="{{old('project_name')}}" class="input-readonly" tabindex="-1" readonly>
                @error('project_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid gap-4 md:grid-cols-2 mt-4">
                <div class="w-full flex flex-col">
                    <label for="keep_at" class="dark:text-white text-red-700 leading-none text-sm">預託日<span class="text-red-500"> *</span></label>
                    <input type="date" form="keepfileForm" id="keep_at" name="keep_at" value="{{ old('keep_at', now()->format('Y-m-d')) }}" min="2000-01-01" max="2100-12-31" class="input-primary">
                    @error('keep_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="return_at" class="dark:text-white text-red-700 leading-none text-sm">預託終了予定日<span class="text-red-500"> *</span></label>
                    <input type="date" form="keepfileForm" min="2000-01-01" max="2100-12-31" name="return_at" class="input-primary" id="return_at" value="{{old('return_at')}}">
                    @error('return_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 mt-4">
                <div class="w-full flex flex-col">
                    <label for="purpose" class="dark:text-white text-red-700 leading-none text-sm">目的<span class="text-red-500"> *</span></label>
                    <input type="text" form="keepfileForm" name="purpose" class="input-secondary" id="purpose" value="{{old('purpose')}}" placeholder="バージョンアップのため">
                    @error('purpose')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                {{-- <div class="w-full flex flex-col">
                    <label for="depositor" class="text-sm text-gray-900 dark:text-white leading-none">取得者<span class="text-red-500"> *</span></label>
                    <select id="depositor" form="keepfileForm" name="depositor" class="input-secondary">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected($user->id == old('depositor' ,Auth::user()->id))>{{ $user->user_name }}</option>
                        @endforeach
                    </select>
                    @error('depositor')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div> --}}
                <div id="user-dropdown" class="relative w-full flex flex-col">
                    <label for="purpose" class="dark:text-white text-red-700 leading-none text-sm">取得者<span class="text-red-500"> *</span></label>
                    <input type="hidden" form="keepfileForm" id="selected-user-id" name="depositor" value="{{ old('depositor') }}">
                    <button type="button" id="dropdown-toggle" class="block w-full p-1.5 pl-4 mt-1 text-sm text-left text-gray-900 rounded bg-white hover:bg-gray-100 focus:border-blue-500 dark:bg-gray-100 dark:border-gray-600 border-gray-900 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <span id="selected-user-display" class="text-gray-800 whitespace-nowrap">
                            @if(old('depositor'))
                                @php
                                    $oldSelectedUser = \App\Models\User::find(old('depositor'));
                                @endphp
                                {{ $oldSelectedUser ? $oldSelectedUser->user_name : 'ユーザーを選択' }}
                            @elseif(isset($defaultUserId) && $defaultUserId)
                                @php
                                    $defaultUser = \App\Models\User::find($defaultUserId);
                                @endphp
                                {{ $defaultUser ? $defaultUser->user_name : 'ユーザーを選択' }}
                            @else
                                ユーザーを選択
                            @endif
                        </span>
                        <span class="absolute inset-y-0 right-0 flex items-center pt-4 pr-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <div id="dropdown-menu" class="absolute z-10 w-full mt-16 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg hidden">
                        <div class="p-2">
                            <input id="user-search" type="text" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-800 dark:text-white" placeholder="ユーザーを検索...">
                        </div>
                        <ul id="user-list" class="max-h-60 overflow-auto dark:text-white text-gray-700 hover:dark:text-white">
                            <!-- ユーザーリストはJavaScriptで動的に追加されます -->
                            <script src="{{ asset('assets/js/user-dropdown.js') }}"></script>
                        </ul>
                    </div>
                    @error('depositor')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="return_method" class="dark:text-white text-red-700 leading-none text-sm">最終処理方法（）<span class="text-red-500"> *</span></label>
                    <input type="text" form="keepfileForm" name="return_method" class="input-secondary" id="return_method" value="{{old('return_method')}}" placeholder="消去、破棄、返却">
                    @error('return_method')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="deposit_method" class="dark:text-white text-red-700 leading-none text-sm">預託方法（）<span class="text-red-500"> *</span></label>
                    <input type="text" form="keepfileForm" name="deposit_method" class="input-secondary" id="deposit_method" value="{{old('deposit_method')}}" placeholder="手入力">
                    @error('deposit_method')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="has_personal_info" class="dark:text-white text-red-700 leading-none text-sm">個人情報有無（）<span class="text-red-500"> *</span></label>
                    <input type="text" form="keepfileForm" name="has_personal_info" class="input-secondary" id="has_personal_info" value="{{old('has_personal_info')}}" placeholder="含む、含まない">
                    @error('has_personal_info')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="deposit_data" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">預託データ内容（）</label>
                <textarea name="deposit_data" form="keepfileForm" class="input-secondary" id="deposit_data" data-auto-resize="true" cols="30" rows="5" placeholder="">{{old('deposit_data')}}</textarea>
                @error('deposit_data')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="w-full flex flex-col">
                <label for="keepfile_memo" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">備考</label>
                <textarea name="keepfile_memo" form="keepfileForm" class="input-secondary" id="keepfile_memo" data-auto-resize="true" cols="30" rows="5" placeholder="">{{old('keepfile_memo')}}</textarea>
                @error('keepfile_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>


            <p class="dark:text-white text-red-700 leading-none text-sm mt-4 mb-1">書類</p>
            <div class="relative flex items-center justify-center w-full">
                <input type="file" form="keepfileForm" name="pdf_file" id="pdf_file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 z-10 " onchange="displayFileInfo()" />
                <label for="pdf_file" class="dark:bg-gray-900flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-bray-800 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">

                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p id="file-info" class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-semibold">
                            クリックもしくはドラッグ＆ドロップでファイルを選択してください
                        </p>
                        <div class="md:w-auto md:ml-14" id="fileError">
                            @error('pdf_file')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div> 
                    </div>

                </label>
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
            document.getElementById('client_name').value = project.client.client_name;
            // document.getElementById('project_manager').value = project.user.user_name;
        }
        
        // モーダルのコールバック関数を設定
        window.projectSearchModal1_onSelect = handleProjectSelect;
    </script>

    {{-- プロジェクト検索モーダルのJavaScript --}}
    <script src="{{ asset('/assets/js/modal/project-search-modal.js') }}"></script>


    <script>
        function displayFileInfo() {
            const fileInput = document.getElementById('pdf_file');
            const fileInfo = document.getElementById('file-info');
            const ErrorMessage =   document.getElementById('fileError');

            ErrorMessage.style.display = 'none';
        
            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                const fileSize = (fileInput.files[0].size / 1024).toFixed(2); // Convert to KB with 2 decimal places
                const fileType = fileInput.files[0].type;
        
                fileInfo.innerHTML = `<span class="font-semibold text-md text-blue-600">ファイル名称： ${fileName}
                                        </span></br><span class="font-semibold text-md text-blue-600">ファイルサイズ： ${fileSize} KB
                                        </span></br><span class="font-semibold text-md text-blue-600">ファイル形式： ${fileType}</span>
                                    `;
            }
        }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const keepAt = document.getElementById('keep_at');
        const returnAt = document.getElementById('return_at');

        function updateReturnAtMin() {
            const keepAtValue = keepAt.value;
            if (keepAtValue) {
                returnAt.min = keepAtValue;
            }
        }

        function autoCorrectReturnAt() {
            const keepAtValue = keepAt.value;
            const returnAtValue = returnAt.value;

            // 入力完了後に補正する
            if (keepAtValue && returnAtValue && returnAtValue < keepAtValue) {
                returnAt.value = keepAtValue;

                // 任意：背景色で視覚的に補正を伝える（1秒だけ）
                returnAt.classList.add('bg-yellow-100', 'dark:bg-yellow-200');
                setTimeout(() => returnAt.classList.remove('bg-yellow-100', 'dark:bg-yellow-200'), 800);
            }
        }

        // 初期設定
        updateReturnAtMin();

        // 預託日が変更されたら min を更新
        keepAt.addEventListener('change', updateReturnAtMin);

        // フォーカスが外れたときにだけ補正
        returnAt.addEventListener('blur', autoCorrectReturnAt);
    });
</script>







    <script src="{{ asset('assets/js/stopTab.js') }}"></script>
    <script src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    {{-- <script src="{{ asset('/assets/js/searchProject.js') }}"></script> --}}
</x-app-layout>