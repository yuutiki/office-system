<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createKeepfile', $searchParams) }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
                <form method="post" action="{{route('keepfile.store')}}" enctype="multipart/form-data" id="keepfileForm">
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
                    <input type="text" form="keepfileForm" maxlength="100" name="project_id" id="project_id" value="{{old('project_id')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1">
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
                    <label for="return_at" class="dark:text-white text-red-700 leading-none text-sm">消去予定日<span class="text-red-500"> *</span></label>
                    <input type="date" form="keepfileForm" min="2000-01-01" max="2100-12-31" name="return_at" class="input-primary" id="return_at" value="{{old('return_at')}}">
                    @error('return_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 mt-4">
                <div class="w-full flex flex-col">
                    <label for="purpose" class="dark:text-white text-red-700 leading-none text-sm">用途<span class="text-red-500"> *</span></label>
                    <input type="text" form="keepfileForm" name="purpose" class="input-secondary" id="purpose" value="{{old('purpose')}}" placeholder="バージョンアップのため">
                    @error('purpose')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="depositor" class="text-sm text-gray-900 dark:text-white leading-none">取得者<span class="text-red-500"> *</span></label>
                    <select id="depositor" form="keepfileForm" name="depositor" class="input-secondary">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected($user->id == old('depositor' ,Auth::user()->id))>{{ $user->user_name }}</option>
                        @endforeach
                    </select>
                    @error('depositor')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
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

    <script src="{{ asset('assets/js/stopTab.js') }}"></script>
    <script src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    {{-- <script src="{{ asset('/assets/js/searchProject.js') }}"></script> --}}
</x-app-layout>