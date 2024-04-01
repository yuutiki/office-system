<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('editProduct', $product) }}
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">
        <form method="post" action="{{route('products.update',$product)}}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div class="w-full flex flex-col">
                    <label for="product_code" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">製品コード</label>
                    <input type="text" name="product_code" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="product_code" value="{{old('product_code',$product->product_code)}}" placeholder="" readonly>
                </div>
                @error('product_code')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="unit_price" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">標準単価</label>
                    <input type="number" name="unit_price" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="unit_price" value="{{old('unit_price',floor($product->unit_price))}}" placeholder="1200000">
                </div>
                @error('unit_price')
                    <div class="text-red-500">{{$message}}</div>
                @enderror                   
                
                <div class="w-full flex flex-col">
                    <label for="product_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">製品名称</label>
                    <input type="text" name="product_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="product_name" value="{{old('product_name',$product->product_name)}}" placeholder="◯◯システム">
                </div>
                @error('product_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="product_short_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">製品略称</label>
                    <input type="text" name="product_short_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="product_short_name" value="{{old('product_short_name',$product->product_short_name)}}" placeholder="">
                </div>
                @error('product_short_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">

                <div>
                    <label for="product_maker_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">製品メーカー</label>
                    <select id="product_maker_id" name="product_maker_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">未選択</option>
                        @foreach($productMakers as $productMaker)
                        <option value="{{ $productMaker->id }}" @if( $productMaker->id == $product->product_maker_id ) selected @endif>{{ $productMaker->maker_name }}</option>
                        @endforeach
                    </select>
                    @error('product_maker_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="department_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">管轄事業部</label>
                    <select id="department_id" name="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">未選択</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" @if( $department->id == $product->department_id ) selected @endif>{{ $department->prefix_code }}：{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="product_type_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">製品種別</label>
                    <select id="product_type_id" name="product_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">未選択</option>
                        @foreach($productTypes as $productType)
                        <option value="{{ $productType->id }}" @if( $productType->id == $product->product_type_id ) selected @endif>{{ $productType->type_code }}：{{ $productType->type_name }}</option>
                        @endforeach
                    </select>
                    @error('product_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="product_split_type_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">製品内訳種別</label>
                    <select id="product_split_type_id" name="product_split_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">未選択</option>
                        @foreach($productSplitTypes as $productSplitType)
                        <option value="{{ $productSplitType->id }}" @if( $productSplitType->id == $product->product_split_type_id ) selected @endif>{{ $productSplitType->split_type_code }}：{{ $productSplitType->split_type_name }}</option>
                        @endforeach
                    </select>
                    @error('product_split_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="product_series_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">製品シリーズ</label>
                    <select id="product_series_id" name="product_series_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">未選択</option>
                        @foreach($productSeries as $productSeries)
                        <option value="{{ $productSeries->id }}" @if( $productSeries->id == $product->product_series_id ) selected @endif>{{ $productSeries->series_code }}：{{ $productSeries->series_name }}</option>
                        @endforeach
                    </select>
                    @error('product_series_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="is_stop_selling" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">新規販売停止フラグ</label>
                    <select id="is_stop_selling" name="is_stop_selling" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0" @if( "0" == $product->is_stop_selling ) selected @endif>販売中</option>
                        <option value="1" @if( "1" == $product->is_stop_selling ) selected @endif>新規販売停止</option>
                    </select>
                    @error('is_stop_selling')
                    <p class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="is_listed" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">一覧表示対象フラグ</label>
                    <select id="is_listed" name="is_listed" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0" @if( "0" == $product->is_listed ) selected @endif>対象外</option>
                        <option value="1" @if( "1" == $product->is_listed ) selected @endif>対象</option>
                    </select>
                    @error('is_listed')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="product_memo1" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">製品備考1</label>
                <textarea name="product_memo1" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="product_memo1" cols="30" rows="1" placeholder="...">{{old('product_memo1',$product->product_memo1)}}</textarea>
            </div>
            @error('product_memo1')
                <div class="text-red-500">{{$message}}</div>
            @enderror
            <div class="w-full flex flex-col">
                <label for="product_memo2" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">製品備考2</label>
                <textarea name="product_memo2" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="product_memo2" cols="30" rows="3" placeholder="...">{{old('product_memo2',$product->product_memo2)}}</textarea>
            </div>
            @error('product_memo2')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <x-primary-button class="mt-4 mb-4">
                変更を確定
            </x-primary-button>           
        </form>
    </div>
</div>
</x-app-layout>




