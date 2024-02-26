<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createCorporation') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form id="corporationForm" method="post" action="{{route('corporations.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="w-full flex flex-col">
                    <label for="corporation_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">法人正式名称</label>
                    <input type="text" name="corporation_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="corporation_name" value="{{old('corporation_name')}}" placeholder="学校法人 烏丸学園">
                </div>
                @error('corporation_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="corporation_kana_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">法人正式カナ名称</label>
                    <input type="text" name="corporation_kana_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="corporation_kana_name" value="{{old('corporation_kana_name')}}" placeholder="ガッコウホウジン カラスマガクエン">
                </div>
                @error('corporation_kana_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="corporation_short_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">法人略称</label>
                    <input type="text" name="corporation_short_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="corporation_short_name" value="{{old('corporation_short_name')}}" placeholder="烏丸学園">
                </div>
                @error('corporation_short_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                {{-- <div class="relative z-0">
                    <input type="text" id="floating_standard" autocomplete="off" class="block py-2.5 mt-4 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="floating_standard" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">法人正式名称</label>
                </div>
                <div class="relative z-0">
                    <input type="text" id="floating_standard" autocomplete="off" class="block py-2.5 mt-4 px-0 w-full text-sm  bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="floating_standard" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">法人略称</label>
                </div>
                <div class="relative z-0">
                    <input type="text" id="floating_standard" autocomplete="off" class="block py-2.5 mt-4 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="floating_standard" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">法人正式カナ名称</label>
                </div> --}}
                <div class="w-full flex flex-col">
                    <label for="credit_limit" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">与信限度額</label>
                    <input type="text" onblur="formatNumberInput(this);" name="credit_limit" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="credit_limit" value="{{old('credit_limit',0)}}" placeholder="">
                </div>
                @error('credit_limit')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">備考</label>
                    <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="memo" data-auto-resize="true"  cols="30" rows="5" placeholder="法人に関するメモ...">{{old('memo')}}</textarea>
                </div>
                @error('memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                
                <x-primary-button class="mt-4 mb-4" form-id="corporationForm" id="saveButton">
                    法人を登録
                </x-primary-button>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/main.js') }}"></script>

</x-app-layout>