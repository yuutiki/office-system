<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('userProfile') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>


    <div class="py-6 md:w-auto md:ml-14 md:mr-2 m-auto">
        <div class="w-full  mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="grid gap-4 lg:grid-cols-2">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                    <div class="max-w-xl flex">

                        <!-- 画像選択用のフォーム -->
                        <div class="w-36 h-w-36 rounded">
                            <img id="image_preview" src="{{ asset('storage/'. $user->profile_image) }}?{{ time() }}" alt="プロフ画像" class="cursor-pointer w-full h-full object-cover rounded drop-shadow-xl" onclick="document.getElementById('profile_image').click()">
                            <input type="file" id="profile_image" accept="image/*" class="hidden" form="userForm" name="profile_image">
                        </div>                        

                        <!-- フォームにトリミング後の画像をセットするための非表示のinput要素 -->
                        <input type="hidden" id="cropped_profile_image" name="cropped_profile_image" form="userForm">
                        <div>
                            <form method="post" action="{{route('profile.updateImage')}}" enctype="multipart/form-data" id="userForm">
                                @csrf
                                @method('PUT')
                                <x-primary-button class="ml-4 mt-24" form-id="userForm">
                                    アカウント画像を更新
                                </x-primary-button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg items-center">
                    <h1 class="text-lg font-medium text-gray-900 dark:text-gray-100">テーマ</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 mb-3">
                        {{ __("テーマを「ダーク」もしくは「ライト」から設定できます") }}
                    </p>
                    {{-- ダークモードスイッチャー --}}
                    <div class="items-center flex">
                        <button id="theme-toggle" type="button" class="h-10 p-2.5 my-auto text-sm rounded-sm text-gray-800 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 dark:focus:ring-gray-700" tabindex="-1">
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                        </button>
                        <span id="theme-toggle-text" class="dark:text-white font-semibold ml-4 font-sans text-base"></span>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.show-belonging-department-form')
                    </div>
                </div>
            </div>



            {{-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="dark:text-white ">
                    <h2 class="font-medium mb-3">ログイン履歴</h2>
                    <ul>
                        @foreach ($loginHistories as $history)
                            <li class="">
                                <div class="flex items-center">
                                    <div>
                                        @if ($history->device === 'Windows' || $history->device === 'Macintosh')
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v5m-3 0h6M4 11h16M5 15h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1Z"/>
                                        </svg>
                                        @elseif ($history->device === 'Android' || $history->device === 'iPhone' || $history->device === 'iPad')
                                            <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-6">
                                        <span class="text-gray-400">{{ $history->logged_in_at }}</span>
                                        <br>
                                        {{ $history->device }} の {{ $history->browser }} で
                                        {{ $history->ip_address }} から
                                    </div>
                                </div>
                                <div class="border-b border-gray-400 my-3"></div>
                                {{-- <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v5m-3 0h6M4 11h16M5 15h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1Z"/>
                                  </svg> --}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

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
                const modal = document.getElementById('imageModal');
                const overlay = document.getElementById('overlay').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                modal.classList.remove('hidden');
            }
        
            // モーダルを非表示にするための関数
            function hideModal() {
                const modal = document.getElementById('imageModal');
                const overlay = document.getElementById('overlay').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                modal.classList.add('hidden');
            }
        
            // 画像選択時の処理
            document.getElementById('profile_image').addEventListener('click', function(event) {
                this.value = null; // ファイルの選択をリセット
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
                    var cropper = new Cropper(img, {
                        aspectRatio: 1 / 1,
                        viewMode: 1,
                        dragMode: 'move',
                        cropBoxResizable: false,
                        autoCropArea: 0.8,
                        movable: false,
                        crop: function(event) {
                            var canvas = cropper.getCroppedCanvas();
                            // 画像トリミング後にフォームに画像をセットする処理を有効化する
                            document.getElementById('cropped_profile_image').value = canvas.toDataURL();
                        }
                    });
                };
                reader.readAsDataURL(input.files[0]);
            });
        
            // // トリミング後の画像をフォームにセットする処理
            // function setProfileImage() {
            //     var cropper = document.getElementById('cropper_target').cropper;
            //     if (cropper) {
            //         var canvas = cropper.getCroppedCanvas();
            //         // トリミング後の画像をプレビューに表示
            //         document.getElementById('image_preview').src = canvas.toDataURL();
            //         // トリミング後の画像をフォームにセット
            //         document.getElementById('cropped_profile_image').value = canvas.toDataURL();

            //         hideModal();

            //         // フォームの送信
            //         // document.getElementById('userForm').submit();
            //     } else {
            //         console.error('トリミング対象の画像要素が見つかりません。');
            //     }
            // }





// TODO: VPSを契約するまではjpegにして圧縮する暫定対応とする。
// VPSにしたら上のコメントアウトしているシンプルなJSにする。現在は圧縮後の画像が1MB以上であればjpegで、それよりも下であれば元の拡張子のまま保持する。
            function setProfileImage() {
                var cropper = document.getElementById('cropper_target').cropper;
                if (cropper) {
                    // トリミング後のCanvasを取得
                    var canvas = cropper.getCroppedCanvas();
                    
                    // まず元のフォーマットで試す
                    canvas.toBlob(
                        function (originalBlob) {
                            const maxSize = 1 * 1024 * 1024; // 1MB
                            
                            if (originalBlob.size <= maxSize) {
                                // 1MB以下なら元のフォーマットのまま処理
                                processImage(originalBlob);
                            } else {
                                // 1MBより大きい場合はJPEGで圧縮して試す
                                canvas.toBlob(
                                    function (jpegBlob) {
                                        if (jpegBlob.size > maxSize) {
                                            alert('画像の圧縮後のサイズが1MBを超えています。より小さい画像を選択してください。');
                                            return;
                                        }
                                        processImage(jpegBlob);
                                    },
                                    'image/jpeg',
                                    0.75
                                );
                            }
                        },
                        cropper.element.type // 元の画像のMIMEタイプを使用
                    );
                } else {
                    console.error('トリミング対象の画像要素が見つかりません。');
                }
            }

            // 画像の処理を行う共通関数
            function processImage(blob) {
                console.log('処理する画像のサイズ:', blob.size / 1024, 'KB');
                console.log('画像のタイプ:', blob.type);

                // 圧縮後の画像をプレビューに表示
                var compressedImageUrl = URL.createObjectURL(blob);
                document.getElementById('image_preview').src = compressedImageUrl;

                // 画像をBase64に変換してフォームにセット
                var reader = new FileReader();
                reader.onload = function () {
                    document.getElementById('cropped_profile_image').value = reader.result;
                };
                reader.readAsDataURL(blob);

                // モーダルを閉じる
                hideModal();
            }
        </script>

        

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{-- ダークモードスイッチャー --}}
        <script src="{{ asset('/assets/js/darkmodeswitcher.js') }}"></script>
</x-app-layout>
