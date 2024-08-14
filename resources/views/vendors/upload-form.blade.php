<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('csvUploadVendors') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    {{-- オーバーレイ用要素 --}}
    <div id="overlay" class="overlay hidden w-full h-full top-0 left-0 fixed bg-black bg-opacity-50  z-[9999]"></div>

    <div class="w-auto md:ml-14 md:mr-2 max-h-full mt-4">
        <div class="relative bg-white rounded shadow dark:bg-gray-700">
            <div class="p-4 space-y-6">
                <form action="{{ route('vendors.upload') }}" method="POST" enctype="multipart/form-data" class="" id="csv_form1">
                    @csrf
                    <div class="rounded border-gray-500 border mb-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            {{-- <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            </thead> --}}
                            <tbody class="">
                                <tr class="border-b dark:border-gray-700">
                                    <th class="pl-4 border-r dark:border-gray-700 dark:bg-gray-800 w-44">
                                        処理種別
                                    </th>
                                    <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                                        <div class="flex px-8 py-1.5">
                                            <div class="flex items-center me-4">
                                                <input id="inline-radio" type="radio" value="new" name="processing_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-300 dark:border-gray-600"  {{ old('processing_type') == 'new' ? 'checked' : '' }}>
                                                <label for="inline-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 whitespace-nowrap">新規登録</label>
                                            </div>
                                            <div class="flex items-center me-4">
                                                <input id="inline-2-radio" type="radio" value="update" name="processing_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-300 dark:border-gray-600"  {{ old('processing_type') == 'update' ? 'checked' : '' }}>
                                                <label for="inline-2-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 whitespace-nowrap">既存更新</label>
                                            </div>
                                            <div class="md:w-auto md:ml-14">
                                                @error('processing_type')
                                                    <div class="text-red-500">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="pl-4 border-r dark:border-gray-700 dark:bg-gray-800 w-44">
                                        ヘッダー
                                    </th>
                                    <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                                        <div class="flex px-8 py-1.5">
                                            <div class="flex items-center mr-12 ">
                                                <input id="head-radio" type="radio" value="headon" name="head-radio-group" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-300 dark:border-gray-600" checked disabled>
                                                <label for="head-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-nowrap">有り</label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="pl-4 border-r dark:border-gray-700 dark:bg-gray-800 w-44">
                                        エスケープ
                                        <button data-tooltip-target="tooltip-right" data-tooltip-placement="right" type="button" class="ms-3 mb-2 md:mb-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-1.5 py-[1px] text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            ?
                                        </button>
                                        <div id="tooltip-right" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-1.5 text-sm font-medium text-white bg-gray-900 rounded-xl shadow-sm opacity-0 tooltip dark:bg-gray-600">
                                            <span class="text-xs">
                                                データ内に「1,000円」などのカンマが入っている場合に「"1,000円"」とすることで
                                                <br>
                                                不正な位置で区切られないようにすることができます。
                                            </span>
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </th>
                                    <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                                        <div class="flex px-8 py-1.5">
                                            <div class="flex items-center mr-12 ">
                                                <span>ダブルクォーテーション（""）</span>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="pl-4 border-r dark:border-gray-700 dark:bg-gray-800 w-44">
                                        ファイル形式
                                    </th>
                                    <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                                        <div class="flex px-8 py-1.5">
                                            <div class="flex items-center mr-12 ">
                                                <span>CSV形式</span>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="pl-4 border-r dark:border-gray-700 dark:bg-gray-800 w-44">
                                        ファイルサイズ
                                    </th>
                                    <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                                        <div class="flex px-8 py-1.5">
                                            <div class="flex items-center mr-12 ">
                                                <span>10,000KB（10MB）以下</span>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="pl-4 border-r dark:border-gray-700 dark:bg-gray-800 w-44">
                                        文字コード
                                    </th>
                                    <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                                        <div class="flex px-8 py-1.5">
                                            <div class="flex items-center mr-12 ">
                                                <span>shift-Jis</span>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="relative flex items-center justify-center w-full">
                        <input type="file" name="csv_upload" id="csv_upload_file" class="absolute inset-0 w-full h-full opacity-0 z-10 " onchange="displayFileInfo()" />
                        <label for="csv_upload_file" class="dark:bg-gray-900flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-bray-800 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p id="file-info" class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-semibold">クリックもしくはドラッグ＆ドロップでファイルを選択してください</p>
                                <div class="md:w-auto md:ml-14" id="fileError">
                                    @error('csv_upload')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div> 
                            </div>
                        </label>
                    </div>
                </form>
            </div>
            <div class="flex justify-end p-3 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit" form="csv_form1" id="upload-button"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    アップロード
                </button>
                <button disabled type="button" id="spinner" class="hidden  text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 items-center">
                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    アップロード中...
                </button>
                <div id="uploadOverlay" style="display: none;"></div>
            </div>
        </div>
        <div class=" h-40 w-full rounded mt-4 overflow-y-scroll bg-gray-700">
            @if(session()->has('validatedErrors') && is_array(session('validatedErrors')))
                <div class="w-auto mx-2 p-1">
                    <ul>
                        @foreach (session('validatedErrors') as $error)
                            <li class="text-red-500 p-0.5 border-b border-gray-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>

    <div class="md:w-auto md:ml-14 md:mr-2 mt-4 relative overflow-x-auto rounded shadow-md dark:bg-gray-900 dark:text-gray-900 bg-white">
        <div id="accordion-collapse" data-accordion="collapse" >
            <h2 id="accordion-collapse-heading-1">
                <button type="button" class="flex items-center justify-between w-full p-3 font-medium rtl:text-right text-gray-500 border-b-0 dark:bg-gray-700 border-gray-200 rounded focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="false" aria-controls="accordion-collapse-body-1">
                    <span>項目詳細</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-1" class="hidden mt-4 pb-3" aria-labelledby="accordion-collapse-heading-1">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <div class="flex justify-between dark:bg-gray-800">
                        <div class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800 w-full">
                            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                                更新処理時に「空白」のデータは「空白」で上書きされますのでご注意ください。
                                {{-- 列数が合わない場合は、データに「""」に囲まれていない「,」カンマが含まれている可能性があります。 --}}
                            </p>
                        </div>
                        <div class=" my-auto mr-4">
                            <button type="submit" form="csv_form1" id="upload-button"  class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <div class="whitespace-nowrap">
                                    雛形ダウンロード
                                </div>
                            </button>
                        </div>
                    </div>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="pl-4 py-3">
                                項目名称
                            </th>
                            <th scope="col" class="px-2 py-3">
                                登録可否
                            </th>
                            <th scope="col" class="px-2 py-3">
                                更新可否
                            </th>
                            <th scope="col" class="px-2 py-3">
                                型
                            </th>
                            <th scope="col" class="px-2 py-3">
                                桁数
                            </th>
                            <th scope="col" class="px-2 py-3">
                                説明
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="pl-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                法人番号<span class="text-red-500"> *</span>
                            </th>
                            <td class="px-2 py-3">
                                ◯
                            </td>
                            <td class="px-2 py-3">
                                -
                            </td>
                            <td class="px-2 py-3">
                                文字列
                            </td>
                            <td class="px-2 py-3">
                                <div class="w-[30px] text-right">6</div>
                            </td>
                            <td class="px-2 py-3">
                                法人情報を識別するユニークキーです。
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="pl-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                法人名称<span class="text-red-500"> *</span>
                            </th>
                            <td class="px-2 py-3">
                                ◯
                            </td>
                            <td class="px-2 py-3">
                                ◯
                            </td>
                            <td class="px-2 py-3">
                                文字列
                            </td>
                            <td class="px-2 py-3">
                                <div class="w-[30px] text-right">100</div>
                            </td>
                            <td class="px-2 py-3">
                                法人の正式名称です。
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="pl-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                法人カナ名称<span class="text-red-500"> *</span>
                            </th>
                            <td class="px-2 py-3">
                                ◯
                            </td>
                            <td class="px-2 py-3">
                                ◯
                            </td>
                            <td class="px-2 py-3">
                                文字列
                            </td>
                            <td class="px-2 py-3">
                                <div class="w-[30px] text-right">100</div>
                            </td>
                            <td class="px-2 py-3">
                                法人の正式カナ名称です。
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="pl-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                法人略称<span class="text-red-500"> *</span>
                            </th>
                            <td class="px-2 py-3">
                                ◯
                            </td>
                            <td class="px-2 py-3">
                                ◯
                            </td>
                            <td class="px-2 py-3">
                                文字列
                            </td>
                            <td class="px-2 py-3">
                                <div class="w-[30px] text-right">100</div>
                            </td>
                            <td class="px-2 py-3">
                                法人の略称です。一部の画面で使用されます。
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="pl-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                与信限度額
                            </th>
                            <td class="px-2 py-3">
                                -
                            </td>
                            <td class="px-2 py-3">
                                -
                            </td>
                            <td class="px-2 py-3">
                                数値
                            </td>
                            <td class="px-2 py-3">
                                <div class="w-[30px] text-right">9</div>
                            </td>
                            <td class="px-2 py-3">
                                担当部署にて審査の上、個別に登録されます。
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="pl-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                法人備考
                            </th>
                            <td class="px-2 py-3">
                                ◯
                            </td>
                            <td class="px-2 py-3">
                                ◯
                            </td>
                            <td class="px-2 py-3">
                                文字列
                            </td>
                            <td class="px-2 py-3">
                                <div class="w-[30px] text-right">1000</div>
                            </td>
                            <td class="px-2 py-3">
                                法人に関する備考情報です。
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function displayFileInfo() {
            const fileInput = document.getElementById('csv_upload_file');
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
        document.addEventListener('DOMContentLoaded', function () {
        const uploadForm = document.getElementById('csv_form1');
        const uploadButton = document.getElementById('upload-button');
        const spinner = document.getElementById('spinner');
        const overlay = document.getElementById('overlay');

            uploadForm.addEventListener('submit', function (event) {
                event.preventDefault();

                uploadButton.style.display = 'none';
                spinner.style.display = 'block';
                spinner.style.backgroundColor = 'rgba(128, 128, 128, 0.5)';
                overlay.style.display = 'block'; // オーバーレイを表示する

            // フォームをサブミット
                uploadForm.submit();
            });
        });
    </script>
</x-app-layout>