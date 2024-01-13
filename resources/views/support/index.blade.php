{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            サポート履歴一覧
        </h2>
        <div class="flex justify-end">
            <x-message :message="session('message')"/>
        </div>
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
            <div class="w-5/6 border border-t-0 mx-auto h-auto dark:text-white">
                <form method="GET" action="{{ route('support.index') }}" id="supportform">
                    @csrf
                    <div class="md:flex flex-wrap">
                        <div class="relative w-auto mt-2 mx-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" name="support_num" value="@if (isset($support_num)){{ $support_num }}@endif" class="w-full p-1.5 pl-10  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="法人番号" >
                        </div>
                        <div class="relative w-auto mt-2 mx-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" name="support_name" value="@if (isset($support_name)){{ $support_name }}@endif" class="w-full p-1.5 pl-10  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="法人名称" >
                        </div>
                        <div class="relative w-auto mt-2 mx-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" name="support_kana_name" value="@if (isset($support_kana_name)){{ $support_kana_name }}@endif" class="w-full p-1.5 pl-10  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="法人カナ名称" >
                        </div>
                        <div class="w-5/6 mt-2 ml-8 mb-2 flex justify-start">
                            <button type="submit" form="supportform" class="px-6 py-1.5 font-medium text-sm rounded-lg text-white focus:outline-none focus:ring-4 focus:ring-blue-300 bg-blue-700 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">検索</button>
                            <button type="button" value="reset" form="supportform" id="clear" class="ml-2 px-4 py-1.5 font-medium text-sm rounded-lg text-white focus:outline-none focus:ring-4 focus:ring-blue-300 bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800">リセット</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
      

    {{-- <div class="w-5/6 relative overflow-x-auto shadow-md rounded-lg mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
        <table class="w-full text-sm font-medium text-left text-gray-800 dark:text-gray-400">
            <thead class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="pl-4 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            №
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <span class="sr-only">編集</span>
                    </th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('received_at','受付日')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('support_type_id','種別')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('title','表題')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_num','顧客番号')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_name','顧客名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>

                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('user_id','受付対応者')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>

                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('product_series_id','シリーズ')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('product_version_id','バージョン')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('product_category_id','系統')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>

                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            営業担当
                        </div>
                    </th>

                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <span class="sr-only">削除</span>
                    </th>
                </tr>
            </thead>
            @foreach ($supports as $support)
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                        <td class="pl-4 py-2 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="pl-4 py-2 whitespace-nowrap">
                            <button onclick="location.href='{{route('support.edit',$support)}}'"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                <div class="flex">
                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                    </svg>
                                    <span class="text-ms">編集</span>
                                </div>
                            </button>
                        </td>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->received_at}}
                        </th>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->supportType->type_name}}
                        </th>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->title}}
                        </th>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->client->client_num}}
                        </th>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->client->client_name}}
                        </th>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->user->name}}
                        </th>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->productSeries->series_name}}
                        </th>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->productVersion->version_name}}
                        </th>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->productCategory->category_name}}
                        </th>
                        <th scope="row" class="pl-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->client->user->name}}
                        </th>
                        <td class="px-1 py-2">
                            <button data-modal-target="deleteModal-{{$support->id}}" data-modal-toggle="deleteModal-{{$support->id}}"  class="block whitespace-nowrap text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-sm px-2 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
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
                <div id="deleteModal-{{$support->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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

                                <form action="{{route('support.destroy',$support->id)}}" method="POST" class="text-center m-auto">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" data-modal-hide="deleteModal-{{$support->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        削除
                                    </button>
                                </form>
                                <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    やっぱやめます
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </table>
        <div class="mt-2 mb-2 px-4">
        {{ $supports->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    </div>
</x-app-layout> --}}











<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                サポート一覧
                {{ $count }}件
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md  dark:text-gray-900 mt-4">
        <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
            <div class="w-full md:w-1/2">
                <form method="GET" action="{{ route('support.index') }}" id="search_form" class="flex items-center">
                    @csrf
                    <div class="flex flex-col md:flex-row w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="keywords" name="keywords" value="@if (isset($keywords)){{$keywords}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-s rounded-e bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="キーワード">
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="client_name" name="client_name" value="@if (isset($clientName)){{$clientName}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-s rounded-e bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="顧客名称">
                        </div>

                        {{-- <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <select name="product_category_id" id="product_category_id" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded-s rounded-e bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">製品系統</option>
                                @foreach ($productCategories as $productCategory)
                                <option value="{{ $productCategory->id }}" @if (isset($productCategoryId) && $productCategoryId == $productCategory->id) selected @endif>
                                    {{ $productCategory->category_name }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="flex mt-2 md:mt-0">
                            <div class="w-full md:ml-2">
                                <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="z-50 flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s rounded-e md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Filter') }}
                                    <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="filterDropdown" class="z-50 hidden w-56 p-3 bg-gray-100 rounded-e rounded-s shadow dark:bg-gray-600">
                                    <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                        サポート種別
                                    </h6>
                                    <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                        @foreach ($supportTypes as $supportType)
                                        <li class="flex items-center">
                                            <input id="supportType-{{ $supportType->id }}" type="checkbox" name="support_types[]" @if(in_array($supportType->id, $selectedSupportTypes)) checked @endif value="{{$supportType->id}}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                            <label for="supportType-{{ $supportType->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $supportType->type_name }}</label>
                                        </li>                       
                                        @endforeach
                                    </ul>
                                    <ul class="border my-2"></ul>
                                    <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                        製品系統
                                    </h6>
                                    <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                        @foreach ($productCategories as $productCategory)
                                        <li class="flex items-center">
                                            <input id="category-{{ $productCategory->id }}" type="checkbox" name="product_categories[]" @if(in_array($productCategory->id, $selectedProductCategories)) checked @endif value="{{$productCategory->id}}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                            <label for="category-{{ $productCategory->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $productCategory->category_name }}</label>
                                        </li>                       
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            {{-- 検索ボタン --}}
                            <button type="submit" id="search-button" form="search_form" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-s rounded-e border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </button>
                            {{-- リセットボタン --}}
                            <button type="button" value="reset" id="clear" form="search-form" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-s rounded-e border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                <button type="button" onclick="location.href='{{ route('support.create') }}'" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-s rounded-e bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    {{ __('Add') }}
                </button>
                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s rounded-e md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                        {{ __('Actions') }}
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                <button type="button" data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="block w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                    CSV一括登録
                                </button>
                            </li>
                        </ul>
                    </div>
                    {{-- <div>
                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s rounded-e md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Filter
                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="filterDropdown" class="z-10 hidden w-56 p-3 bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                事業部
                            </h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                @foreach ($departments as $department)
                                <li class="flex items-center">
                                    <input id="{{ $department->id }}" type="checkbox" value=""class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                    <label for="{{ $department->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $department->department_name }}</label>
                                </li>                       
                                @endforeach
                            </ul>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="md:w-auto md:ml-14 md:mr-2 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700  dark:text-gray-900 bg-gray-300">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="pl-4 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            №
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_num','顧客番号')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_name','顧客名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="pl-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('received_at','受付日')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('support_type_id','種別')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('title','表題')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>

                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('user_id','受付対応者')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('product_series_id','シリーズ')
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('product_version_id','バージョン')
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('product_category_id','系統')
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            営業担当
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supports as $support)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 font-medium hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                        <td class="pl-4 py-2 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$support->client->client_num}}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$support->client->client_name}}
                        </td>
                        <td class="pl-4 py-2 whitespace-nowrap">
                            {{$support->received_at}}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$support->supportType->type_name}}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$support->title}}
                        </td>

                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$support->user->name}}
                        </td>
                        <td class="px-1 py-3 whitespace-nowrap mr-2">
                            {{$support->productSeries->series_name}}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$support->productVersion->version_name}}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$support->productCategory->category_name}}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$support->client->user->name}}
                        </td>
                        <td class="pl-4 py-2 whitespace-nowrap">
                            <button onclick="location.href='{{route('support.edit',$support)}}'"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                <div class="flex">
                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                    </svg>
                                    <span class="text-ms">編集</span>
                                </div>
                            </button>
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="text-center">
                                <button class="button-edit" type="button" data-drawer-target="dupdateModal-{{$support->id}}" data-drawer-body-scrolling="false" data-drawer-show="dupdateModal-{{$support->id}}" data-drawer-placement="right" aria-controls="dupdateModal-{{$support->id}}">
                                    <div class="flex">
                                        <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                        </svg>
                                        <span class="text-ms">編集</span>
                                    </div>
                                </button>
                            </div>
                        </td>
                        <td class="py-2">
                            {{-- <button data-modal-target="deleteModal-{{$support->id}}" data-modal-show="deleteModal-{{$support->id}}"  class="button-delete" type="button">
                                <div class="flex">
                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                                    </svg>
                                    <span class="text-ms ">削除</span>
                                </div>
                            </button> --}}
                            <button type="button" data-modal-target="deleteModal-{{$support->id}}" data-modal-show="deleteModal-{{$support->id}}" class="button-delete-primary">
                                <div class="flex">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <span class="text-ms ">削除</span>
                                </div>
                            </button>
                        </td>
                    </tr>
                    {{-- 削除確認モーダル画面 Start --}}
                    <div id="deleteModal-{{$support->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                                <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                                <div class="p-6 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                                    <form action="{{route('support.destroy',$support->id)}}" method="POST" class="text-center m-auto">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" data-modal-hide="deleteModal-{{$support->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-s rounded-e text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                            削除
                                        </button>
                                    </form>
                                    <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        やっぱやめます
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- 削除確認モーダル画面 End --}}
                    <!-- 更新drawer --> 
                    <div id="dupdateModal-{{$support->id}}" class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform md:w-1/2 translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="dupdateModal-{{$support->id}}">
                        <div class="">
                            <h5 id="dupdateModal-{{$support->id}}" class="inline-flex items-center mb-4 font-semibold text-xl text-gray-500 dark:text-gray-400">
                                サポート詳細
                                {{-- -{{ $support->title }} --}}
                            </h5>
                            <button type="button" data-drawer-hide="dupdateModal-{{$support->id}}" aria-controls="dupdateModal-{{$support->id}}" class="text-gray-400 bg-transparent ml-8 hover:bg-gray-200 hover:text-gray-900 rounded-md text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <form id="updateForm-{{$support->id}}" method="POST" action="{{ route('support.update', $support->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- <label class="relative inline-flex items-center cursor-pointer mt-4">
                                <input type="hidden" name="is_enabled_{{$support->id}}" value="0">
                                <input type="checkbox" name="is_enabled_{{$support->id}}" id="is_enabled-{{$support->id}}" value="1" class="sr-only peer" {{ old('is_enabled_' . $support->id, $support->is_enabled) == 1 ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
                            </label> --}}

                            <div class="grid  gap-4 my-4 md:grid-cols-4">
                                <div class="relative z-0">
                                    <input type="text" id="client_num" name="client_num" value="{{ $support->client->client_num }}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                                    <label for="client_num" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">顧客番号</label>
                                </div>

                                <div class="relative z-0">
                                    <input type="text" id="client_name" name="client_name" value="{{ $support->client->client_name }}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                                    <label for="client_name" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">顧客名称</label>
                                </div>

                                <div class="relative z-0">
                                    <input type="text" id="sales_person" name="sales_person" value="{{ $support->client->user->name }}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                                    <label for="sales_person" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">営業担当</label>
                                </div>

                                <div class="relative z-0">
                                    <input type="text" id="department_id" name="department_id" value="{{ $support->client->department->department_name }}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                                    <label for="department_id" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">管轄事業部</label>
                                </div>
                            </div>

                            <div class="w-full flex flex-col col-span-2 mt-4">
                                <label for="title-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">表題</label>
                                <input type="text" maxlength="100" name="title_{{$support->id}}" id="title-{{$support->id}}" value="{{old('title' . $support->id, $support->title)}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                            </div>
                            @error('title_' . $support->id)
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <div class="grid gap-4 my-4 md:grid-cols-4">
                                <div class="w-full flex flex-col">
                                    <label for="received_at-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">受付日</label>
                                    <input type="date" maxlength="20" name="received_at_{{$support->id}}" id="received_at-{{$support->id}}" value="{{ old('received_at_' . $support->id, $support->received_at) }}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                                </div>
                                @error('received_at_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror

                                <div class="w-full flex flex-col">
                                    <label for="user_id" class="block font-medium text-gray-900 dark:text-white">受付対応者</label>
                                    <select name="user_id_{{$support->id}}" id="user_id-{{$support->id}}" value="{{old('user_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}"  @selected($user->id == $support->user_id)>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col">
                                <label for="request_content-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">内容</label>
                                <textarea name="request_content_{{$support->id}}" id="request_content-{{$support->id}}" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('request_content_' . $support->id , $support->request_content) }}</textarea>
                                @error('request_content_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col">
                                <label for="response_content-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">回答</label>
                                <textarea name="response_content_{{$support->id}}" id="response_content-{{$support->id}}" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('response_content_' . $support->id , $support->response_content) }}</textarea>
                                @error('response_content_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col">
                                <label for="internal_message-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">社内連絡欄</label>
                                <textarea name="internal_message_{{$support->id}}" id="internal_message-{{$support->id}}" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('internal_message_' . $support->id , $support->internal_message) }}</textarea>
                                @error('internal_message_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col">
                                <label for="internal_memo1-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">メモ欄</label>
                                <textarea name="internal_memo1_{{$support->id}}" id="internal_memo1-{{$support->id}}" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('internal_memo1_' . $support->id , $support->internal_memo1) }}</textarea>
                                @error('internal_memo1_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="grid gap-4 my-4 md:grid-cols-2">
                                <div class="w-full flex flex-col">
                                    <label for="support_type_id" class="block font-medium text-gray-900 dark:text-white">サポート種別</label>
                                    <select name="support_type_id_{{$support->id}}" id="support_type_id-{{$support->id}}" value="{{old('support_type_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($supportTypes as $supportType)
                                        <option value="{{ $supportType->id }}"  @selected($supportType->id == $support->support_type_id)>{{ $supportType->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('support_type_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror

                                <div class="w-full flex flex-col">
                                    <label for="support_time_id" class="block font-medium text-gray-900 dark:text-white">サポート時間</label>
                                    <select name="support_time_id_{{$support->id}}" id="support_time_id-{{$support->id}}" value="{{old('support_time_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($supportTimes as $supportTime)
                                        <option value="{{ $supportTime->id }}"  @selected($supportTime->id == $support->support_time_id)>{{ $supportTime->time_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('support_time_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="grid gap-4 my-4 md:grid-cols-3">
                                <div class="w-full flex flex-col">
                                    <label for="product_series_id" class="block font-medium text-gray-900 dark:text-white">製品シリーズ</label>
                                    <select name="product_series_id_{{$support->id}}" id="product_series_id-{{$support->id}}" value="{{old('product_series_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($productSeriess as $productSeries)
                                        <option value="{{ $productSeries->id }}"  @selected($productSeries->id == $support->product_series_id)>{{ $productSeries->series_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_series_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                                <div class="w-full flex flex-col">
                                    <label for="product_version_id" class="block font-medium text-gray-900 dark:text-white">製品バージョン</label>
                                    <select name="product_version_id_{{$support->id}}" id="product_version_id-{{$support->id}}" value="{{old('product_version_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($productVersions as $productVersion)
                                        <option value="{{ $productVersion->id }}"  @selected($productVersion->id == $support->product_version_id)>{{ $productVersion->version_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_version_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                                <div class="w-full flex flex-col">
                                    <label for="product_category_id" class="block font-medium text-gray-900 dark:text-white">製品系統</label>
                                    <select name="product_category_id_{{$support->id}}" id="product_category_id-{{$support->id}}" value="{{old('product_category_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($productCategories as $productCategory)
                                        <option value="{{ $productCategory->id }}"  @selected($productCategory->id == $support->product_category_id)>{{ $productCategory->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_category_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </div>
                            <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_finished_{{ $support->id }}" name="is_finished_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_finished)
                                            <input id="is_finished_{{ $support->id }}" name="is_finished_{{ $support->id }}" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @else
                                            <input id="is_finished_{{ $support->id }}" name="is_finished_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_finished_{{ $support->id }}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">対応完了済</label>
                                    </div>
                                    @error('is_finished_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_faq_target1_{{ $support->id }}" name="is_faq_target_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_faq_target === 1)
                                            <input id="is_faq_target_{{ $support->id }}" name="is_faq_target_{{ $support->id }}" type="checkbox" checked="checked" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @else
                                            <input id="is_faq_target_{{ $support->id }}" name="is_faq_target_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_faq_target_{{ $support->id }}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">FAQ対象</label>
                                    </div>
                                    @error('is_faq_target_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_disclosured1_{{ $support->id }}" name="is_disclosured_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_disclosured === 1)
                                            <input id="is_disclosured_{{ $support->id }}" name="is_disclosured_{{ $support->id }}" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @else
                                            <input id="is_disclosured_{{ $support->id }}" name="is_disclosured_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_disclosured_{{ $support->id }}" class="cursor-pointer    w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">顧客開示</label>
                                    </div>
                                    @error('is_disclosured_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_troubled1_{{ $support->id }}" name="is_troubled_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_troubled === 1)
                                            <input id="is_troubled_{{ $support->id }}" name="is_troubled_{{ $support->id }}" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @else
                                            <input id="is_troubled_{{ $support->id }}" name="is_troubled_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_troubled_{{ $support->id }}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">トラブル</label>
                                    </div>
                                    @error('is_troubled_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                                <li class="w-full dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_confirmed1_{{ $support->id }}" name="is_confirmed_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_confirmed === 1)
                                            <input id="is_confirmed_{{ $support->id }}" name="is_confirmed_{{ $support->id }}" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" >
                                        @else
                                            <input id="is_confirmed_{{ $support->id }}" name="is_confirmed_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_confirmed_{{ $support->id }}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">上長確認済</label>
                                    </div>
                                    @error('is_confirmed_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                            </ul>




                            {{-- <div class="bg-light px-3 py-2 mb-3 font-semibold dark:text-gray-100">以下は省略可</div>


                            <div id="accordion-arrow-icon" data-accordion="open">
                                <h2 id="accordion-arrow-icon-heading-2">
                                    <button type="button" class="flex items-center justify-between w-full p-2 rounded font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-arrow-icon-body-2{{$support->id}}" aria-expanded="false" aria-controls="accordion-arrow-icon-body-2{{$support->id}}">
                                        <span>パスワードを変更する</span>
                                        <svg class="w-4 h-4 shrink-0 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-arrow-icon-body-2{{$support->id}}" class="hidden" aria-labelledby="accordion-arrow-icon-heading-2">
                                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                                        <div class="w-full flex flex-col">
                                            <label class="font-semibold dark:text-gray-100 leading-none mt-2">パスワード</label>
                                            <input type="password" name="password_{{$support->id}}" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password-{{$support->id}}" value="{{old('password_' . $support->id)}}">
                                        </div>
                                        @error('password_' . $support->id)
                                            <div class="text-red-500">{{$message}}</div>
                                        @enderror
                                        
                                        <div class="w-full flex flex-col">
                                            <label class="font-semibold dark:text-gray-100 leading-none mt-2">パスワード（確認）</label>
                                            <input type="password" name="password_{{$support->id}}_confirmation" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password_confirmation-{{$support->id}}" value="{{old('password_confirmation_' . $support->id)}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                             --}}
                            {{-- <div class="w-full flex flex-col">
                                <label class="font-semibold dark:text-gray-100 leading-none mt-2">パスワード</label>
                                <input type="password" name="password_{{$support->id}}" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password-{{$support->id}}" value="{{old('password_' . $support->id)}}">
                            </div>
                            @error('password_' . $support->id)
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                            
                            <div class="w-full flex flex-col">
                                <label class="font-semibold dark:text-gray-100 leading-none mt-2">パスワード（確認）</label>
                                <input type="password" name="password_{{$support->id}}_confirmation" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password_confirmation-{{$support->id}}" value="{{old('password_confirmation_' . $support->id)}}">
                            </div> --}}

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <button type="button" onclick="submitAndUpdateDrawer({{$support->id}})" class="w-full justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ __('Update') }}
                                </button>
                                <button type="button" data-modal-target="deleteModal-{{$support->id}}" data-modal-show="deleteModal-{{$support->id}}" class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="mt-1 mb-1 px-4">
        {{ $supports->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    </div>


<!-- CSV一括登録 modal -->
<div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    CSV一括アップロード
                </h3>
                <button type="button" id="close_button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6 mr-20 mt-4">
                <form action="{{ route('support.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center" id="csv_form1">
                    @csrf
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="csv_upload"></label>
                    <input type="file" name="csv_upload"  id="csv_upload_file"  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-s rounded-e cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="csv_upload_help">
                </form>
            </div>
            <!-- Modal footer -->
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
</div>



<script>
    function submitAndUpdateDrawer(supportId) {
        // 保存処理（ここではLocalStorageを使用）
        localStorage.setItem('updateDrawerId', supportId);

        // フォームのsubmit
        document.getElementById('updateForm-' + supportId).submit();
    }
</script>

<!-- バリデーションエラー時にDrawerを開くスクリプト -->
@if ($errors->any())
    <style>
        /* オーバーレイのスタイルを定義 */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* グレーで透過させる */
            /* z-index: 40; Drawerよりも大きな値 */
        }
    </style>
    <script>
        // ページ遷移後に初回のみ実行するための変数
        let isValidationProcessed = false;

        document.addEventListener('DOMContentLoaded', function () {
            let drawerId = localStorage.getItem('updateDrawerId');
            
            // ページ遷移後初回のみ実行
            if (!isValidationProcessed && drawerId !== null) {
                // オーバーレイを作成
                const overlay = document.createElement('div');
                overlay.classList.add('overlay'); // オーバーレイのクラスを追加
                document.body.appendChild(overlay); // bodyに追加

                // Drawerを表示
                const drawer = document.getElementById('dupdateModal-' + drawerId);
                drawer.classList.remove('translate-x-full');
                localStorage.removeItem('updateDrawerId');
                console.log(drawerId);
                
                // 変数をtrueに設定して初期化を行わないようにする
                isValidationProcessed = true;

                // bodyにoverflow-hiddenクラスを追加
                document.body.classList.add('overflow-hidden');

                // Drawerのz-indexよりも大きな値を設定
                const drawerZIndex = getComputedStyle(drawer).zIndex;
                const overlayZIndex = parseInt(drawerZIndex) - 1;
                overlay.style.zIndex = overlayZIndex;

                // オーバーレイをクリックしたときに閉じる
                overlay.addEventListener('click', function () {
                    closeDrawer();
                });

                // ボタンをクリックしたときにも閉じる
                const closeButton = document.querySelector('[data-drawer-hide="dupdateModal-' + drawerId + '"]');
                if (closeButton) {
                    closeButton.addEventListener('click', function () {
                        closeDrawer();
                    });
                }

                function closeDrawer() {
                    // Drawerを非表示にする
                    drawer.classList.add('translate-x-full');
                    
                    // オーバーレイを削除する
                    overlay.remove();
                    
                    // bodyのoverflow-hiddenクラスを削除
                    document.body.classList.remove('overflow-hidden');
                }
            }
        });
    </script>
@endif

    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        // const uploadForm = document.getElementById('csv_form1');
        // const uploadButton = document.getElementById('upload-button');
        // const spinner = document.getElementById('spinner');
        // const uploadOverlay = document.getElementById('uploadOverlay');
        // const fileInput = document.getElementById('csv_upload_file');
        // const closeButton = document.getElementById('close_button');

        //     uploadForm.addEventListener('submit', function (event) {
        //         // ファイルが添付されているかを確認
        //         if (fileInput.files.length === 0) {
        //             // ファイル未添付の場合は処理を中止
        //             event.preventDefault();
        //             return;
        //         }

        //         // アップロードボタンを非表示にし、スピナーを表示
        //         uploadButton.style.display = 'none';
        //         closeButton.style.display = 'none';
        //         spinner.style.display = 'block';
        //         fileInput.readOnly = true;

        //         // 画面をロック
        //         uploadOverlay.style.display = 'block';

        //         // フォームをサブミット
        //         uploadForm.submit();
        //     });
        // });
    </script>

{{-- 行がクリックされたときに発火するJavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 各行のクリックイベントを設定
        var rows = document.querySelectorAll('.clickable-row');

        rows.forEach(function (row) {
            row.addEventListener('click', function () {
                // 選択された行に 'selected' クラスを追加
                this.classList.toggle('selected');
            });
        });
    });
</script>

{{-- 選択された行に適用されるスタイル --}}
<style>
    .selected {
        background-color: #f0f0f0; /* 任意の背景色 */
    }
</style>


{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const uploadForm = document.getElementById('csv_form1');
    const uploadButton = document.getElementById('upload-button');
    const spinner = document.getElementById('spinner');

    uploadButton.addEventListener('click', function (event) {
        event.preventDefault();

        // 画面をロック
        addOverlay();

        // アップロードボタンを非表示にし、スピナーを表示
        uploadButton.style.display = 'none';
        spinner.style.display = 'block';

        // フォームをサブミット
        uploadForm.submit();
    });

    function addOverlay() {
        const overlay = document.createElement('div');
        overlay.id = 'overlay';
        document.body.appendChild(overlay);
    }

    function removeOverlay() {
        const overlay = document.getElementById('overlay');
        if (overlay) {
            overlay.parentNode.removeChild(overlay);
        }
    }

    // フォームの送信完了時に実行
    uploadForm.addEventListener('submit', function () {
        // 画面ロックを解除
        removeOverlay();
    });
});
</script>

<style>
    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* 透明度を指定できます */
        z-index: 1000; /* 必要に応じて適切なz-indexを設定してください */
    }
</style> --}}

<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
</x-app-layout>