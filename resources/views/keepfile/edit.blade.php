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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form method="post" action="{{route('keepfile.update',$keepfile)}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                
                <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_finished" id="is_finished" value="0">
                @if($keepfile->is_finished === 1)
                    <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer" checked="checked">
                @else
                    <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer">
                @endif
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">完了</span>
                </label>
                <span class="ml-10 text-sm font-medium text-gray-900 dark:text-gray-300">返却時は「  sdg-sales-ismstensou@systemd.co.jp  」をCcに含めてメールしてください</span>

                <div class="grid gap-4 my-4 md:grid-cols-2">
                    <div class="md:flex items-center">
                        <div class="w-full flex flex-col">
                            <div class="relative">
                                <label for="project_num" class="font-semibold dark:text-white text-red-700 leading-none mt-4">プロジェクト№<span class="text-red-500"> *</span></label>
                                <input type="text" copy-target="true" name="project_num" class="w-full py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="project_num" value="{{old('project_num',$keepfile->project_num)}}" placeholder="例）9999000100"  required>
                                
                                <button id="copy-button" data-tooltip-target="tooltip-copy-copy-button" class="mt-[14px] absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-200 rounded p-2 inline-flex items-center justify-center">
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
                                
                                <div id="tooltip-copy-copy-button" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    <span id="default-tooltip-message">クリップボードにコピー</span>
                                    <span id="success-tooltip-message" class="hidden">コピー完了!</span>
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="clientname" class="font-semibold dark:text-white text-red-700 leading-none mt-4">顧客名称<span class="text-red-500"> *</span></label>
                        <input type="text" name="clientname" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="clientname" value="{{old('clientname',$keepfile->clientname)}}" placeholder="例）学校法人  〇〇大学" required>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="keep_at" class="font-semibold dark:text-white text-red-700 leading-none mt-4">預託日<span class="text-red-500"> *</span></label>
                        <input type="date" min="2000-01-01" max="2100-12-31" name="keep_at" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="keep_at" value="{{old('keep_at',$keepfile->keep_at)}}" required>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="return_at" class="font-semibold dark:text-white text-red-700 leading-none mt-4">返却日<span class="text-red-500"> *</span></label>
                        <input type="date" min="2000-01-01" max="2100-12-31" name="return_at" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="return_at" value="{{old('return_at',$keepfile->return_at)}}" required>
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="purpose" class="font-semibold dark:text-white text-red-700 leading-none mt-4">用途<span class="text-red-500"> *</span></label>
                    <input type="text" name="purpose" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="purpose" value="{{old('purpose',$keepfile->purpose)}}" placeholder="例）バージョンアップ" required>
                </div>

                <div class="mt-8">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="pdf_file_help">
                        PDF (最大 1024KB)
                    </p>
                    <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" class="block w-full text-sm text-gray-900 border border-gray-300 rounded cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help">
                    @error('pdf_file')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>



                <div class="relative overflow-x-auto mt-8">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                            <tr>
                                <th scope="col" class="px-6 py-2">
                                    File name
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    File size
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    download
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $fileName }}
                                </th>
                                <td class="px-6 py-2">
                                    {{ $formattedFileSize }}
                                </td>
                                <td class="px-6 py-2">
                                    @if ($keepfile->pdf_file) 
                                        <button type="button" class="button-edit" onclick="window.open('{{ asset('storage/' . $keepfile->pdf_file) }}', '_blank');">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-1 -ml-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V8c0-.4.1-.6.3-.8l4-4 .6-.2H18c.6 0 1 .4 1 1v6M5 19v1c0 .6.4 1 1 1h12c.6 0 1-.4 1-1v-1M10 3v4c0 .6-.4 1-1 1H5m6 4v5h1.4a1.6 1.6 0 0 0 1.6-1.6v-1.8a1.6 1.6 0 0 0-1.6-1.6H11Z"/>
                                                </svg>
                                                <span>PDF</span>
                                            </div>
                                        </button>
                                    @endif
                                </td>
                                <td class="px-6 py-2">
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

                <div class="w-full flex flex-col">
                    <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">備考</label>
                    <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-500" id="memo"  cols="30" rows="5" data-auto-resize="true" placeholder="例）預託期限が来たため延長しました。">{{old('memo',$keepfile->memo)}}</textarea>
                </div>
                <x-primary-button class="mt-4 mb-4">
                    変更を確定
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

    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/clipCopy.js') }}"></script>


    <div class="w-full max-w-[16rem]">
        <div class="relative">
            <label for="copy-button" class="sr-only">Label</label>
            <input id="copy-target" type="text" copy-target="true" value="112659-C-C01-0018" class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none" readonly>
            
            <button id="copy-button" data-tooltip-target="tooltip-copy-copy-button" class="absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2 inline-flex items-center justify-center">
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
            
            <div id="tooltip-copy-copy-button" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                <span id="default-tooltip-message">クリップボードにコピー</span>
                <span id="success-tooltip-message" class="hidden">コピー完了!</span>
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>
</x-app-layout>