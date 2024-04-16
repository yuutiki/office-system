<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                ユーザ編集
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('user.index', $user)}}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="mx-4 sm:p-8">
    <form method="post" action="{{route('user.update',$user)}}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <label class="relative inline-flex items-center cursor-pointer mt-4">
        <input type="hidden" name="is_enabled" id="is_enabled" value="0">
        @if($user->is_enabled === 1)
            <input type="checkbox" name="is_enabled" id="is_enabled" value="1" class="sr-only peer" checked="checked">
        @else
            <input type="checkbox" name="is_enabled" id="is_enabled" value="1" class="sr-only peer">
        @endif
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
        </label> 

        <div class="mt-2 p-4 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="grid gap-4 mb-4 md:grid-cols-3 ">
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                    <label for="employee_num" class="font-semibold dark:text-gray-100 leading-none mt-2">社員番号</label>
                    <input type="text" name="employee_num" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="employee_num" value="{{old('employee_num', $user->employee_num)}}" placeholder="例）000999">
                    </div>
                </div>
                @error('employee_num')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="employee_status_id" class="font-semibold dark:text-gray-100 leading-none mt-2">雇用状態</label>
                    <select name="employee_status_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="employee_status_id" value="{{old('employee_status_id')}}">
                        @foreach($e_statuses as $e_status)
                        <option value="{{ $e_status->id }}" @selected($e_status->id == $user->status_id)>{{ $e_status->employee_status_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('employee_status_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="role_id" class="font-semibold dark:text-gray-100 leading-none mt-2">権限</label>
                    <select name="role_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="role_id" value="{{old('role_id')}}">
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}"  @selected($role->id == $user->role_id)>{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('role_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
        <div class="grid gap-4 mb-4 md:grid-cols-2">
            <div class="md:flex items-center">
                <div class="w-full flex flex-col">
                <label for="name" class="font-semibold dark:text-gray-100 leading-none mt-2">氏名</label>
                <input type="text" name="name" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="name" value="{{old('name', $user->name)}}" placeholder="例）田中 太郎">
                </div>
            </div>
            @error('name')
                <div class="text-red-500">{{$message}}</div>
            @enderror
            <div class="w-full flex flex-col">
                <label for="kana_name" class="font-semibold dark:text-gray-100 leading-none mt-2">カナ氏名</label>
                <input type="text" name="kana_name" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="kana_name" value="{{old('kana_name', $user->kana_name)}}">
            </div>
            @error('kana_name')
                <div class="text-red-500">{{$message}}</div>
            @enderror
        </div>
    </div>

        <div class="mt-4 p-4 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="grid gap-4 mb-4 md:grid-cols-3">
                <div class="w-full flex flex-col">
                    <label for="ext_phone" class="font-semibold dark:text-gray-100 leading-none mt-2">外線番号</label>
                    <input type="text" name="ext_phone" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="ext_phone" value="{{old('ext_phone', $user->ext_phone)}}" placeholder="例）999-9999-9999">
                </div>
                @error('ext_phone')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="int_phone" class="font-semibold dark:text-gray-100 leading-none mt-2">内線番号</label>
                    <input type="text" name="int_phone" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="int_phone" value="{{old('int_phone', $user->int_phone)}}" placeholder="例）999">
                </div>
                @error('int_phone')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="email" class="font-semibold dark:text-gray-100 leading-none mt-2">E-MAIL</label>
                    <input type="text" name="email" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="email" value="{{old('email', $user->email)}}" placeholder="例）test＠gmail.com">
                </div>
                @error('email')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="mt-4 p-4 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="grid gap-4 mb-4 md:grid-cols-3 ">
                <div class="w-full flex flex-col">
                    <label for="company_id" class="font-semibold dark:text-gray-100 leading-none mt-2">会社</label>
                    <select name="company_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="company_id" value="{{old('company_id')}}">
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" @selected($company->id == $user->company_id)>{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('company_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <div class="w-full flex flex-col">
                    <label for="department_id" class="font-semibold dark:text-gray-100 leading-none mt-2">事業部</label>
                    <select name="department_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="department_id" value="{{old('department_id')}}">
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}"  @selected($department->id == $user->department_id)>{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('department_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <div class="w-full flex flex-col">
                    <label for="division_id" class="font-semibold dark:text-gray-100 leading-none mt-2">部署</label>
                    <select name="division_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="division_id" value="{{old('division_id')}}">
                        @foreach($divisions as $division)
                        <option value="{{ $division->id }}" @selected($division->id == $user->division_id)>{{ $division->division_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('division_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="bg-light px-3 py-2 mb-3 font-semibold dark:text-gray-100">以下は省略可</div>

        <div class="w-full flex flex-col">
            <label class="font-semibold dark:text-gray-100 leading-none mt-2">パスワード</label>
            <input type="password" name="password" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password" value="{{old('password')}}">
        </div>
        @error('password')
            <div class="text-red-500">{{$message}}</div>
        @enderror

        <div class="w-full flex flex-col">
            <label class="font-semibold dark:text-gray-100 leading-none mt-2">パスワード（確認）</label>
            <input type="password" name="password_confirmation" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password_confirmation" value="{{old('password_confirmation')}}">
        </div>

        {{-- <div class="w-full flex flex-col">
            <label for="image" class="font-semibold dark:text-gray-100 leading-none mt-4">画像 </label>
            <div>
            <input id="image" type="file" name="image">
            </div>
        </div> --}}

        <x-primary-button class="mt-4 mb-4">
            変更を確定
        </x-primary-button>
        
    </form>
</div>
</div>
</x-app-layout>