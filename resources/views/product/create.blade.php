<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                製品登録
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('product.index')}}'" tabindex="-1">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">
        <form id="productForm" method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
            @csrf

            <div class="grid gap-4 mb-4 sm:grid-cols-2">

                <div class="w-full flex flex-col">
                    <label for="product_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">製品名称</label>
                    <input type="text" name="product_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="product_name" value="{{old('product_name')}}" placeholder="◯◯システム">
                </div>
                @error('product_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="product_short_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">製品略称</label>
                    <input type="text" name="product_short_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="product_short_name" value="{{old('product_short_name')}}" placeholder="">
                </div>
                @error('product_short_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="unit_price" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">標準単価</label>
                    <input type="number" name="unit_price" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="unit_price" value="{{old('unit_price')}}" placeholder="1200000">
                </div>
                @error('unit_price')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">

                <div>
                    <label for="product_maker_id" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">製品メーカー</label>
                    <select id="product_maker_id" name="product_maker_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($productMakers as $productMaker)
                        <option value="{{ $productMaker->id }}">{{ $productMaker->maker_name }}</option>
                        @endforeach
                    </select>
                    @error('product_maker_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="department_id" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">管轄事業部</label>
                    <select id="department_id" name="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->prefix_code }}：{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="product_type_id" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">製品種別</label>
                    <select id="product_type_id" name="product_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($productTypes as $productType)
                        <option value="{{ $productType->id }}">{{ $productType->type_code }}：{{ $productType->type_name }}</option>
                        @endforeach
                    </select>
                    @error('product_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                {{-- <div>
                    <label for="product_split_type_id" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">製品内訳種別</label>
                    <select id="product_split_type_id" name="product_split_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($productSplitTypes as $productSplitType)
                        <option value="{{ $productSplitType->id }}">{{ $productSplitType->split_type_code }}：{{ $productSplitType->split_type_name }}</option>
                        @endforeach
                    </select>
                    @error('product_split_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div> --}}

                {{-- Ajax通信でデータ取得 --}}
                <div class="form-group">
                    <label for="product_split_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">製品内訳種別</label>
                    <select id="product_split_type_id" name="product_split_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">選択してください</option>
                    </select>
                    @error('product_split_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="product_series_id" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">製品シリーズ</label>
                    <select id="product_series_id" name="product_series_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($productSeries as $productSeries)
                        <option value="{{ $productSeries->id }}">{{ $productSeries->series_code }}：{{ $productSeries->series_name }}</option>
                        @endforeach
                    </select>
                    @error('product_series_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="is_stop_selling" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">新規販売停止フラグ</label>
                    <select id="is_stop_selling" name="is_stop_selling" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="0">販売中</option>
                        <option value="1">新規販売停止</option>
                    </select>
                    @error('is_stop_selling')
                    <p class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="is_listed" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">一覧表示対象フラグ</label>
                    <select id="is_listed" name="is_listed" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                <label for="product_memo1" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">製品備考1</label>
                <textarea name="product_memo1" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="product_memo1" value="{{old('product_memo1')}}" cols="30" rows="5" placeholder="..."></textarea>
            </div>
            @error('product_memo1')
                <div class="text-red-500">{{$message}}</div>
            @enderror
            <div class="w-full flex flex-col">
                <label for="product_memo2" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">製品備考1</label>
                <textarea name="product_memo2" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="product_memo2" value="{{old('product_memo2')}}" cols="30" rows="5" placeholder="..."></textarea>
            </div>
            @error('product_memo2')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <x-primary-button class="mt-4 mb-4" form-id="productForm">
                製品を登録
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
</x-app-layout>