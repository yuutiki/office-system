    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ asset('/favicon-sales.ico') }}">
   

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            法人情報の作成
        </h2>

        <div class="flex flex-row-reverse">
            <x-general-button class="mt-4" onclick="location.href='{{route('clientcorporate.index')}}'">
                戻る
            </x-general-button>
        </div>


        {{-- <x-input-error class="mb-4":messages="$errors->all()"/> --}}

    {{-- バリデーションエラーを画面表示する※componentsを利用しない記述 --}}
        <div>  
            @if ($errors->any())  
                <ul>  
                    @foreach ($errors->all() as $error)  
                        <li class="text-red-600">{{ $error }}</li>  
                    @endforeach  
                </ul>  
            @endif  
        </div>

        <x-message :message="session('message')"/>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">
        <form method="post" action="{{route('clientcorporate.store')}}" enctype="multipart/form-data">
            @csrf

            <div class="md:flex items-center mt-8">
                <div class="w-full flex flex-col">
                    <label for="client_corporate_id" class="font-semibold text-gray-100 leading-none mt-4">法人ID</label>
                    <input type="text" name="client_corporate_id" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="client_corporate_id" value="{{old('client_corporate_id')}}" placeholder="例）0001">
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="client_corporate_name" class="font-semibold text-gray-100 leading-none mt-4">法人名称</label>
                <input type="text" name="client_corporate_name" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="client_corporate_name" value="{{old('client_corporate_name')}}" placeholder="例）学校法人 烏丸大学">
            </div>

            <div class="w-full flex flex-col">
                <label for="client_corporate_kana" class="font-semibold text-gray-100 leading-none mt-4">法人カナ名称</label>
                <input type="text" name="client_corporate_kana" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="client_corporate_kana" value="{{old('client_corporate_kana')}}" placeholder="例）ｶﾞｯｺｳﾎｳｼﾞﾝ ｶﾗｽﾏﾀﾞｲｶﾞｸ">
            </div>
            
            <div class="w-full flex flex-col">
                <label for="memo" class="font-semibold text-gray-100 leading-none mt-4">備考</label>
                <textarea name="memo" class="w-auto py-2 border border-gray-300 rounded-md mt-1 placeholder-gray-500" id="memo" value="{{old('memo')}}" cols="30" rows="10" placeholder="例）配下の学校"></textarea>
            </div>

            <x-primary-button class="mt-4">
                新規登録する
            </x-primary-button>
            
        </form>
    </div>
</div>


</x-app-layout>