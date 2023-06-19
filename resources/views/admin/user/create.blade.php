    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ asset('/favicon-sales.ico') }}">
    <script src="../path/to/flowbite/dist/_atpicker.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js?ver=3.4.1"></script> 

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-100 leading-tight">
            ユーザ新規登録
        </h2>
        <x-message :message="session('message')"/>
        <div class="flex flex-row-reverse">
            <x-general-button class="mt-4" onclick="location.href='{{route('user.index')}}'">
                戻る
            </x-general-button>
        </div>

        {{-- <x-input-error class="mb-4":messages="$errors->all()"/> --}}

    {{-- バリデーションエラーを画面表示する※componentsを利用しない記述 --}}
        {{-- <div>  
            @if ($errors->any())  
                <ul>  
                    @foreach ($errors->all() as $error)  
                        <li class="text-red-600">{{ $error }}</li>  
                    @endforeach  
                </ul>  
            @endif  
        </div> --}}

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">
        <form method="post" action="{{route('user.store')}}" enctype="multipart/form-data">
            @csrf
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_finished" id="is_finished" value="0">
                <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
            </label>

            <div class="md:flex items-center mt-8">
                <div class="w-full flex flex-col">
                <label for="employee_id" class="font-semibold dark:text-gray-100 leading-none mt-4">社員番号</label>
                <input type="text" name="employee_id" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="employee_id" value="{{old('employee_id')}}" placeholder="例）000999">
                </div>
            </div>
            <div class="md:flex items-center">
                <div class="w-full flex flex-col">
                <label for="name" class="font-semibold dark:text-gray-100 leading-none mt-4">氏名（必須）</label>
                <input type="text" name="name" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="name" value="{{old('name')}}" placeholder="例）田中 太郎">
                </div>
            </div>
            @error('name')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col">
                <label for="name_kana" class="font-semibold dark:text-gray-100 leading-none mt-4">カナ氏名（必須）</label>
                <input type="text" name="name_kana" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="name_kana" value="{{old('name_kana')}}">
            </div>
            @error('name_kana')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col">
                <label for="email" class="font-semibold dark:text-gray-100 leading-none mt-4">E-MAIL（必須）</label>
                <input type="text" name="email" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="email" value="{{old('email')}}" placeholder="例）test＠gmail.com">
            </div>
            @error('email')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col">
                <label for="role_id" class="font-semibold dark:text-gray-100 leading-none mt-4">権限（必須）</label>
                {{-- <input type="text" name="role_id" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="role_id" value="{{old('role_id')}}" placeholder=""> --}}
                <select name="role_id" class=" w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="role_id" value="{{old('role_id')}}">
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
            </div>
            @error('role_id')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col">
                <label for="employee_status_id" class="font-semibold dark:text-gray-100 leading-none mt-4">雇用状態（必須）</label>
                {{-- <input type="text" name="role_id" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="role_id" value="{{old('role_id')}}" placeholder=""> --}}
                <select name="employee_status_id" class=" w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="employee_status_id" value="{{old('employee_status_id')}}">
                    @foreach($e_statuses as $e_status)
                    <option value="{{ $e_status->id }}">{{ $e_status->employee_status_name }}</option>
                    @endforeach
                </select>
            </div>
            @error('employee_status_id')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col">
                <label class="font-semibold dark:text-gray-100 leading-none mt-4">パスワード</label>
                <input type="password" name="password" autocomplete="new-password" class="form-control w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password" value="{{old('password')}}">
            </div>
            @error('password')
            <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col">
                <label class="font-semibold dark:text-gray-100 leading-none mt-4">パスワード（確認）</label>
                <input type="password" name="password" autocomplete="new-password" class="form-control w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password" value="{{old('password')}}">
            </div>


            {{-- <div class="w-full flex flex-col">
                <label for="return_at" class="font-semibold dark:text-gray-100 leading-none mt-4">作成日（必須）</label>
                <input type="date" min="2000-01-01" max="2100-12-31" name="return_at" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="return_at" value="{{old('return_at')}}">
            </div>
            @error('return_at')
                <div class="text-red-500">{{$message}}</div>
            @enderror --}}
            
            {{-- <div class="w-full flex flex-col">
                <label for="memo" class="font-semibold dark:text-gray-100 leading-none mt-4">備考</label>
                <textarea name="memo" class="w-auto py-2 border border-gray-300 rounded-md mt-1 placeholder-gray-500" id="memo" value="{{old('memo')}}" cols="30" rows="10" placeholder="例）預託期限が来たため延長しました。"></textarea>
            </div>           
            @error('memo')
                <div class="text-red-500">{{$message}}</div>
            @enderror --}}

            {{-- <div class="w-full flex flex-col">
                <label for="image" class="font-semibold dark:text-gray-100 leading-none mt-4">画像 </label>
                <div>
                <input id="image" type="file" name="image">
                </div>
            </div> --}}

            <x-primary-button class="mt-4">
                新規登録する
            </x-primary-button>
            
        </form>
    </div>
</div>


</x-app-layout>