<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
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
                <div class="md:flex items-center mt-4">
                    <div class="relative z-0">
                        <input type="text" id="clientcorporation_num" value="{{old('clientcorporation_num',$clientcorporation->clientcorporation_num)}}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                        <label for="clientcorporation_num" name="clientcorporation_num" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">法人番号</label>
                    </div>
                    {{-- <div class="w-full flex flex-col">
                        <label for="clientcorporation_num" class="font-semibold dark:text-gray-100 leading-none mt-4">法人番号</label>
                        <input type="text" name="clientcorporation_num" class="w-auto py-1 bg-gray-400 cursor-not-allowed  placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="clientcorporation_num" value="{{old('clientcorporation_num',$clientcorporation->clientcorporation_num)}}" readonly>
                    </div> --}}
                </div>
                <div class="w-full flex flex-col">
                    <label for="clientcorporation_name" class="font-semibold dark:text-gray-100 leading-none mt-4">法人正式名称</label>
                    <input type="text" name="clientcorporation_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="clientcorporation_name" value="{{old('clientcorporation_name',$clientcorporation->clientcorporation_name)}}" placeholder="学校法人 烏丸学園">
                </div>
                @error('clientcorporation_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="clientcorporation_short_name" class="font-semibold dark:text-gray-100 leading-none mt-4">法人略称</label>
                    <input type="text" name="clientcorporation_short_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="clientcorporation_short_name" value="{{old('clientcorporation_short_name',$clientcorporation->clientcorporation_short_name)}}" placeholder="烏丸学園">
                </div>
                @error('clientcorporation_short_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="clientcorporation_kana_name" class="font-semibold dark:text-gray-100 leading-none mt-4">法人正式カナ名称</label>
                    <input type="text" name="clientcorporation_kana_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="clientcorporation_kana_name" value="{{old('clientcorporation_kana_name',$clientcorporation->clientcorporation_kana_name)}}" placeholder="ガッコウホウジン カラスマガクエン">
                </div>
                @error('clientcorporation_kana_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="memo" class="font-semibold dark:text-gray-100 leading-none mt-4">備考</label>
                    <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="memo" cols="30" rows="5" placeholder="法人に関する備考...">{{old('memo',$clientcorporation->memo)}}</textarea>
                </div>
                @error('memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <x-primary-button class="mt-4 mb-4"  id="saveButton">
                    変更を確定
                </x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>