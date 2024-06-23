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

            <!-- 画像選択用のフォーム -->
            <div class="mb-8 w-20 h-20">
                <img id="image_preview" src="{{ asset('storage/users/profile_image/default.png') }}" alt="プロフ画像" class="cursor-pointer w-full h-full object-cover rounded" onclick="document.getElementById('profile_image').click()">
                <input type="file" id="profile_image" accept="image/*" class="hidden" form="userForm" name="profile_image">
            </div>

            <!-- フォームにトリミング後の画像をセットするための非表示のinput要素 -->
            <input type="hidden" id="cropped_profile_image" name="cropped_profile_image" form="userForm">

            <!-- トリミング後の画像を表示する要素 -->
            {{-- <img id="cropped_profile_image_preview" src="#" alt="トリミング後の画像" style="display: none;"> --}}

            <label class="relative inline-flex items-center cursor-pointer mb-9">
                <input type="hidden" form="userForm" name="is_enabled" value="0">
                <input type="checkbox" form="userForm" name="is_enabled" value="1" checked class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
            </label>

            <div class="grid gap-4 md:grid-cols-4 mb-4">
                <div class="w-full flex flex-col">
                    <label for="user_num" class="text-sm dark:text-gray-100 leading-none">社員番号<span class="text-red-500"> *</span></label>
                    <input type="text" form="userForm" name="user_num" class="input-primary" id="user_num" value="{{old('user_num')}}" placeholder="999999" maxlength="6">
                    @error('user_num')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="employee_status_id" class="text-sm dark:text-gray-100 leading-none">雇用状態<span class="text-red-500"> *</span></label>
                    <select form="userForm" name="employee_status_id" class=" input-primary" id="employee_status_id" value="{{old('employee_status_id')}}">
                        @foreach($e_statuses as $e_status)
                        <option value="{{ $e_status->id }}">{{ $e_status->employee_status_name }}</option>
                        @endforeach
                    </select>
                    @error('employee_status_id')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="_at" class="text-sm dark:text-gray-100 leading-none">入職年月日</label>
                    <input type="date" min="1900-01-01" max="2200-12-31" form="userForm" name="_at" class="input-primary" id="_at" value="{{old('_at', now()->format('Y-m-d'))}}" placeholder="">
                    @error('_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="birth" class="text-sm dark:text-gray-100 leading-none">生年月日<span class="text-red-500"> *</span></label>
                    <input type="date" min="1900-01-01" max="2200-12-31" form="userForm" name="birth" class="input-primary" id="birth" value="{{old('birth')}}" placeholder="">
                    @error('birth')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 mb-3 md:grid-cols-2">
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                        <label for="user_name" class="text-sm dark:text-gray-100 leading-none">氏名<span class="text-red-500"> *</span></label>
                        <input type="text" form="userForm" name="user_name" class="input-secondary" id="user_name" value="{{old('user_name')}}" placeholder="">
                        @error('user_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                    <label for="user_kana_name" class="text-sm dark:text-gray-100 leading-none">カナ氏名<span class="text-red-500"> *</span></label>
                    <input type="text" form="userForm" name="user_kana_name" class="input-secondary" id="user_kana_name" value="{{old('user_kana_name')}}" placeholder="">
                    @error('user_kana_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <span class="dark:text-white">連絡先</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-3">
                <div class="w-full flex flex-col">
                    <label for="ext_phone" class="text-sm dark:text-gray-100 leading-none mt-2">外線番号<span class="text-red-500"> *</span></label>
                    <input type="text" form="userForm" name="ext_phone"  onchange="validateAndFormat('ext_phone')" class="input-secondary" id="ext_phone" value="{{old('ext_phone')}}" placeholder="999-9999-9999">
                    @error('ext_phone')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="int_phone" class="text-sm dark:text-gray-100 leading-none mt-2">内線番号</label>
                    <input type="text" form="userForm" name="int_phone" class="input-secondary" id="int_phone" value="{{old('int_phone')}}" placeholder="999" maxlength="{{ $maxlength }}">
                    @error('int_phone')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="email" class="text-sm dark:text-gray-100 leading-none mt-2">E-MAIL<span class="text-red-500"> *</span></label>
                    <input type="text" form="userForm" name="email" class="input-secondary" id="email" value="{{old('email')}}" placeholder="test＠gmail.com">
                    @error('email')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mt-8">
                <span class="dark:text-white">所属情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-3 ">
                <div class="w-full flex flex-col">
                    <label for="affiliation1_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属1</label>
                    <select form="userForm" name="affiliation1_id" class="input-secondary" id="affiliation1_id" value="{{old('affiliation1_id')}}">
                        @foreach($affiliation1s as $affiliation1)
                        <option value="{{ $affiliation1->id }}">{{ $affiliation1->affiliation1_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation1_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <div class="w-full flex flex-col">
                    <label for="affiliation2_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属2</label>
                    <select form="userForm" name="affiliation2_id" class="input-secondary" id="affiliation2_id" value="{{old('affiliation2_id')}}">
                        @foreach($affiliation2s as $affiliation2)
                        <option value="{{ $affiliation2->id }}">{{ $affiliation2->affiliation2_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation2_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <div class="w-full flex flex-col">
                    <label for="affiliation3_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属3</label>
                    <select form="userForm" name="affiliation3_id" class="input-secondary" id="affiliation3_id" value="{{old('affiliation3_id')}}">
                        @foreach($affiliation3s as $affiliation3)
                        <option value="{{ $affiliation3->id }}">{{ $affiliation3->affiliation3_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation3_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="affiliation4_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属4</label>
                    <select form="userForm" name="affiliation4_id" class="input-secondary" id="affiliation4_id" value="{{old('affiliation4_id')}}">
                        @foreach($affiliation3s as $affiliation3)
                        <option value="{{ $affiliation3->id }}">{{ $affiliation3->affiliation3_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation4_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="affiliation5_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属5</label>
                    <select form="userForm" name="affiliation5_id" class="input-secondary" id="affiliation5_id" value="{{old('affiliation5_id')}}">
                        @foreach($affiliation3s as $affiliation3)
                        <option value="{{ $affiliation3->id }}">{{ $affiliation3->affiliation3_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation5_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="mt-8">
                <span class="dark:text-white">ログイン情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            {{-- <div class="w-full flex flex-col">
                <label class="text-sm dark:text-gray-100 leading-none mt-2">パスワード</label>
                <input type="password" form="userForm" name="password" autocomplete="new-password" class="input-primary" id="password" value="{{old('password')}}">
            </div>
            @error('password')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col mt-4">
                <label class="text-sm dark:text-gray-100 leading-none mt-2">パスワード（確認）</label>
                <input type="password" form="userForm" name="password_confirmation" autocomplete="new-password" class="input-primary" id="password_confirmation" value="{{old('password_confirmation')}}">
            </div>
            @error('password_confirmation')
                <div class="text-red-500">{{$message}}</div>
            @enderror --}}

            <div class="text-white">
                ※初期パスワードは自動で設定されメール送信されます。
                <br>
                「生年月日8桁＋A%＋外線番号下4桁」
            </div>

            <label class="relative inline-flex items-center cursor-pointer my-9">
                <input type="hidden" form="userForm" name="password_change_required" value="0">
                <input type="checkbox" form="userForm" name="password_change_required" value="1" checked class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">次回ログイン時パスワード変更</span>
            </label>

            <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data" id="userForm">
                @csrf
                <x-primary-button class="mt-4" form-id="userForm" id="saveButton" onkeydown="stopTab(event)">
                    保存(S)
                </x-primary-button>
            </form>
        </div>
    </div>

    <!-- 画像トリミング Modal -->
    <div id="imageModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        {{-- <div id="imageModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
            <div class="max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                            アイコン編集
                        </h3>
                        <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div id="cropper_container"></div>

                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="button" onclick="setProfileImage()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            完了
                        </button>
                        <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            キャンセル
                        </button> 
                    </div>
                </div>
            </div>
        </div>


    <script>
        // モーダルを表示するための関数
        function showModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('imageModal');
            //背後の操作不可を有効
            const overlay = document.getElementById('overlay').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
        }

        // モーダルを非表示にするための関数
        function hideModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('imageModal');
            //背後の操作不可を解除
            const overlay = document.getElementById('overlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // モーダルを非表示にするためのクラスを削除
            modal.classList.add('hidden');
        }

        // 画像選択時の処理
        document.getElementById('profile_image').addEventListener('click', function(event) {
            // ファイル選択用のinput要素をクリックする
            this.value = null; // ファイルの選択をリセットする（同じファイルを選択した場合もイベントが発火するようにするため）
        });
        document.getElementById('profile_image').addEventListener('change', function(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var img = document.createElement('img');
                img.src = reader.result;
                img.id = 'cropper_target';
                document.getElementById('cropper_container').innerHTML = '';
                document.getElementById('cropper_container').appendChild(img);
                showModal();
                // Cropper.jsの初期化
                var cropper = new Cropper(img, {
                    aspectRatio: 1 / 1,
                    viewMode: 1,
                    dragMode: 'move',
                    cropBoxResizable: false,
                    autoCropArea: 0.8,
                    movable: false,
                    crop: function(event) {
                        // トリミングされた画像の情報を取得
                        var canvas = cropper.getCroppedCanvas();
                        // トリミング後の画像をプレビューに表示
                        document.getElementById('image_preview').src = canvas.toDataURL();
                    }
                });
            };
            reader.readAsDataURL(input.files[0]);
        });
    
        // トリミング後の画像をフォームにセットする処理
        function setProfileImage() {
            // トリミング対象の画像要素が存在するか確認
            if (document.getElementById('cropper_target')) {
                var canvas = document.getElementById('cropper_target').cropper.getCroppedCanvas();
                var dataURL = canvas.toDataURL();
                document.getElementById('image_preview').src = dataURL;
                // トリミング後の画像をフォームにセット
                document.getElementById('cropped_profile_image').value = dataURL;
                // モーダルを非表示にする処理を追加する
                hideModal();
            } else {
                console.error('トリミング対象の画像要素が見つかりません。');
            }
        }
    </script>

<script>
    // バリデーション関数
    var validateTelNeo = function (value) {
        return /^[0０]/.test(value) && libphonenumber.isValidNumber(value, 'JP');
    }

    // 整形関数
    var formatTel = function (value) {
        return new libphonenumber.AsYouType('JP').input(value);
    }

    var validateAndFormat = function (inputId) {
        var phoneInput = document.getElementById(inputId);
        if (!phoneInput) {
            console.error('ERROR: Phone input element not found!');
            return;
        }
        var tel = phoneInput.value.trim().replace(/[０-９]/g, function(char) {
            // 全角数字を半角に変換
            return String.fromCharCode(char.charCodeAt(0) - 65248);
        }).replace(/\D/g, ''); // 数字以外の文字を削除
        
        if (!validateTelNeo(tel)) {
            console.error('ERROR: Invalid phone number!');
            return;
        }
        var formattedTel = formatTel(tel);
        console.log('Formatted Phone Number:', formattedTel);
        
        // 入力フィールドに整形された電話番号を表示
        phoneInput.value = formattedTel;
        
        // 以降 formattedTel を使って登録処理など進める
    }
</script>

    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</x-app-layout>