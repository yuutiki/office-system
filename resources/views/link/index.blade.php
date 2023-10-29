<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                所属別リンク一覧
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>


    <div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
        <h2 id="accordion-color-heading-1">
            <button type="button" class="bg-gray-300 dark:bg-gray-700 flex items-center justify-between w-5/6 p-2 mt-4 mx-auto font-medium text-left text-gray-900 border border-gray-200 rounded-t-xl focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-500 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-1" aria-expanded="false" aria-controls="accordion-color-body-1">
                <span>検索</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
            </button>
        </h2>
        <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
            <div class="w-5/6 border border-t-0 mx-auto h-auto dark:text-white rounded-b-md border-gray-400 bg-white dark:bg-gray-400 shadow-md">
                <form method="GET" action="{{ route('link.index') }}" id="linkform">
                    @csrf
                    <div class="md:flex flex-wrap">
                        {{-- 　テキスト検索start --}}
                        <div class="relative w-auto ml-2 mt-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" name="employee_num" value="@if (isset($employee_num)){{$employee_num}}@endif" oninput="value = value.replace(/[^0-9]+/i,'');" class=" block w-full py-1.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="社員番号" >
                        </div>

                        <div class="relative w-auto ml-2 mt-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" name="link_name" value="@if (isset($link_name)){{$link_name}}@endif" class="block w-full py-1.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="氏名" >    
                        </div>
                        {{-- 　テキストend --}}
                        {{-- 横並びセレクトボックス2つ　start --}}
                        <div class="flex-nowrap">
                            {{-- <select  name="department" class="mt-2 w-auto ml-2 py-1.5 text-sm rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">事業部全て</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}" @if($department->id == $department) selected @endif>{{$department->department_name}}</option>
                                @endforeach
                            </select> --}}
                        </div>
                        {{-- 横並びセレクトボックス2つ　end --}}
                    </div>
                </form>
                <div class="w-5/6 mt-2 mb-2 ml-8 flex justify-start">
                    <button type="submit" form="linkform" class="w-20 px-6 py-1.5 font-medium text-sm rounded-lg text-white focus:outline-none focus:ring-4 focus:ring-blue-300 bg-blue-700 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">検索</button>
                    <button type="button" value="reset" form="linkform" id="clear" class="w-20 ml-2 px-4 py-1.5 font-medium text-sm rounded-lg text-white focus:outline-none focus:ring-4 focus:ring-blue-300 bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800">リセット</button>
                </div>
            </div>
        </div>
    </div>

{{-- JQUERY --}}
        <script>
        $(function(){
            $('#clear').click(function(){
                $('#linkform input, #linkform select').each(function(){
                  //checkboxまたはradioボタンの時
                  if(this.type == 'checkbox' || this.type == 'radio'){
                    //一括でチェックを外す
                      this.checked = false;
                  }
                  //checkboxまたはradioボタン以外の時
                  else{
                    // val値を空にする
                    $(this).val('');
                  }
                });
            });
        });
        </script>
{{-- JQUERY --}}

    {{-- 絞り込み検索 end--}}

    <!-- Dropdown bottoun -->
    <div class="w-5/6 text-right mt-2 mx-auto ">
        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            追加
            <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="float-left font-medium dark:text-white">
            {{-- {{ $count }}件 --}}
        </div>
    </div>
    <!-- Dropdown menu -->
    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
            <li>
                <!-- Modal toggle start-->
                <button data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="text-left pl-8 py-2 w-full font-medium text-sm text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800" type="button">
                    CSV一括登録
                </button>
                <!-- Modal toggle end-->
            </li>

            <li>
                <a href="/link/create" class="block text-left pl-8 py-2 font-medium text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">手動登録</a>
            </li>
        </ul>
    </div>

    <!-- Main modal -->
    <div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        CSV一括アップロード
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6 mr-20 mt-4">
                    <form action="{{ route('link.store') }}" method="POST" enctype="multipart/form-data" class="flex items-center" id="csv_form1">
                        @csrf
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="csv_input"></label>
                        <input name="csv_input" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="csv_input_help" id="csv_input_file" type="file">
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-end p-3 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" form="csv_form1" id="upload-button"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        アップロード
                    </button>
                    <button disabled type="button" id="spinner" class="hidden  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 items-center">
                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                        </svg>
                        アップロード中...
                    </button>
                    <div id="overlay" style="display: none"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-5/6 relative overflow-x-auto shadow-md rounded-lg mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
        <table class="w-full text-sm font-medium text-left text-gray-800 dark:text-gray-400">

            {{-- テーブルヘッダ start --}}
            <thead class="text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="pl-4 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            №
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">編集</span>
                    </th>
                    <th scope="col" class="pl-2 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap mr-3">
                            @sortablelink('display_name','表示名')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 ">
                        <div class="flex items-center whitespace-nowrap mr-3">
                            @sortablelink('url','URL')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center whitespace-nowrap mr-3">
                            <div class="flex items-center ">
                            @sortablelink('department_id','管轄事業部')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center whitespace-nowrap mr-3">
                            <div class="flex items-center ">
                            @sortablelink('display_order','表示順')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>   
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">削除</span>
                    </th>
                </tr>
            </thead>
            {{-- テーブルヘッダ end --}}

            {{-- テーブルボディスタート --}}
            <tbody>
                @foreach ($links as $link)
                <tr class="bg-white border-b dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 dark:text-white dark:border-gray-700">
                    <td class="pl-4 py-2 whitespace-nowrap">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap">
                        <button onclick="location.href='{{route('link.edit',$link)}}'"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            <div class="flex">
                                <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                </svg>
                                <span class="text-ms">参照</span>
                            </div>
                        </button>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap">
                        <button id="updateProductButton" data-modal-toggle="updateModal-{{$link->id}}" class="block text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" type="button">
                            <div class="flex">
                                <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                </svg>
                                <span class="text-ms">更新</span>
                            </div>
                        </button>
                    </td>
                    <td class="pl-2 py-3 whitespace-nowrap mr-2">
                        {{$link->display_name}}
                    </td>
                    <td  class="px-1 py-3 mr-2">
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">{{$link->url}}</div>
                    </td>
                    <td class="px-1 py-3 whitespace-nowrap mr-2">
                        {{$link->department->department_name}}
                    </td>
                    <td class="px-1 py-3 whitespace-nowrap mr-2">
                        {{$link->display_order}}
                    </td>
                    <td class="py-2">
                        <button data-modal-target="deleteModal-{{$link->id}}" data-modal-toggle="deleteModal-{{$link->id}}"  class="block whitespace-nowrap px-2 py-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-sm  text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                            <div class="flex">
                                <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                                </svg>
                                <span class="text-ms ">削除</span>
                            </div>
                        </button>
                    </td>
                </tr>
            </tbody>
            {{-- 削除確認モーダル画面 Start --}}
            <div id="deleteModal-{{$link->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button data-modal-hide="deleteModal-{{$link->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                        <div class="p-6 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                            <form action="{{route('link.destroy',$link->id)}}" method="POST" class="text-center m-auto">
                                @csrf
                                @method('delete')
                                <button type="submit" data-modal-hide="deleteModal-{{$link->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                    削除
                                </button>
                            </form>
                            <button data-modal-hide="deleteModal-{{$link->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                やっぱやめます
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 削除確認モーダル画面 End --}}


            <!-- 更新モーダル　Start -->
            <div id="updateModal-{{$link->id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                        <!-- Modal header -->
                        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                リンク更新
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProductModal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form method="POST" action="{{ route('link.update', $link->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                <div class="md:flex items-center">
                                    <div class="w-full flex flex-col">
                                        <label for="display_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">表示名</label>
                                        <input type="text" name="display_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" id="display_name" value="{{old('display_name',$link->display_name)}}">
                                    </div>
                                </div>
                                @error('display_name')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div>
                                    <div class="w-full flex flex-col">
                                        <label for="department_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">事業部</label>
                                        <select name="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" id="department_id" value="{{old('department_id')}}">
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}"  @selected($department->id == $link->department_id)>{{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('department_id')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="md:flex items-center">
                                        <div class="w-full flex flex-col">
                                        <label for="display_order" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">表示順</label>
                                        <input type="number" name="display_order" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" id="display_order" value="{{old('display_order',$link->display_order)}}">
                                        </div>
                                    </div>
                                    @error('display_order')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="sm:col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">URL</label>
                                    <textarea id="description" name="url" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{{old('url',$link->url)}}</textarea>                    
                                </div>
                                @error('url')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="flex items-center space-x-4 mt-2">
                                <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    更新
                                </button>
                                <button type="button" class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    削除
                                </button>
                            </div>
                            <div id="errorMessages"></div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- 更新モーダル　End -->

            @endforeach
        </table> 
        <div class="mt-2 mb-2 px-4">
            {{-- {{ $links->withQueryString()->links('vendor.pagination.custum-tailwind') }} --}}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const uploadForm = document.getElementById('csv_form1');
        const uploadButton = document.getElementById('upload-button');
        const spinner = document.getElementById('spinner');
        const overlay = document.getElementById('overlay');

            uploadForm.addEventListener('submit', function (event) {
                event.preventDefault();

                // アップロードボタンを非表示にし、スピナーを表示
                uploadButton.style.display = 'none';
                spinner.style.display = 'block';

                // 画面をロック
                overlay.style.display = 'block';

                // フォームをサブミット
                uploadForm.submit();
            });
        });
    </script>

    <script>
        // public/js/modal.js
// public/js/modal.js

// ...



$(document).ready(function () {
    $('#openModalButton').click(function () {
        $('#myModal').css('display', 'block');
    });
    $('#myForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: "{{ route('updateLink', $link->id) }}", // ルートを指定
            data: $(this).serialize(),
            success: function (data) {
                // 成功時の処理
                $('#updateModal-{{$link->id}}').css('display', 'none');
            },
            error: function (response) {
                if (response.status === 422) {
                    // バリデーションエラーがある場合
                    var errors = response.responseJSON.errors;
                    var errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#errorMessages').html(errorHtml);
                }
            }
            });
    });
    
});

    </script>
</x-app-layout>