    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ asset('/favicon-sales.ico') }}">
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                ユーザ一覧
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='/user/create'">
                    新規作成
                </x-general-button>
                <x-message :message="session('message')" />
            </div>
        </div>

    </x-slot>
    
    {{-- 絞り込み検索 start--}}
        <div class="w-5/6 h-auto mt-4 border-b-2 mx-auto dark:text-white">
            <form method="GET" action="{{ route('user.index') }}" id="userform">
                <div class="md:flex flex-wrap">
                    {{-- 　start --}}
                    <div class="relative w-auto ml-2 mt-2">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="search" name="employee_num" value="@if (isset($employee_num)) {{$employee_num}} @endif" oninput="value = value.replace(/[^0-9]+/i,'');" class=" block w-full py-1.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="社員番号" >
                    </div>

                    <div class="relative w-auto ml-2 mt-2">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="search" name="user_name" value="@if (isset($user_name)) {{$user_name}} @endif" class="block w-full py-1.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="氏名" >    
                    </div>
                    {{-- 　end --}}
                    {{-- 横並びセレクトボックス2つ　start --}}
                    <div class="flex-nowrap">
                        <select  name="role1" class="mt-2 w-auto ml-2 py-1.5 text-sm rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">権限全て</option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" @if($role->id == $role1) selected @endif>{{$role->role_name}}</option>
                            @endforeach
                        </select>
                    
                        <select  name="employee_status" class="mt-2 w-auto ml-2 py-1.5 text-sm rounded-lg bg-gray-50 border dark:bg-gray-700  text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 dark:placeholder-gray-400 focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500">
                            <option value="">状況全て</option>
                            @foreach($e_statuses as $e_statuse)
                                <option value="{{$e_statuse->id}}"@if($e_statuse->id == $employee_status) selected @endif>{{$e_statuse->employee_status_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- 横並びセレクトボックス2つ　end --}}
                </div>
            </form>
        </div>
        <div class="w-5/6 mt-4 ml-8 flex justify-end">
            <button type="submit" form="userform" class="px-6 py-1.5 font-medium text-sm rounded-lg text-white focus:outline-none focus:ring-4 focus:ring-blue-300 bg-blue-700 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">検索</button>
            <button type="reset" form="userform" class="ml-2 px-4 py-1.5 font-medium text-sm rounded-lg text-white focus:outline-none focus:ring-4 focus:ring-blue-300 bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800">リセット</button>
        </div>


    {{-- 絞り込み検索 end--}}

    <div class="w-5/6 relative overflow-x-auto shadow-md sm:rounded-lg mx-auto mt-8 boeder-2 bg-gray-300 dark:bg-gray-700">
        <table class="w-full text-sm font-medium text-left text-gray-800 dark:text-gray-400 ">

            {{-- テーブルヘッダ start --}}
            <thead class="text-sm text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="pl-6 py-3">
                        <div class="flex items-center">
                            @sortablelink('employee_id','社員番号')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center">
                            @sortablelink('name','氏名')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center">
                            @sortablelink('email','E-MAIL')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center">
                            @sortablelink('role_id','権限')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center">
                            @sortablelink('last_login_at','最終ログイン日時')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center">
                            @sortablelink('employee_status_id','在職')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3">
                        <div class="flex items-center">
                            作成日
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">編集</span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">削除</span>
                    </th>
                </tr>
            </thead>
            {{-- テーブルヘッダ end --}}

            {{-- テーブルボディスタート --}}
            @foreach ($users as $user)
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 dark:text-white dark:border-gray-700">
                        <td class="pl-6 py-3 max-w-0">
                            {{$user->employee_id}}
                        </td>
                        <td  class="px-1 py-3 max-w-0 truncate">
                            {{$user->name}}
                        </td>
                        <td class="px-1 py-3 max-w-0 truncate">
                            {{$user->email}}
                        </td>
                        <td class="px-1 py-3 max-w-0">
                            {{$user->role->role_name}}
                        </td>
                        <td class="px-1 py-3 max-w-0">
                            {{$user->last_login_at}}
                        </td>
                        <td class="px-1 py-3 max-w-0">
                            {{$user->employee_status->employee_status_num}}:
                            {{$user->employee_status->employee_status_name}}
                        </td>
                        <td class="px-1 py-3 max-w-0">
                            {{$user->created_at->diffForHumans()}}
                        </td>

                        <td class="py-3 text-center">
                            <a href="{{route('user.edit',$user)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編集</a>
                        </td>


                        <td class="py-3">
                            <form action="{{route('user.destroy',$user)}}" method="POST" class="text-center m-auto">
                                @csrf
                                @method('delete')
                                <button type="submit" onClick="return confirm('本当に削除しますか？')" class=" font-medium text-red-600 dark:text-red-500 hover:underline">削除</button>
                            </form>
                        </td>


                    </tr>
                </tbody>
            @endforeach
            {{-- テーブルボディエンド --}}

        </table> 
    </div>
    <div class="w-5/6 mx-auto">
        <div class="mt-2 mb-1">
            {{-- {{ $users->appends(request()->query())->links() }}  //デフォルトページネーション --}} 
            {{ $users->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div>
    </div>

</x-app-layout>