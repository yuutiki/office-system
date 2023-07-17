    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ asset('/favicon-sales.ico') }}">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            営業報告一覧
        </h2>
        <div class="flex flex-row-reverse">
        </div>
        <x-message :message="session('message')" />
    </x-slot>



    <div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
        <h2 id="accordion-color-heading-1">
            <button type="button" class="dark:bg-gray-700 flex items-center justify-between w-5/6 p-2 mt-4 mx-auto font-medium text-left text-gray-500 border border-gray-200 rounded-t-xl focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-1" aria-expanded="false" aria-controls="accordion-color-body-1">
                <span>検索</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
            </button>
        </h2>
        <div id="accordion-color-body-1" class="hidden transition duration-1000" aria-labelledby="accordion-color-heading-1">
        {{-- 絞り込み検索 --}}
            <div class="w-5/6 border border-t-0 mx-auto h-auto dark:text-white">
                <form method="GET" action="{{ route('clientcorporation.index') }}" id="clientcorporationform">
                    @csrf
                    <div class="md:flex flex-wrap">
                        {{-- テキスト検索 start --}}
                        <div class="relative w-auto mt-2 mx-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" name="clientcorporation_num" value="@if (isset($clientcorporation_num)){{ $clientcorporation_num }}@endif" class="w-full p-1.5 pl-10  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="法人番号" >
                        </div>
                        <div class="relative w-auto mt-2 mx-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" name="clientcorporation_name" value="@if (isset($clientcorporation_name)){{ $clientcorporation_name }}@endif" class="w-full p-1.5 pl-10  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="法人名称" >
                        </div>
                        <div class="relative w-auto mt-2 mx-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" name="clientcorporation_kana_name" value="@if (isset($clientcorporation_kana_name)){{ $clientcorporation_kana_name }}@endif" class="w-full p-1.5 pl-10  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="法人カナ名称" >
                        </div>
                        {{-- テキスト検索 end --}}
                        {{-- セレクト検索 start --}}
                        {{-- <div class="flex-nowrap">
                            <select  name="finish" value="0" class="mt-2 w-auto ml-2 py-1.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">ステータス</option>
                                @foreach($clients as $client)
                                    <option value="{{$client->is_finished}}">{{$client->is_finished}}</option>
                                @endforeach
                            </select>
                            
                            <select  name="finish" value="0" class="mt-2 w-auto ml-2 py-1.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">担当者全て</option>
                                @foreach($users as $s_user)
                                    <option value="{{$s_user->id}}">{{$s_user->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- セレクト検索 end --}}
                        <div class="w-5/6 mt-2 ml-8 mb-2 flex justify-start">
                            <button type="submit" form="clientcorporationform" class="px-6 py-1.5 font-medium text-sm rounded-lg text-white focus:outline-none focus:ring-4 focus:ring-blue-300 bg-blue-700 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">検索</button>
                            <button type="button" value="reset" form="clientcorporationform" id="clear" class="ml-2 px-4 py-1.5 font-medium text-sm rounded-lg text-white focus:outline-none focus:ring-4 focus:ring-blue-300 bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800">リセット</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
      
    {{-- JQUERY --}}
    {{-- JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
    $(function(){
        $('#clear').click(function(){
            $('#clientcorporationform input, #clientcorporationform select').each(function(){
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
    {{-- JQUERY --}}

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
                <a href="/report/create" class="block text-left pl-8 py-2 font-medium text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    手動登録
                </a>
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
                        {{-- <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center" id="csv_input"> --}}
                            @csrf
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="csv_input"></label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="csv_input_help" id="csv_input" type="file">
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex justify-end p-3 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" form="csv_input"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            アップロード
                        </button>
                    </div>
                </div>
            </div>
        </div>


    {{-- テーブル表示 --}}
    <div class="w-5/6 relative overflow-x-auto shadow-md rounded-lg mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
        <table class="w-full text-sm font-medium text-left text-gray-800 dark:text-gray-400">

            {{-- テーブルヘッダ start --}}
            <thead class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <span class="sr-only">参照</span>
                    </th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_num','顧客番号')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_name','顧客名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('contact_at','対応日付')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('type','報告区分')
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('title','タイトル')
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('user_id','報告者')
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <span class="sr-only">編集</span>
                    </th>
                </tr>
            </thead>
            @foreach ($reports as $report)
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                        <td class="px-4 py-4 text-center">
{{-- report.showを作成して変更 --}}
                            <a href="{{route('report.show',$report)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline whitespace-nowrap">参照</a>
                        </td>
                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$report->client->client_num}}
                        </th>
                        <td class="px-1 py-4 whitespace-nowrap">
                            {{$report->client->client_name}}
                        </td>
                        <td class="px-1 py-4 whitespace-nowrap">
                            {{$report->contact_at}}
                        </td>
                        <td class="px-1 py-4 whitespace-nowrap">
                            {{$report->type}}
                        </td>
                        <td class="px-1 py-4 whitespace-nowrap">
                            {{$report->title}}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            {{$report->reporter->name}}
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap">
                            {{$report->updated_at->format('y-m-d')}}
                        </td>

                        <td class="px-4 py-4 text-center">
                            <a href="{{route('report.create',$report)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline whitespace-nowrap">削除</a>
                        </td>
                        <td class="py-3">
                            <button data-modal-target="deleteModal-{{$report->id}}" data-modal-toggle="deleteModal-{{$report->id}}"  class="block whitespace-nowrap text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                削除
                            </button>
                        </td>
                    </tr>
                </tbody>
                {{-- 削除確認モーダル画面 Start --}}
                <div id="deleteModal-{{$report->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button data-modal-hide="deleteModal-{{$report->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-6 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>

                                <form action="{{route('report.destroy',$report->id)}}" method="POST" class="text-center m-auto">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" data-modal-hide="deleteModal-{{$report->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        削除
                                    </button>
                                </form>
                                <button data-modal-hide="deleteModal-{{$report->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    やっぱやめます
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- 削除確認モーダル画面 End --}}
            @endforeach
        </table>
        <div class="mt-8 mb-8">
        {{-- {{ $keepdatas->appends(request()->query())->links() }}   --}}
        {{ $reports->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    </div>

</x-app-layout>