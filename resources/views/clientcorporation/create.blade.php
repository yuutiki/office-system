<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                法人登録
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
        <form method="post" action="{{route('clientcorporation.store')}}" enctype="multipart/form-data">
            @csrf

            {{-- <div class="md:flex items-center mt-8">
                <div class="w-full flex flex-col">
                    <label for="clientcorporation_num" class="font-semibold text-gray-100 leading-none mt-4">法人ID</label>
                    <input type="text" name="clientcorporation_num" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="clientcorporation_num" value="{{old('clientcorporation_num')}}" placeholder="例）0001">
                </div>
            </div> --}}

            <div class="w-full flex flex-col">
                <label for="clientcorporation_name" class="font-semibold text-gray-100 leading-none mt-4">法人名称</label>
                <input type="text" name="clientcorporation_name" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="clientcorporation_name" value="{{old('clientcorporation_name')}}" placeholder="例）学校法人 烏丸大学">
            </div>
            @error('clientcorporation_name')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col">
                <label for="clientcorporation_kana_name" class="font-semibold text-gray-100 leading-none mt-4">法人カナ名称</label>
                <input type="text" name="clientcorporation_kana_name" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="clientcorporation_kana_name" value="{{old('clientcorporation_kana_name')}}" placeholder="例）ｶﾞｯｺｳﾎｳｼﾞﾝ ｶﾗｽﾏﾀﾞｲｶﾞｸ">
            </div>
            @error('clientcorporation_kana_name')
                <div class="text-red-500">{{$message}}</div>
            @enderror
            
            <div class="w-full flex flex-col">
                <label for="memo" class="font-semibold text-gray-100 leading-none mt-4">備考</label>
                <textarea name="memo" class="w-auto py-2 border border-gray-300 rounded-md mt-1 placeholder-gray-500" id="memo" value="{{old('memo')}}" cols="30" rows="10" placeholder="例）配下の学校"></textarea>
            </div>
            @error('memo')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <x-primary-button class="mt-4">
                新規登録する
            </x-primary-button>
            
        </form>
    </div>
</div>

</x-app-layout>