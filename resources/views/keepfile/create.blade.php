    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ asset('/favicon-sales.ico') }}">
    <script src="../path/to/flowbite/dist/_atpicker.js"></script>
    

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            預託情報の新規登録
        </h2>

        <div class="flex flex-row-reverse">
            <x-general-button class="mt-4" onclick="location.href='{{route('keepfile.index')}}'">
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
        <form method="post" action="{{route('keepfile.store')}}" enctype="multipart/form-data">
            @csrf
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_finished" id="is_finished" value="0">
                <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">完了</span>
            </label>

            <div class="md:flex items-center mt-8">
                <div class="w-full flex flex-col">
                <label for="project_num" class="font-semibold text-gray-100 leading-none mt-4">プロジェクト№</label>
                <input type="text" name="project_num" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="project_num" value="{{old('project_num')}}" placeholder="例）9999000100">
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="clientname" class="font-semibold text-gray-100 leading-none mt-4">客先名</label>
                <input type="text" name="clientname" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="clientname" value="{{old('clientname')}}" placeholder="例）学校法人  〇〇大学">
            </div>

            <div class="w-full flex flex-col">
                <label for="purpose" class="font-semibold text-gray-100 leading-none mt-4">用途</label>
                <input type="text" name="purpose" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="purpose" value="{{old('purpose')}}" placeholder="例）バージョンアップ">
            </div>

            <div class="w-full flex flex-col">
                <label for="keep_at" class="font-semibold text-gray-100 leading-none mt-4">預託日</label>
                <input type="date" min="2000-01-01" max="2100-12-31" name="keep_at" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="keep_at" value="{{old('keep_at')}}">
            </div>
            

            <div class="w-full flex flex-col">
                <label for="return_at" class="font-semibold text-gray-100 leading-none mt-4">返却日</label>
                <input type="date" min="2000-01-01" max="2100-12-31" name="return_at" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="return_at" value="{{old('return_at')}}">
            </div>

            
            <div class="w-full flex flex-col">
                <label for="memo" class="font-semibold text-gray-100 leading-none mt-4">備考</label>
                <textarea name="memo" class="w-auto py-2 border border-gray-300 rounded-md mt-1 placeholder-gray-500" id="memo" value="{{old('memo')}}" cols="30" rows="10" placeholder="例）預託期限が来たため延長しました。"></textarea>
            </div>           

            {{-- <div class="w-full flex flex-col">
                <label for="image" class="font-semibold text-gray-100 leading-none mt-4">画像 </label>
                <div>
                <input id="image" type="file" name="image">
                </div>
            </div> --}}

            <x-primary-button class="mt-4">
                新規登録する
            </x-primary-button>
            
        </form>
    </div>
</div>


</x-app-layout>