    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ asset('/favicon-sales.ico') }}">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            権限管理
        </h2>
        <div class="flex flex-row-reverse">
            <x-general-button class="mt-4" onclick="location.href='/keepdata/create'">
                新規作成
            </x-general-button>
        </div>
        <x-message :message="session('message')" />
    </x-slot>

    {{-- 投稿一覧表示用のコード --}}
    {{-- <div class="mt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach ($keepdatas as $keepdata)
            <div class="mx-4 sm:p-sm">
                <div class="mt-2">
                    <div class="bg-white w-auto  rounded-md px-10 py-1 shadow-lg hover:ring-4">
                        <div class="mt-2">
                            <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer">
                                <a href="{{route('keepdata.edit',$keepdata)}}">{{ $keepdata->projectnumber }}</a>
                            </h1>
                            <hr class="w-full">
                            <span class="mt-1 text-gray-600 py-1"> {{$keepdata->clientname}}</span>
                            <span class="mt-1 text-gray-600 py-1 mx-3"> {{$keepdata->purpose}}</span>
                            <br>
                            <span class="mt-1 text-gray-600 py-1 mx-3">預託日: {{$keepdata->keepdate}}</span>
                            <span class="mt-1 text-gray-600 py-1 mx-3">返却日: {{$keepdata->returndate}}</span>
                            <span class="mt-1 text-gray-600 py-1">完了フラグ：{{$keepdata->finish}}</span>
                            <div class="text-sm font-semibold flex flex-row-reverse">
                                <p>
                                    {{$keepdata->user->name}} 
                                    {{$keepdata->created_at->diffForHumans()}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}

    {{-- 絞り込み検索 --}}
    <div class="w-2/3 h-32 rounded-md mt-2 border-2 mx-auto dark:text-white">
        <form method="">   
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="search" id="default-search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="顧客名" required>
                <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
            <label for="countries" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-white">完了フラグ</label>
                <select  name="finish" value="0" class=" w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">未選択</option>

                    @foreach($keepdatas as $keepdata)
                    <option value="{{$keepdata->status_flag}}">{{$keepdata->status_flag}}</option>
                    @endforeach
                </select>
        </form>   
    </div>


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg ml-32 mr-32 mt-24">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

            {{-- テーブルヘッダスタート --}}
            <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="px-4 py-3">
                        <div class="flex items-center">
                            @sortablelink('projectnumber','プロジェクト№')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center">
                            @sortablelink('clientname','顧客名')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            用途
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="pl-4 py-3">
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
                    </th>
                    <th scope="col" class="px-2 py-3">
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
                    </th>
                    <th scope="col" class="px-2 py-3">
                        <div class="flex items-center">
                            作成日
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">編集</span>
                    </th>
                </tr>
            </thead>
            {{-- テーブルヘッダエンド --}}

            {{-- テーブルボディスタート --}}
            @foreach ($users as $user)
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </th>
                        <td class="px-1 py-4">
                            {{$user->email}}
                        </td>
                        <td class="px-6 py-4">
                            {{$user->created_at}}
                        </td>
                        <td class="px-4 py-4">
                            {{$user->updated_at}}
                        </td>
                        <td class="px-1 py-4">
                            {{$user->}}
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
                        @endif
                        <td class="px-2 py-4">
                            {{$keepdata->created_at->diffForHumans()}}
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{route('keepdata.edit',$keepdata)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編集</a>
                        </td>
                        </td>
                    </tr>
                </tbody>
            @endforeach
            {{-- テーブルボディエンド --}}

        </table>

        <div class="mt-8 mb-8">
            {{-- {{ $keepdatas->appends(request()->query())->links() }}  //デフォルトページネーション --}} 
            {{ $keepdatas->withQueryString()->links('vendor.pagination.custom-tailwind') }}  
        </div> 

    </div>
    {{-- <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </div> --}}

</x-app-layout>