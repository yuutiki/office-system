    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ asset('/favicon-sales.ico') }}">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            法人情報の一覧
        </h2>
        <div class="flex flex-row-reverse">
            <x-general-button class="mt-4" onclick="location.href='/clientcorporate/create'">
                新規作成
            </x-general-button>
        </div>
        <x-message :message="session('message')" />
    </x-slot>

    {{-- 絞り込み検索 --}}
    {{-- <div class="w-1/2 h-32 rounded-md mt-2 border-2 mx-auto dark:text-white">
        <form method="GET" >
                <label for="countries" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-white">完了フラグ</label>
                    <select  name="finish" value="0" class=" w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">未選択</option>

                        @foreach($keepdatas as $keepdata)
                        <option value="{{$keepdata->status_flag}}">{{$keepdata->status_flag}}</option>
                        @endforeach
                    </select>
        </form>
    </div> --}}
    {{-- テーブル表示 --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg ml-32 mr-32 mt-24">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="px-4 py-3">
                        <div class="flex items-center">
                            @sortablelink('client_corporate_id','法人ID')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center">
                            @sortablelink('client_corporate_name','法人名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    {{-- <th scope="col" class="pl-4 py-3">
                        <div class="flex items-center">
                            @sortablelink('keepdate','預託日')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center">
                            @sortablelink('returndate','返却日')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th> --}}
                    {{-- <th scope="col" class="px-2 py-3">
                        <div class="flex items-center">
                            @sortablelink('user_id','担当者')
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-2 py-3">
                        <div class="flex items-center">
                            @sortablelink('status_flag','ステータス')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th> --}}
                    <th scope="col" class="px-2 py-3">
                        <div class="flex items-center">
                            作成日
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="px-2 py-3">
                        <div class="flex items-center">
                            更新日
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">編集</span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">顧客追加</span>
                    </th>
                </tr>
            </thead>
            @foreach ($clientcorporates as $clientcorporate)
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$clientcorporate->client_corporate_id}}
                        </th>
                        <td class="px-1 py-4">
                            {{$clientcorporate->client_corporate_name}}
                        </td>
                        {{-- <td class="px-6 py-4">
                            {{$clientcorporate->client_corporate_kana}}
                        </td> --}}
                        {{-- <td class="px-4 py-4">
                            {{$keepdata->keepdate}}
                        </td>
                        <td class="px-1 py-4">
                            {{$keepdata->returndate}}
                        </td>
                        <td class="px-2 py-4">
                            {{$keepdata->user->name}}
                        </td>
                        @if($keepdata->status_flag == "0")
                            <td class="px-2 py-4 text-fuchsia-300">
                                未返却
                            </td>
                        @else
                            <td class="px-2 py-4">
                                返却済
                            </td>
                        @endif --}}
                        <td class="px-2 py-4">
                            {{$clientcorporate->created_at->format('y-m-d')}}
                        </td>
                        <td class="px-2 py-4">
                            {{$clientcorporate->updated_at->format('y-m-d')}}
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{route('clientcorporate.create',$clientcorporate)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編集</a>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{route('client.create',$clientcorporate)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">顧客追加</a>
                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>
        <div class="mt-8 mb-8">
        {{-- {{ $keepdatas->appends(request()->query())->links() }}   --}}
        {{ $clientcorporates->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    </div>
</x-app-layout>