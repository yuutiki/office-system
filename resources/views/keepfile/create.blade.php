<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createKeepfile') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>


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

            <label class="relative inline-flex items-center cursor-pointer mt-6">
                <input type="hidden" form="KeepfileForm" name="is_finished" id="is_finished" value="0">
                <input type="checkbox" form="KeepfileForm" name="is_finished" id="is_finished" value="1" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">完了</span>
            </label>


            <div class="grid gap-4 md:grid-cols-2">

                <div class="w-full flex">
                    <div class="w-full flex flex-col">
                        <label for="project_num" class="dark:text-white text-red-700 leading-none text-sm">プロジェクト№<span class="text-red-500"> *</span></label>
                        <input type="text" form="KeepfileForm" name="project_num" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="project_num" value="{{old('project_num')}}" placeholder="検索してください" required readonly>
                    </div>
                    <button type="button" id="searchPJ" onclick="showProjectModal()" class="p-2.5 text-sm font-medium h-[34px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                    @error('project_num')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="hidden">
                    <label for="project_id" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクトID（非表示）</label>
                    <input type="text" form="KeepfileForm" maxlength="100" name="project_id" id="project_id" value="{{old('project_id')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1">
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
                    <input type="text" form="KeepfileForm" name="client_name" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded mt-1" id="client_name" value="{{old('client_name')}}" placeholder="" readonly>
                    @error('client_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="w-full flex flex-col mt-4">
                <label for="project_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm">プロジェクト名称<span class="text-red-500"> *</span></label>
                <input type="text" form="KeepfileForm" maxlength="100" name="project_name" id="project_name" value="{{old('project_name')}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded mt-1" tabindex="-1" readonly>
                @error('project_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid gap-4 md:grid-cols-2 mt-4">
                <div class="w-full flex flex-col">
                    <label for="keep_at" class="dark:text-white text-red-700 leading-none text-sm">預託日<span class="text-red-500"> *</span></label>
                    <input type="date" form="KeepfileForm" min="2000-01-01" max="2100-12-31" name="keep_at" class="input-primary" id="keep_at" value="{{old('keep_at')}}">
                    @error('keep_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="return_at" class="dark:text-white text-red-700 leading-none text-sm">消去予定日<span class="text-red-500"> *</span></label>
                    <input type="date" form="KeepfileForm" min="2000-01-01" max="2100-12-31" name="return_at" class="input-primary" id="return_at" value="{{old('return_at')}}">
                    @error('return_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="w-full flex flex-col mt-4">
                <label for="purpose" class="dark:text-white text-red-700 leading-none text-sm">用途<span class="text-red-500"> *</span></label>
                <input type="text" form="KeepfileForm" name="purpose" class="input-primary" id="purpose" value="{{old('purpose')}}" placeholder="例）バージョンアップ">
                @error('purpose')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="w-full flex flex-col">
                <label for="keepfile_memo" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">備考</label>
                <textarea name="keepfile_memo" form="KeepfileForm" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="keepfile_memo" data-auto-resize="true" cols="30" rows="5" placeholder="">{{old('keepfile_memo')}}</textarea>
                @error('keepfile_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>


            <p class="dark:text-white text-red-700 leading-none text-sm mt-4 mb-1">書類</p>
            <div class="relative flex items-center justify-center w-full">
                <input type="file" form="KeepfileForm" name="pdf_file" id="pdf_file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 z-10 " onchange="displayFileInfo()" />
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
            
            <form method="post" action="{{route('keepfile.store')}}" enctype="multipart/form-data" id="KeepfileForm">
                @csrf
                <x-primary-button class="mt-4" form-id="KeepfileForm" id="saveButton" onkeydown="stopTab(event)">
                    保存(S)
                </x-primary-button>
            </form>
        </div>
    </div>


    <!-- プロジェクト検索 Modal -->
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
        
                fileInfo.innerHTML = `<span class="font-semibold text-md text-blue-600">ファイル名称： ${fileName}</span></br><span class="font-semibold text-md text-blue-600">ファイルサイズ： ${fileSize} KB</span></br><span class="font-semibold text-md text-blue-600">ファイル形式： ${fileType}</span>`;
            }
        }
    </script>

    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/searchProject.js') }}"></script>


</x-app-layout>