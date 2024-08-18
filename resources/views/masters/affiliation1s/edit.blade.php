<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editAffiliation1', $affiliation1) }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />

                <form method="post" action="{{ route('affiliation1.update', $affiliation1) }}" enctype="multipart/form-data" id="affiliation1Form" class="flex items-center">
                    @csrf
                    @method('PUT')
                    <x-button-save form-id="affiliation1Form" id="saveButton" onkeydown="stopTab(event)">
                        <span class="ml-1 hidden md:inline text-sm">保存</span>
                    </x-button-save>
                </form>
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

            <div class="mt-8">
                <span class="dark:text-white">所属階層情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 md:grid-cols-4 mb-4">
                <div class="w-full flex flex-col">
                    <label for="affiliation1_code" class="text-sm dark:text-gray-100 leading-none">第一所属階層コード（2桁）<span class="text-red-500"> *</span></label>
                    <input type="text" form="affiliation1Form" name="affiliation1_code" class="input-secondary" id="affiliation1_code" value="{{ old('affiliation1_code', $affiliation1->affiliation1_code) }}" placeholder="" maxlength="2">
                    @error('affiliation1_code')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="affiliation1_prefix" class="text-sm dark:text-gray-100 leading-none">第一階層所属プレフィックス（1桁）<span class="text-red-500"> *</span></label>
                    <input type="text" form="affiliation1Form" name="affiliation1_prefix" class="input-secondary" id="affiliation1_prefix" value="{{ old('affiliation1_prefix', $affiliation1->affiliation1_prefix) }}" placeholder="" maxlength="2">
                    @error('affiliation1_prefix')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-4 mb-4">
                <div class="w-full flex flex-col">
                    <label for="affiliation1_name" class="text-sm dark:text-gray-100 leading-none">第一所属階層名称<span class="text-red-500"> *</span></label>
                    <input type="text" form="affiliation1Form" name="affiliation1_name" class="input-secondary" id="affiliation1_name" value="{{ old('affiliation1_name', $affiliation1->affiliation1_name) }}" placeholder="">
                    @error('affiliation1_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="affiliation1_kana_name" class="text-sm dark:text-gray-100 leading-none">第一所属階層カナ名称</label>
                    <input type="text" form="affiliation1Form" name="affiliation1_kana_name" class="input-secondary" id="affiliation1_kana_name" value="{{ old('affiliation1_kana_name', $affiliation1->affiliation1_kana_name) }}" placeholder="">
                    @error('affiliation1_kana_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="affiliation1_eng_name" class="text-sm dark:text-gray-100 leading-none">第一所属階層英名称</label>
                    <input type="text" form="affiliation1Form" name="affiliation1_eng_name" class="input-secondary" id="affiliation1_eng_name" value="{{ old('affiliation1_eng_name', $affiliation1->affiliation1_eng_name) }}" placeholder="">
                    @error('affiliation1_eng_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="affiliation1_name_short" class="text-sm dark:text-gray-100 leading-none">第一階層所属略称</label>
                    <input type="text" form="affiliation1Form" name="affiliation1_name_short" class="input-secondary" id="affiliation1_name_short" value="{{ old('affiliation1_name_short', $affiliation1->affiliation1_name_short) }}" placeholder="">
                    @error('affiliation1_name_short')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>



            <div class="mt-8">
                <span class="dark:text-white">基本情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="w-full flex flex-col">
                    <label for="corporation_number" class="text-sm dark:text-gray-100 leading-none">法人番号（国税庁）<span class="text-red-500"> *</span></label>
                    <input type="text" form="affiliation1Form" name="corporation_number" class="input-primary" id="corporation_number" value="{{old('corporation_number', $affiliation1->corporation_number)}}" placeholder="999999999999" maxlength="13">
                    @error('corporation_number')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="stock_code" class="text-sm dark:text-gray-100 leading-none">証券（株式銘柄）コード<span class="text-red-500"> *</span></label>
                    <input type="text" form="affiliation1Form" name="stock_code" class="input-primary" id="stock_code" value="{{old('stock_code', $affiliation1->stock_code)}}" placeholder="9999" maxlength="4">
                    @error('stock_code')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>

            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <div class="flex">
                        <div class="w-full flex flex-col">
                            <label for="invoice_num" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">インボイス番号</label>
                            <input type="text" form="affiliation1Form" name="invoice_num" id="invoice_num" value="{{ old('invoice_num', $affiliation1->invoice_num) }}" class="input-primary" placeholder="T123456789123" maxlength="14">
                        </div>

                        {{-- APIRequest用のボタン --}}
                        <button type="button" id="invoiceApi" class="p-2.5 text-sm font-medium h-[34px] text-white mt-[34px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                    @error('invoice_num')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="invoice_at" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">インボイス登録日</label>
                        <input type="date" min="1900-01-01" max="2200-12-31" form="affiliation1Form" name="invoice_at" id="invoice_at" value="{{ old('invoice_at', $affiliation1->invoice_at) }}" class="input-primary">
                    </div>
                    @error('invoice_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>



            <div class="grid gap-4 mb-3 md:grid-cols-2 mt-4">
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                        <label for="company_president_position_name" class="text-sm dark:text-gray-100 leading-none">代表者役職<span class="text-red-500"> *</span></label>
                        <input type="text" form="affiliation1Form" name="company_president_position_name" class="input-secondary" id="company_president_position_name" value="{{ old('company_president_position_name', $affiliation1->company_president_position_name) }}" placeholder="">
                        @error('company_president_position_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                        <label for="company_president_id" class="text-sm dark:text-gray-100 leading-none">代表者<span class="text-red-500"> *</span></label>
                        <select name="company_president_id"form="affiliation1Form"  id="company_president_id" class="input-secondary">
                            <option value="">未選択</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected($user->id ==  old('company_president_id', $affiliation1->company_president_id) )>{{ $user->user_name }}</option>    
                            @endforeach
                        </select>
                        @error('company_president_id')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <span class="dark:text-white">本社所在地</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 mb-4 sm:grid-cols-5">
                <div class="flex">
                    <div class="w-full flex flex-col">
                        <label for="affiliation1_post_code" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1" autocomplete="new-password">郵便番号</label>
                        <input type="text" form="affiliation1Form" name="affiliation1_post_code" class="input-primary" id="affiliation1_post_code" value="{{ old('affiliation1_post_code', $affiliation1->affiliation1_post_code) }}" placeholder="">
                    </div>
                    <button type="button" id="ajaxzip3" data-form="affiliation1Form" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[21px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>

                <div class="w-full flex flex-col">
                    <label for="affiliation1_prefecture_id" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1">都道府県</label>
                    <select id="affiliation1_prefecture_id" form="affiliation1Form" name="affiliation1_prefecture_id" class="input-primary">
                        <option selected value="">未選択</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}" @if( $prefecture->id == old('affiliation1_prefecture_id', $affiliation1->affiliation1_prefecture_id) ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full flex flex-col sm:col-span-3">
                    <label for="affiliation1_address1" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1">所在地</label>
                    <input type="text" form="affiliation1Form" name="affiliation1_address1" id="affiliation1_address1" value="{{ old('affiliation1_address1', $affiliation1->affiliation1_address1) }}" class="input-primary" placeholder="">
                </div>
            </div>

            <div class="mt-8">
                <span class="dark:text-white">連絡先</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-2">
                <div class="w-full flex flex-col">
                    <label for="company_TEL" class="text-sm dark:text-gray-100 leading-none mt-2">代表TEL番号</label>
                    <input type="text" form="affiliation1Form" name="company_TEL"  onchange="validateAndFormat('company_TEL')" class="input-secondary" id="company_TEL" value="{{ old('company_TEL', $affiliation1->company_TEL) }}" placeholder="999-9999-9999">
                    @error('company_TEL')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="company_FAX" class="text-sm dark:text-gray-100 leading-none mt-2">代表FAX番号</label>
                    <input type="text" form="affiliation1Form" name="company_FAX"  onchange="validateAndFormat('company_FAX')" class="input-secondary" id="company_FAX" value="{{ old('company_FAX', $affiliation1->company_FAX) }}" placeholder="999-9999-9999">
                    @error('company_FAX')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-8">
                <span class="dark:text-white">会社ロゴ・印鑑</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

           <div class="flex">
                <!-- 印鑑画像選択用のフォーム -->
                <div>
                    <div class="mb-8 w-20 h-20">
                        <img id="company_stamp_preview" src="{{ asset('storage/' . $affiliation1->company_stamp_image) }}?{{ time() }}" alt="会社印鑑" class="cursor-pointer w-full h-full object-contain rounded" onclick="document.getElementById('company_stamp_image').click()">
                        <input type="file" id="company_stamp_image" accept="image/*" class="hidden" form="affiliation1Form" name="company_stamp_image">
                    </div>
                    <!-- フォームにトリミング後の画像をセットするための非表示のinput要素 -->
                    <input type="hidden" id="cropped_company_stamp" name="cropped_company_stamp" form="affiliation1Form">
                </div>
    
                <!-- ロゴ画像選択用のフォーム -->
                <div class="ml-8">
                    <div class="mb-8 w-[165px] h-[44px] relative">
                        <img id="company_logo_preview" 
                             src="{{ asset('storage/' . $affiliation1->company_logo_image) }}?{{ time() }}" 
                             alt="会社ロゴ" 
                             class="cursor-pointer w-full h-full object-contain rounded absolute top-0 left-0"
                             onclick="document.getElementById('company_logo_image').click()">
                        <input type="file" id="company_logo_image" accept="image/*" class="hidden" form="affiliation1Form" name="company_logo_image">
                    </div>
                    <!-- フォームにトリミング後の画像をセットするための非表示のinput要素 -->
                    <input type="hidden" id="cropped_company_logo" name="cropped_company_logo" form="affiliation1Form">
                </div>
           </div>


        </div>
    </div>

<!-- 印鑑画像トリミング Modal -->
<div id="companyStampModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
    <div class="max-h-full w-full max-w-2xl">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    会社印鑑編集
                </h3>
                <button type="button" onclick="hideCompanyStampModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div id="company_stamp_cropper_container"></div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="button" onclick="setCompanyStamp()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    完了
                </button>
                <button type="button" onclick="hideCompanyStampModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    キャンセル
                </button> 
            </div>
        </div>
    </div>
</div>

    <!-- ロゴ画像トリミング Modal -->
<div id="companyLogoModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
    <div class="max-h-full w-full max-w-2xl">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    会社ロゴ編集
                </h3>
                <button type="button" onclick="hideCompanyLogoModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div id="company_logo_cropper_container"></div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="button" onclick="setCompanyLogo()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    完了
                </button>
                <button type="button" onclick="hideCompanyLogoModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    キャンセル
                </button> 
            </div>
        </div>
    </div>
</div>


<script>
    // モーダルを表示するための関数
    function showCompanyStampModal() {
        const modal = document.getElementById('companyStampModal');
        const overlay = document.getElementById('overlay');
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        modal.classList.remove('hidden');
    }

    // モーダルを非表示にするための関数
    function hideCompanyStampModal() {
        const modal = document.getElementById('companyStampModal');
        const overlay = document.getElementById('overlay');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        modal.classList.add('hidden');
    }

    // 画像選択時の処理
    document.getElementById('company_stamp_image').addEventListener('click', function(event) {
        this.value = null; // ファイルの選択をリセットする
    });

    document.getElementById('company_stamp_image').addEventListener('change', function(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var img = document.createElement('img');
            img.src = reader.result;
            img.id = 'company_stamp_cropper_target';
            document.getElementById('company_stamp_cropper_container').innerHTML = '';
            document.getElementById('company_stamp_cropper_container').appendChild(img);
            showCompanyStampModal();
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
                    // 画像トリミング後にフォームに画像をセットする処理を有効化する
                    document.getElementById('company_stamp_preview').src = canvas.toDataURL();
                }
            });
        };
        reader.readAsDataURL(input.files[0]);
    });

    // トリミング後の画像をフォームにセットする処理
    function setCompanyStamp() {
        if (document.getElementById('company_stamp_cropper_target')) {
            var canvas = document.getElementById('company_stamp_cropper_target').cropper.getCroppedCanvas();
            var dataURL = canvas.toDataURL();
            document.getElementById('company_stamp_preview').src = dataURL;
            document.getElementById('cropped_company_stamp').value = dataURL;
            hideCompanyStampModal();
        } else {
            console.error('トリミング対象の画像要素が見つかりません。');
        }
    }
</script>

<script>
    // モーダルを表示するための関数
    function showCompanyLogoModal() {
        const modal = document.getElementById('companyLogoModal');
        const overlay = document.getElementById('overlay');
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        modal.classList.remove('hidden');
    }

    // モーダルを非表示にするための関数
    function hideCompanyLogoModal() {
        const modal = document.getElementById('companyLogoModal');
        const overlay = document.getElementById('overlay');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        modal.classList.add('hidden');
    }

    // 画像選択時の処理
    document.getElementById('company_logo_image').addEventListener('click', function(event) {
        this.value = null; // ファイルの選択をリセット
    });

    document.getElementById('company_logo_image').addEventListener('change', function(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var img = document.createElement('img');
            img.src = reader.result;
            img.id = 'company_logo_cropper_target';
            document.getElementById('company_logo_cropper_container').innerHTML = '';
            document.getElementById('company_logo_cropper_container').appendChild(img);
            showCompanyLogoModal();
            // Cropper.jsの初期化
            var cropper = new Cropper(img, {
                aspectRatio: 170 / 44,
                viewMode: 1,
                dragMode: 'move',
                cropBoxResizable: false,
                autoCropArea: 0.8,
                movable: true,
                minCropBoxWidth: 160,
                minCropBoxHeight: 44,
                crop: function(event) {
                    // トリミングされた画像の情報を取得
                    var canvas = cropper.getCroppedCanvas();
                    // トリミング後の画像をプレビューに表示
                    document.getElementById('company_logo_preview').src = canvas.toDataURL();
                }
            });
        };
        reader.readAsDataURL(input.files[0]);
    });

    // トリミング後の画像をフォームにセットする処理を更新
    function setCompanyLogo() {
        if (document.getElementById('company_logo_cropper_target')) {
            var canvas = document.getElementById('company_logo_cropper_target').cropper.getCroppedCanvas();
            var dataURL = canvas.toDataURL();

            document.getElementById('company_logo_preview').src = dataURL;
            document.getElementById('cropped_company_logo').value = dataURL;
            hideCompanyLogoModal();
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/js/addresssearchbutton.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>

</x-app-layout>