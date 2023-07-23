<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                法人編集
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('clientcorporation.index')}}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">
        <form method="post" action="{{route('clientcorporation.update',$clientcorporation)}}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="md:flex items-center mt-2">
                <div class="w-full flex flex-col">
                    <label for="clientcorporation_num" class="font-semibold dark:text-gray-100 leading-none mt-4">法人番号</label>
                    <input type="text" name="clientcorporation_num" class="w-auto py-1 bg-gray-400 cursor-not-allowed  placeholder-gray-400 border border-gray-300 rounded-sm mt-1" id="clientcorporation_num" value="{{old('clientcorporation_num',$clientcorporation->clientcorporation_num)}}" readonly>
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="clientcorporation_name" class="font-semibold dark:text-gray-100 leading-none mt-4">法人名称</label>
                <input type="text" name="clientcorporation_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-sm mt-1" id="clientcorporation_name" value="{{old('clientcorporation_name',$clientcorporation->clientcorporation_name)}}" placeholder="学校法人 烏丸学園">
            </div>
            @error('clientcorporation_name')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            
            <div class="w-full flex flex-col">
                <label for="clientcorporation_abbreviation_name" class="font-semibold dark:text-gray-100 leading-none mt-4">法人略称</label>
                <input type="text" name="clientcorporation_abbreviation_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-sm mt-1" id="clientcorporation_abbreviation_name" value="{{old('clientcorporation_abbreviation_name',$clientcorporation->clientcorporation_abbreviation_name)}}" placeholder="烏丸学園">
            </div>
            @error('clientcorporation_abbreviation_name')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col">
                <label for="clientcorporation_kana_name" class="font-semibold dark:text-gray-100 leading-none mt-4">法人カナ名称</label>
                <input type="text" name="clientcorporation_kana_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-sm mt-1" id="clientcorporation_kana_name" value="{{old('clientcorporation_kana_name',$clientcorporation->clientcorporation_kana_name)}}" placeholder="ガッコウホウジン カラスマガクエン">
            </div>
            @error('clientcorporation_kana_name')
                <div class="text-red-500">{{$message}}</div>
            @enderror
            
            <div class="w-full flex flex-col">
                <label for="memo" class="font-semibold dark:text-gray-100 leading-none mt-4">備考</label>
                <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded-sm mt-1 placeholder-gray-400" id="memo" value="{{old('memo')}}" cols="30" rows="5" placeholder="法人に関する備考..."></textarea>
            </div>
            @error('memo')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <x-primary-button class="mt-4 mb-4">
                変更を確定
            </x-primary-button>
            
        </form>
    </div>
</div>


</x-app-layout>