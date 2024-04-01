<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('createProduct') }}
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>




    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">基本情報</button>
                </li>
                {{-- <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="credit-tab" data-tabs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="false">与信情報</button>
                </li> --}}
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">
            <form id="productForm" method="post" action="{{route('products.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4 mb-4 sm:grid-cols-2 mt-4">
                    <div class="w-full flex flex-col">
                        <label for="product_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none">製品名称<span class="text-red-500"> *</span></label>
                        <input type="text" name="product_name" class="input-secondary" id="product_name" value="{{old('product_name')}}" placeholder="◯◯システム">
                        @error('product_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="product_short_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none">製品略称<span class="text-red-500"> *</span></label>
                        <input type="text" name="product_short_name" class="input-secondary" id="product_short_name" value="{{old('product_short_name')}}" placeholder="">
                        @error('product_short_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="unit_price" class="text-sm dark:text-gray-100 text-gray-900 leading-none">標準単価<span class="text-red-500"> *</span></label>
                        <input type="text" onblur="formatNumberInput(this);" name="unit_price" class="input-primary" id="unit_price" value="{{old('unit_price')}}">
                        @error('unit_price')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="department_id" class="text-sm text-gray-900 dark:text-white leading-none">管轄事業部<span class="text-red-500"> *</span></label>
                        <select id="department_id" name="department_id" class="input-primary">
                            <option selected value="">未選択</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->prefix_code }}：{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="grid gap-4 mb-4 md:grid-cols-4 grid-cols-1 mt-8">
                    <div>
                        <label for="product_maker_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">製品メーカー<span class="text-red-500"> *</span></label>
                        <select id="product_maker_id" name="product_maker_id" class="input-primary">
                            @foreach($productMakers as $productMaker)
                            <option value="{{ $productMaker->id }}">{{ $productMaker->maker_name }}</option>
                            @endforeach
                        </select>
                        @error('product_maker_id')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="product_type_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">製品種別<span class="text-red-500"> *</span></label>
                        <select id="product_type_id" name="product_type_id" class="input-primary">
                            <option selected value="">未選択</option>
                            @foreach($productTypes as $productType)
                            <option value="{{ $productType->id }}">{{ $productType->type_code }}：{{ $productType->type_name }}</option>
                            @endforeach
                        </select>
                        @error('product_type_id')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Ajax通信でデータ取得 --}}
                    <div class="form-group">
                        <label for="product_split_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">製品内訳種別<span class="text-red-500"> *</span></label>
                        <select id="product_split_type_id" name="product_split_type_id" class="input-primary">
                            <option value="">選択してください</option>
                        </select>
                        @error('product_split_type_id')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="product_series_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">製品シリーズ<span class="text-red-500"> *</span></label>
                        <select id="product_series_id" name="product_series_id" class="input-primary">
                            <option selected value="">未選択</option>
                            @foreach($productSeries as $productSeries)
                            <option value="{{ $productSeries->id }}">{{ $productSeries->series_code }}：{{ $productSeries->series_name }}</option>
                            @endforeach
                        </select>
                        @error('product_series_id')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                    
                <div class="grid gap-4 mb-4 md:grid-cols-4 grid-cols-1 mt-8">
                    <div>
                        <label for="is_stop_selling" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">新規販売停止フラグ<span class="text-red-500"> *</span></label>
                        <select id="is_stop_selling" name="is_stop_selling" class="input-primary">
                            <option selected value="0">販売中</option>
                            <option value="1">新規販売停止</option>
                        </select>
                        @error('is_stop_selling')
                        <p class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="is_listed" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">一覧表示対象フラグ<span class="text-red-500"> *</span></label>
                        <select id="is_listed" name="is_listed" class="input-primary">
                            <option selected value="0">対象外</option>
                            <option value="1">対象</option>
                        </select>
                        @error('is_listed')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                    {{-- カラム追加と改行を表現できるようにする --}}
                <div class="w-full flex flex-col">
                    <label for="product_memo1" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">製品備考1</label>
                    <textarea name="product_memo1" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="product_memo1" value="{{old('product_memo1')}}" cols="30" rows="1"></textarea>
                </div>
                @error('product_memo1')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="product_memo2" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">製品備考2</label>
                    <textarea name="product_memo2" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="product_memo2" value="{{old('product_memo2')}}" cols="30" rows="5"></textarea>
                </div>
                @error('product_memo2')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <x-primary-button class="mt-4 mb-4" form-id="productForm" id="saveButton" onkeydown="stopTab(event)">
                    保存(S)
                </x-primary-button>        
            </form>
        </div>
    </div>



<script>
    //製品種別から製品内訳種別を引っ張るためのAJAX通信
    $(document).ready(function() {
        $('#product_type_id').on('change', function() {
            var productTypeId = $(this).val();
            if (productTypeId) {
                $.ajax({
                    type: 'GET',
                    url: '/get-split-types/' + productTypeId,
                    success: function(data) {
                        $('#product_split_type_id').empty();
                        $('#product_split_type_id').append('<option value="">選択してください</option>');
                        $.each(data, function(key, value) {
                            $('#product_split_type_id').append('<option value="' + value.id + '">' + value.split_type_code + "：" + value.split_type_name + '</option>');
                        });
                    }
                });
            } else {
                $('#product_split_type_id').empty();
                $('#product_split_type_id').append('<option value="">選択してください</option>');
            }
        });
    });
</script>

<script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
</x-app-layout>