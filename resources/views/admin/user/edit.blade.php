    {{-- favicon --}}
<link rel="shortcut icon" href="{{ asset('/favicon-sales.ico') }}">

<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl dark:text-gray-100 leading-tight">
        ユーザ編集
    </h2>
    <x-message :message="session('message')"/>
    <div class="flex flex-row-reverse">
        <x-general-button class="mt-4" onclick="location.href='{{route('user.index', $user)}}'">
            戻る
        </x-general-button>
    </div>


    {{-- <x-input-error class="mb-4":messages="$errors->all()"/> --}}

{{-- バリデーションエラーを画面表示する※componentsを利用しない記述 --}}
    <div>  
        @if ($errors->any())  
            <ul>  
                @foreach ($errors->all() as $error)  
                    <li class="text-red-600">{{ $error }}</li>  
                @endforeach  
            </ul>  
        @endif  
    </div>




</x-slot>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="mx-4 sm:p-8">
    <form method="post" action="{{route('user.update',$user)}}" enctype="multipart/form-data">
        @csrf
        @method('patch')


        <label class="relative inline-flex items-center cursor-pointer">
        <input type="hidden" name="is_finished" id="is_finished" value="0">
        @if($user->is_finished === 1)
            <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer" checked="checked">
        @else
            <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer">
        @endif
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
        </label> 

        <div class="md:flex items-center mt-8">
            <div class="w-full flex flex-col">
                <label for="employee_id" class="mt-4 font-semibold dark:text-gray-100 leading-none">社員番号</label>
                <input type="text" name="employee_id" oninput="value = value.replace(/[^0-9]+/i,'');" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="employee_id" value="{{old('employee_id',$user->employee_id)}}" placeholder="例）000999">
            </div>
        </div>

        <div class="md:flex items-center">
            <div class="w-full flex flex-col">
                <label for="name" class="mt-4 font-semibold dark:text-gray-100 leading-none">氏名</label>
                <input type="text" name="name" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="name" value="{{old('name',$user->name)}}" placeholder="例）9999000100">
            </div>
        </div>

        <div class="w-full flex flex-col">
            <label for="name_kana" class="mt-4 font-semibold dark:text-gray-100 leading-none">カナ氏名</label>
            <input type="text" name="name_kana" class="w-auto py-2 border border-gray-300 rounded-md mt-1 placeholder-gray-500" id="name_kana"  cols="30" rows="10" value="{{ old('name_kana',$user->name_kana)}}">
        </div>

        <div class="w-full flex flex-col">
            <label for="email" class="mt-4 font-semibold dark:text-gray-100 leading-none">E-MAIL</label>
            <input type="text" name="email" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="email" value="{{old('email',$user->email)}}" placeholder="例）学校法人  〇〇大学">
        </div>

        <div class="w-full flex flex-col">
            <label for="role_id" class="mt-4 font-semibold dark:text-gray-100 leading-none">権限</label>
            {{-- <input type="text" name="role_id" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="role_id" value="{{old('role_id',$user->role->role_name)}}" placeholder="例）バージョンアップ"> --}}
            <select name="role_id" class=" w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="role_id" value="{{old('role_id')}}">
                @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if($role->id == $user->role_id) selected @endif>{{ $role->role_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full flex flex-col">
            <label for="employee_status_id" class="mt-4 font-semibold dark:text-gray-100 leading-none">雇用状態</label>
            <select name="employee_status_id" class=" w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="employee_status_id" value="{{old('employee_status_id')}}">
                @foreach($e_statuses as $e_status)
                        <option value="{{ $e_status->id }}" @if($e_status->id == $user->employee_status_id) selected @endif>{{ $e_status->employee_status_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="bg-light px-3 py-2 mb-3 font-semibold dark:text-gray-100" v-if="state == 'edit'">以下は省略可</div>

        <div class="w-full flex flex-col">
            <label class="mt-4 font-semibold dark:text-gray-100  leading-none">パスワード</label>
            <input type="password" name="password" autocomplete="new-password" class="form-control w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1">
        </div>

        <div class="w-full flex flex-col">
            <label class="mt-4 font-semibold dark:text-gray-100 leading-none">パスワード（確認）</label>
            <input type="password" name="password" autocomplete="new-password" class="form-control w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1">
        </div>

        {{-- <div class="w-full flex flex-col">
            <label for="created_at" class="font-semibold dark:text-gray-100 leading-none mt-4">作成日</label>
            <input type="date" min="2000-01-01" max="2100-12-31" name="created_at" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="created_at" value="{{old('created_at',$user->created_at)}}">
        </div> --}}

        {{-- <div class="w-full flex flex-col">
            <label for="return_at" class="font-semibold dark:text-gray-100 leading-none mt-4">返却日</label>
            <input type="date" min="2000-01-01" max="2100-12-31" name="return_at" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="return_at" value="{{old('return_at',$user->return_at)}}">
        </div> --}}

        


        

        {{-- <div class="w-full flex flex-col">
            <label for="image" class="font-semibold dark:text-gray-100 leading-none mt-4">画像 </label>
            <div>
            <input id="image" type="file" name="image">
            </div>
        </div> --}}

        <x-primary-button class="mt-4">
            変更を確定
        </x-primary-button>
        
    </form>
</div>
</div>


</x-app-layout>