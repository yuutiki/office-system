<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editKeepfile') }}
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
            <span class="text-xs  text-gray-900 dark:text-gray-300 block">※返却時は「sdg-sales-ismstensou@systemd.co.jp」をCcに含めてください</span>

            <label class="relative inline-flex items-center cursor-pointer mt-6">
            <input type="hidden" form="keepfileForm" name="is_finished" id="is_finished" value="0">
            @if($keepfile->is_finished == 1)
                <input type="checkbox" form="keepfileForm" name="is_finished" id="is_finished" value="1" class="sr-only peer" checked>
            @else
                <input type="checkbox" form="keepfileForm" name="is_finished" id="is_finished" value="1" class="sr-only peer">
            @endif
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">完了</span>
            </label>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="w-full flex flex-col">
                    <label for="project_num" class=" dark:text-white text-red-700 leading-none text-sm">プロジェクト№<span class="text-red-500"> *</span></label>

                    <div class="relative">
                        <input type="text" form="keepfileForm" copy-target="true" name="project_num" class="input-primary" id="project_num" value="{{old('project_num', $keepfile->project->project_num)}}"  readonly>
                        
                        <button id="copy-button" data-tooltip-target="tooltip-copy-copy-button" data-tooltip-placement="left" class="mt-[2px] absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white hover:bg-gray-400 dark:hover:bg-gray-400 dark:bg-gray-500 rounded p-2 inline-flex items-center justify-center">
                            <span id="default-icon">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                                </svg>
                            </span>
                            <span id="success-icon" class="hidden inline-flex items-center">
                                <svg class="w-3.5 h-3.5 text-blue-700 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                </svg>
                            </span>
                        </button>
                        <div id="tooltip-copy-copy-button" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            <span id="default-tooltip-message">クリップボードにコピー</span>
                            <span id="success-tooltip-message" class="hidden">コピー完了!</span>
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                </div>
                <div class="hidden">
                    <label for="project_id" class="dark:text-gray-100 text-gray-900 leading-none mt-1">プロジェクトID（非表示）</label>
                    <input type="text" form="keepfileForm" maxlength="100" name="project_id" id="project_id" value="{{old('project_id',$keepfile->project_id)}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded" tabindex="-1">
                    @error('project_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="client_name" class="dark:text-white text-red-700 leading-none text-sm">顧客名称<span class="text-red-500"> *</span></label>
                    <input type="text" form="keepfileForm" name="client_name" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded mt-1" id="client_name" value="{{old('client_name', $keepfile->project->client->client_name)}}" placeholder="" tabindex="-1"  readonly>
                    @error('client_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="w-full flex flex-col mt-4">
                <label for="project_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm">プロジェクト名称<span class="text-red-500"> *</span></label>
                <input type="text" form="KeepfileForm" maxlength="100" name="project_name" id="project_name" value="{{old('project_name', $keepfile->project->project_name)}}" class="dark:bg-gray-400 w-full py-1 border border-gray-700 rounded mt-1" tabindex="-1" readonly>
                @error('project_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid gap-4 md:grid-cols-2 mt-4">
                <div class="w-full flex flex-col">
                    <label for="keep_at" class="dark:text-white text-red-700 leading-none text-sm">預託日<span class="text-red-500"> *</span></label>
                    <input type="date" form="keepfileForm" min="2000-01-01" max="2100-12-31" name="keep_at" class="input-primary" id="keep_at" value="{{old('keep_at',$keepfile->keep_at)}}" >
                    @error('keep_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="return_at" class="dark:text-white text-red-700 leading-none text-sm">消去予定日<span class="text-red-500"> *</span></label>
                    <input type="date" form="keepfileForm" min="2000-01-01" max="2100-12-31" name="return_at" class="input-primary" id="return_at" value="{{old('return_at',$keepfile->return_at)}}" >
                    @error('return_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="w-full flex flex-col mt-4">
                <label for="purpose" class="dark:text-white text-red-700 leading-none text-sm">用途<span class="text-red-500"> *</span></label>
                <input type="text" form="keepfileForm" name="purpose" class="input-primary" id="purpose" value="{{old('purpose',$keepfile->purpose)}}" placeholder="例）バージョンアップ" >
                @error('purpose')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
                
            <div>
                <div class="w-full flex flex-col">
                    <label for="keepfile_memo" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">備考</label>
                    <textarea name="keepfile_memo" form="keepfileForm" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="keepfile_memo" data-auto-resize="true" cols="30" rows="5" placeholder="">{{old('keepfile_memo',$keepfile->keepfile_memo)}}</textarea>
                </div>
                @error('keepfile_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="flex">
                <div class="dark:text-white text-red-700 leading-none text-sm mt-4 mb-1">書類</div>
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
                <input type="file" form="keepfileForm" name="pdf_file" id="pdf_file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 z-10 " onchange="displayFileInfo()" />
                <label for="pdf_file" class="dark:bg-gray-900flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-bray-800 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p id="file-info" class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-semibold">
                            クリックもしくはドラッグ＆ドロップでファイルを選択してください
                            <br>
                            なお、既存のPDFを上書きますのでご留意ください
                        </p>
                        <div class="md:w-auto md:ml-14" id="fileError">
                            @error('pdf_file')
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
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white border-x border-gray-600">
                                {{ $fileName }}
                            </th>
                            <td class="px-3 py-2 border-x text-center border-gray-600">
                                {{ $formattedFileSize }}
                            </td>
                            <td class="px-3 py-2 text-center border-x border-gray-600">
                                @if ($keepfile->pdf_file) 
                                {{-- ブラウザの別タブで一旦表示ボタン --}}
                                    <button type="button" class="button-edit" onclick="window.open('{{ asset('storage/' . $keepfile->pdf_file) }}', '_blank');">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/>
                                            </svg>
                                        </div>
                                    </button>

                                {{-- 直ダウンロードボタン --}}
                                    {{-- <a href="{{ asset('storage/' . $keepfile->pdf_file) }}" download class="button-edit inline-block">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/>
                                            </svg>
                                        </div>
                                    </a> --}}
                                @endif
                            </td>
                            <td class="px-3 py-2 text-center">
                                @if ($keepfile->pdf_file)
                                    <button type="button" data-modal-target="deleteModal" data-modal-show="deleteModal" class="button-delete-primary">
                                        <div class="flex">
                                            <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                            <span class="text-ms ">削除</span>
                                        </div>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <form method="post" action="{{route('keepfile.update',$keepfile)}}" enctype="multipart/form-data" id="keepfileForm">
                @csrf
                @method('patch')
                <x-primary-button class="mt-4" form-id="keepfileForm" id="saveButton" onkeydown="stopTab(event)">
                    保存(S)
                </x-primary-button>
            </form>
        </div>
    </div>

    {{-- 削除モーダル --}}
    <div id="deleteModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <button data-modal-hide="deleteModal" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>

                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                    <div class="flex justify-center">
                        <form action="{{route('keepfile.deletePdf', $keepfile->id)}}" method="POST" class="text-center">
                            @csrf
                            @method('delete')
                            @can('managerOrAbobe')
                            <button type="submit" data-modal-hide="deleteModal" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                削除
                            </button>
                            @endcan
                        </form>
                        <button data-modal-hide="deleteModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            やっぱやめます
                        </button>
                    </div>
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
    <script type="text/javascript" src="{{ asset('/assets/js/clipCopy.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

</x-app-layout>