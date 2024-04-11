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



            <div class="mb-8 w-20 h-20">
                <!-- プロフィール画像を表示するimg要素 -->
                {{-- <img id="image_preview" src="{{ asset('storage/users/profile_image/default.png') }}" alt="プロフ画像" class="cursor-pointer w-20 h-auto rounded"> --}}
                <img id="image_preview" src="{{ asset('storage/users/profile_image/default.png') }}" alt="プロフ画像" class="cursor-pointer w-full h-full object-cover rounded">
                <!-- input要素を隠し、プロフィール画像をクリックしたときに実行されるようにします -->
                <input type="file" id="profile_image" accept="image/*" class="hidden" form="userForm" name="profile_image">
            </div>


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

                <label class="relative inline-flex items-center cursor-pointer mt-9">
                    <input type="hidden" form="userForm" name="is_enabled" value="0">
                    <input type="checkbox" form="userForm" name="is_enabled" value="1" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
                </label>
            </div>

            <div class="grid gap-4 mb-3 md:grid-cols-2">
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                    <label for="user_name" class="text-sm dark:text-gray-100 leading-none">氏名</label>
                    <input type="text" form="userForm" name="user_name" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="user_name" value="{{old('user_name')}}" placeholder="">
                    </div>
                </div>
                @error('user_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                    <label for="user_kana_name" class="text-sm dark:text-gray-100 leading-none">カナ氏名</label>
                    <input type="text" form="userForm" name="user_kana_name" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="user_kana_name" value="{{old('user_kana_name')}}" placeholder="">
                    </div>
                </div>
                @error('user_kana_name')
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
                    <input type="text" form="userForm" name="ext_phone" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="ext_phone" value="{{old('ext_phone')}}" placeholder="999-9999-9999">
                </div>
                @error('ext_phone')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="int_phone" class="text-sm dark:text-gray-100 leading-none mt-2">内線番号</label>
                    <input type="text" form="userForm" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="int_phone" value="{{old('int_phone')}}" placeholder="999" maxlength="{{ $maxlength }}">
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

            <div class="w-full flex flex-col mt-4">
                <label class="text-sm dark:text-gray-100 leading-none mt-2">パスワード（確認）</label>
                <input type="password" form="userForm" name="password_confirmation" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="password_confirmation" value="{{old('password_confirmation')}}">
            </div>
            @error('password_confirmation')
                <div class="text-red-500">{{$message}}</div>
            @enderror






            {{-- <p class="dark:text-white text-red-700 leading-none text-sm mt-4 mb-1">プロフ画像</p>
            <div class="relative flex items-center justify-center w-auto">
                <input type="file" form="userForm" name="profile_image" accept="image/*" id="profile_image" class="absolute inset-0 w-full h-full opacity-0 z-10 " onchange="displayFileInfo()" />
                <label for="profile_image" class="dark:bg-gray-900flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-bray-800 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">

                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <img class="w-20 h-20 rounded"  id="image_preview"  alt="プロフィール画像">
                    </div>
                </label>
            </div>
            <div class="md:w-auto md:ml-14" id="fileError">
                @error('profile_image')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>  --}}


            
            <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data" id="userForm">
                @csrf
                <x-primary-button class="mt-4" form-id="userForm" id="saveButton" onkeydown="stopTab(event)">
                    保存(S)
                </x-primary-button>
            </form>
        </div>
    </div>






    <script>
        // プロフィール画像をクリックしたときにファイル選択画面を開く処理
        document.getElementById('image_preview').addEventListener('click', () => {
            document.getElementById('profile_image').click();
        });
    
        // ファイルが選択されたときの処理
        document.getElementById('profile_image').addEventListener('change', (e) => {
            const file = e.target.files[0];
            // ファイルの処理を行う（アップロードやその他の処理）
        });
    </script>
    <script>
        // アイコン画像プレビュー処理
        // 画像が選択される度に、この中の処理が走る
        $('#profile_image').on('change', function (ev) {
            // このFileReaderが画像を読み込む上で大切
            const reader = new FileReader();
            // ファイル名を取得
            const fileName = ev.target.files[0].name;
            // 画像が読み込まれた時の動作を記述
            reader.onload = function (ev) {
                $('#image_preview').attr('src', ev.target.result);
            }
            console.log('aaa');
            reader.readAsDataURL(this.files[0]);
        })
    </script>


    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/searchProject.js') }}"></script>
    <script>
        $(function() {
            $.fn.autoKana('input[name="name"]', 'input[name="kana_name"]', {katakana: true});
        });
    </script>





<script type="text/javascript" src="//code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



</x-app-layout>