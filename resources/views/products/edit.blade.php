<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('editProduct', $product) }}
            </h2>
            <div class="ml-auto flex items-center space-x-2">
                <form method="post" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" id="editForm" class="flex items-center">
                    @csrf
                    @method('patch')
                    @can('storeUpdate_corporations')
                        <x-button-save form-id="editForm" id="saveButton" onkeydown="stopTab(event)">
                            {{ __('update') }}
                        </x-button-save>
                    @endcan
                </form>
            </div>
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
            <div class="grid gap-4 mb-4 sm:grid-cols-1 mt-4">
                <div class="w-full flex flex-col">
                    <label for="product_code" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">製品コード</label>
                    <input type="text" form="editForm" name="product_code" id="product_code" value="{{ $product->product_code }}" class="input-secondary" readonly>
                </div>

                <div class="w-full flex flex-col">
                    <label for="product_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none">製品名称<span class="text-red-500"> *</span></label>
                    <input type="text" form="editForm" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}" class="input-secondary">
                    @error('product_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>

                <div class="w-full flex flex-col">
                    <label for="product_short_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none">製品略称<span class="text-red-500"> *</span></label>
                    <input type="text" form="editForm" name="product_short_name" id="product_short_name" class="input-secondary" value="{{ old('product_short_name', $product->product_short_name) }}">
                    @error('product_short_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>

                <div class="w-full flex flex-col">
                    <label for="unit_price" class="text-sm dark:text-gray-100 text-gray-900 leading-none">標準単価<span class="text-red-500"> *</span></label>
                    <input type="text" form="editForm" onblur="formatNumberInput(this);" name="unit_price" id="unit_price" class="input-primary" value="{{ old('unit_price', floor($product->unit_price)) }}">
                    @error('unit_price')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="affiliation2_id" class="text-sm text-gray-900 dark:text-white leading-none">管轄事業部<span class="text-red-500"> *</span></label>
                    <select form="editForm" id="affiliation2_id" name="affiliation2_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($affiliation2s as $affiliation2)
                        <option value="{{ $affiliation2->id }}" @selected($affiliation2->id === (int) old('affiliation2_id', $product->affiliation2_id))>{{ $affiliation2->affiliation2_prefix }}：{{ $affiliation2->affiliation2_name }}</option>
                        @endforeach
                    </select>
                    @error('affiliation2_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="department_id_{{ $product->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        所属部門
                    </label>
                    <select form="editForm" id="department_id_{{ $product->id }}" name="department_id" class="input-primary w-full">
                        <option value="">未選択</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" @selected(old('department_id', $product->department_id) == $department->id)>
                                {{ $department->path }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid gap-4 mb-4 md:grid-cols-4 grid-cols-1 mt-8">
                    <div>
                        <label for="product_maker_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">製品メーカー<span class="text-red-500"> *</span></label>
                        <select form="editForm" id="product_maker_id" name="product_maker_id" class="input-secondary">
                            @foreach($productMakers as $productMaker)
                            <option value="{{ $productMaker->id }}" @selected($productMaker->id === (int) old('product_maker_id', $product->product_maker_id))>{{ $productMaker->maker_name }}</option>
                            @endforeach
                        </select>
                        @error('product_maker_id')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div>
                        <label for="product_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">製品種別1<span class="text-red-500"> *</span></label>
                        <select form="editForm" id="product_type_id" name="product_type_id" class="input-secondary">
                            <option selected value="">---</option>
                            @foreach($productTypes as $productType)
                            <option value="{{ $productType->id }}" @selected($productType->id === (int) old('product_type_id', $product->product_type_id))>{{ $productType->type_code }}：{{ $productType->type_name }}</option>
                            @endforeach
                        </select>
                        @error('product_type_id')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
    
                    {{-- Ajax通信でデータ取得 --}}
                    <div class="form-group">
                        <label for="product_split_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">製品種別2<span class="text-red-500"> *</span></label>
                        <select form="editForm" id="product_split_type_id" name="product_split_type_id" class="input-secondary">
                            <option value="">選択してください</option>
                            {{-- @foreach($productSplitTypes as $productSplitType)
                            <option value="{{ $productSplitType->id }}" @selected($productSplitType->id == $product->product_split_type_id)>{{ $productSplitType->split_type_code }}：{{ $productSplitType->split_type_name }}</option>
                            @endforeach --}}
                        </select>
                        @error('product_split_type_id')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="product_series_id" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">製品シリーズ<span class="text-red-500"> *</span></label>
                        <select form="editForm" id="product_series_id" name="product_series_id" class="input-secondary">
                            <option selected value="">---</option>
                            @foreach($productSeries as $productSeries)
                            <option value="{{ $productSeries->id }}" @selected($productSeries->id === (int) old('product_series_id', $product->product_series_id))>{{ $productSeries->series_code }}：{{ $productSeries->series_name }}</option>
                            @endforeach
                        </select>
                        @error('product_series_id')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 mb-4 md:grid-cols-4 grid-cols-1 mt-8">
                    <div>
                        <label for="is_stop_selling" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">新規販売停止フラグ</label>
                        <select form="editForm" id="is_stop_selling" name="is_stop_selling" class="input-secondary">
                            <option value="0" @if( "0" == $product->is_stop_selling ) selected @endif>販売中</option>
                            <option value="1" @if( "1" == $product->is_stop_selling ) selected @endif>新規販売停止</option>
                        </select>
                        @error('is_stop_selling')
                        <p class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="is_listed" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">一覧表示対象フラグ</label>
                        <select form="editForm" id="is_listed" name="is_listed" class="input-secondary">
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
                    <textarea form="editForm" name="product_memo1" class="input-secondary" id="product_memo1" value="" cols="30" rows="1">{{ old('product_memo1', $product->product_memo1) }}</textarea>
                </div>
                @error('product_memo1')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="product_memo2" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">製品備考2</label>
                    <textarea form="editForm" name="product_memo2" class="input-secondary" data-auto-resize="true" id="product_memo2" value="" cols="30" rows="5">{{ old('product_memo2', $product->product_memo2) }}</textarea>
                </div>
                @error('product_memo2')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
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
<script type="text/javascript" src="{{ asset('assets/js/autoresizetextarea.js') }}"></script>
</x-app-layout>




