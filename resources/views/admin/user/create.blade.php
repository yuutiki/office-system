<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createUser') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>


    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">基本情報</button>
                </li>
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">

            <label class="relative inline-flex items-center cursor-pointer mt-2">
                <input type="hidden" form="userForm" name="is_enabled" id="is_enabled" value="0">
                <input type="checkbox" form="userForm" name="is_enabled" id="is_enabled" value="1" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
            </label>


            <div class="grid gap-4 mb-4 md:grid-cols-4 ">
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                    <label for="employee_num" class="text-sm dark:text-gray-100 leading-none mt-2">社員番号</label>
                    <input type="text" form="userForm" name="employee_num" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="employee_num" value="{{old('employee_num')}}" placeholder="例）000999">
                    </div>
                </div>
                @error('employee_num')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="employee_status_id" class="text-sm dark:text-gray-100 leading-none mt-2">雇用状態</label>
                    <select form="userForm" name="employee_status_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="employee_status_id" value="{{old('employee_status_id')}}">
                        @foreach($e_statuses as $e_status)
                        <option value="{{ $e_status->id }}">{{ $e_status->employee_status_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('employee_status_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                {{-- <div class="w-full flex flex-col">
                    <label for="role_id" class="text-sm dark:text-gray-100 leading-none mt-2">権限</label>
                    <select form="userForm" name="role_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="role_id" value="{{old('role_id')}}">
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('role_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror --}}
            </div>

            <div class="grid gap-4 mb-3 md:grid-cols-2">
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                    <label for="last_name" class="text-sm dark:text-gray-100 leading-none">姓</label>
                    <input type="text" form="userForm" last_name="last_name" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="last_name" value="{{old('last_name')}}" placeholder="">
                    </div>
                </div>
                @error('last_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                    <label for="first_name" class="text-sm dark:text-gray-100 leading-none">名</label>
                    <input type="text" form="userForm" first_name="first_name" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="first_name" value="{{old('first_name')}}" placeholder="">
                    </div>
                </div>
                @error('first_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-2">
                <div class="w-full flex flex-col">
                    <label for="last_kana_name" class="text-sm dark:text-gray-100 leading-none">カナ姓</label>
                    <input type="text" form="userForm" name="last_kana_name" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="last_kana_name" value="{{old('last_kana_name')}}" placeholder="">
                </div>
                @error('last_kana_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="first_kana_name" class="text-sm dark:text-gray-100 leading-none">カナ名</label>
                    <input type="text" form="userForm" name="first_kana_name" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="first_kana_name" value="{{old('first_kana_name')}}" placeholder="">
                </div>
                @error('first_kana_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="mt-8">
                <span class="dark:text-white">連絡先</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-3">
                <div class="w-full flex flex-col">
                    <label for="ext_phone" class="text-sm dark:text-gray-100 leading-none mt-2">外線番号</label>
                    <input type="text" form="userForm" name="ext_phone" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="ext_phone" value="{{old('ext_phone')}}" placeholder="例）999-9999-9999">
                </div>
                @error('ext_phone')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="int_phone" class="text-sm dark:text-gray-100 leading-none mt-2">内線番号</label>
                    <input type="text" form="userForm" name="int_phone" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="int_phone" value="{{old('int_phone')}}" placeholder="例）999">
                </div>
                @error('int_phone')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="email" class="text-sm dark:text-gray-100 leading-none mt-2">E-MAIL</label>
                    <input type="text" form="userForm" name="email" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="email" value="{{old('email')}}" placeholder="例）test＠gmail.com">
                </div>
                @error('email')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            
            <div class="mt-8">
                <span class="dark:text-white">所属情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-3 ">
                <div class="w-full flex flex-col">
                    <label for="affiliation1_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属1</label>
                    <select form="userForm" name="affiliation1_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="affiliation1_id" value="{{old('affiliation1_id')}}">
                        @foreach($affiliation1s as $affiliation1)
                        <option value="{{ $affiliation1->id }}">{{ $affiliation1->affiliation1_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation1_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <div class="w-full flex flex-col">
                    <label for="department_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属2</label>
                    <select form="userForm" name="department_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="department_id" value="{{old('department_id')}}">
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('department_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <div class="w-full flex flex-col">
                    <label for="affiliation3_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属3</label>
                    <select form="userForm" name="affiliation3_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="affiliation3_id" value="{{old('affiliation3_id')}}">
                        @foreach($affiliation3s as $affiliation3)
                        <option value="{{ $affiliation3->id }}">{{ $affiliation3->affiliation3_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation3_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="mt-8">
                <span class="dark:text-white">ログイン情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="w-full flex flex-col">
                <label class="text-sm dark:text-gray-100 leading-none mt-2">パスワード</label>
                <input type="password" form="userForm" name="password" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="password" value="{{old('password')}}">
            </div>
            @error('password')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col">
                <label class="text-sm dark:text-gray-100 leading-none mt-2">パスワード（確認）</label>
                <input type="password" form="userForm" name="password_confirmation" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="password" value="{{old('password')}}">
            </div>


                {{-- <div class="w-full flex flex-col">
                    <label for="image" class="text-sm dark:text-gray-100 leading-none mt-2">画像 </label>
                    <div>
                    <input id="image" type="file" name="image">
                    </div>
                </div> --}}




            <p class="dark:text-white text-red-700 leading-none text-sm mt-4 mb-1">プロフ画像</p>
            <div class="relative flex items-center justify-center w-full">
                <input type="file" form="userForm" name="profile_image" id="profile_image" class="absolute inset-0 w-full h-full opacity-0 z-10 " onchange="displayFileInfo()" />
                <label for="profile_image" class="dark:bg-gray-900flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-bray-800 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">

                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p id="file-info" class="mb-2 text-sm text-gray-500 dark:text-gray-400" >
                            クリックもしくはドラッグ＆ドロップでファイルを選択してください
                        </p>
                        <div class="md:w-auto md:ml-14" id="fileError">
                            @error('profile_image')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div> 
                    </div>

                </label>
            </div>
            
            <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data" id="userForm">
                @csrf
                <x-primary-button class="mt-4" form-id="userForm" id="saveButton" onkeydown="stopTab(event)">
                    保存(S)
                </x-primary-button>
            </form>
        </div>
    </div>










    <script>
        function displayFileInfo() {
            const fileInput = document.getElementById('profile_image');
            const fileInfo = document.getElementById('file-info');
            const ErrorMessage =   document.getElementById('fileError');

            ErrorMessage.style.display = 'none';
        
            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                const fileSize = (fileInput.files[0].size / 1024).toFixed(2); // Convert to KB with 2 decimal places
                const fileType = fileInput.files[0].type;
        
                fileInfo.innerHTML = `<span class="text-sm text-md text-blue-600">ファイル名称： ${fileName}</span></br><span class="text-sm text-md text-blue-600">ファイルサイズ： ${fileSize} KB</span></br><span class="text-sm text-md text-blue-600">ファイル形式： ${fileType}</span>`;
            }
        }
    </script>

    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/searchProject.js') }}"></script>
    <script>
        $(function() {
            $.fn.autoKana('input[name="name"]', 'input[name="kana_name"]', {katakana: true});
        });
    </script>

</x-app-layout>