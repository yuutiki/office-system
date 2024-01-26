<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('csvUploadClientcorporation') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div class="md:w-auto md:ml-14 md:mr-2 max-h-full mt-8">
        <div class="relative bg-white rounded shadow dark:bg-gray-700">



            <div class="p-4 space-y-6">
                
                <form action="{{ route('clientcorporation.upload') }}" method="POST" enctype="multipart/form-data" class="" id="csv_form1">
                    @csrf
                    {{-- <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="csv_upload"></label>
                    <input type="file" name="csv_upload"  id="csv_upload_file"  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-s rounded-e cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="csv_upload_help"> --}}
                    <div class="flex px-8 py-8">
                        <div class="flex items-center me-4">
                            <input id="inline-radio" type="radio" value="new" name="inline-radio-group" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">新規登録</label>
                        </div>
                        <div class="flex items-center me-4">
                            <input id="inline-2-radio" type="radio" value="update" name="inline-radio-group" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-2-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">既存更新</label>
                        </div>
                    </div>


                    <div class="flex items-center justify-center w-full">
                        <label for="csv_upload_file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p id="file-info" class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">クリックもしくは</span>ドラッグ＆ドロップでファイルを選択してください</p>
                            </div>
                            <input type="file" name="csv_upload" id="csv_upload_file" class="w-full h-full opacity-0" onchange="displayFileInfo()" />
                        </label>
                    </div>

                </form>
            </div>
            <div class="flex justify-end p-3 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit" form="csv_form1" id="upload-button"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    アップロード
                </button>
                <button disabled type="button" id="spinner" class="hidden  text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 items-center">
                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    アップロード中...
                </button>
                <div id="uploadOverlay" style="display: none"></div>
            </div>
        </div>
    </div>

    <div class="md:w-auto md:ml-14">
        @error('clientcorporation_num')
            <div class="text-red-500">{{$message}}</div>
        @enderror
    </div>

    <div class="md:w-auto md:ml-14 md:mr-2 mt-20 relative overflow-x-auto rounded shadow-md dark:bg-gray-700  dark:text-gray-900 bg-gray-300">

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                ファイル形式：CSV / 文字コード：shift-Jis / ヘッダ有 / サイズ：10000KB
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Browse a list of Flowbite products designed to help you work and play, stay organized, get answers, keep in touch, grow your business, and more.</p>
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                        法人番号
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
                        法人正式名称
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
                        法人正式カナ名称
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
                        法人略称
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


    <script>
        function displayFileInfo() {
            const fileInput = document.getElementById('csv_upload_file');
            const fileInfo = document.getElementById('file-info');
        
            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                const fileSize = (fileInput.files[0].size / 1024).toFixed(2); // Convert to KB with 2 decimal places
                const fileType = fileInput.files[0].type;
        
                fileInfo.innerHTML = `<span class="font-semibold text-md">名称: ${fileName}</span></br><span class="font-semibold text-md">サイズ: ${fileSize} KB</span></br><span class="font-semibold text-md">ファイル形式: ${fileType}</span>`;
            }
        }
    </script>
</x-app-layout>