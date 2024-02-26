<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
            {{ Breadcrumbs::render('editCorporation', $corporation) }}
        </h2>
        <div class="flex justify-end">
            <x-message :message="session('message')"/>
        </div>
        <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                {{-- <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                </li> --}}
                <li>
                    <button type="button" data-modal-target="deleteModal-{{$corporation->id}}" data-modal-show="deleteModal-{{$corporation->id}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full dark:text-red-500">
                        <div class="flex">
                            <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            <span class="">削除</span>
                        </div>
                    </button>
                </li>
            </ul>
            {{-- <div class="py-2">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Separated link</a>
            </div> --}}
        </div>
    </div>
</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form method="post" action="{{route('corporations.update',$corporation)}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="md:flex items-center mt-4">
                    <div class="relative z-0">
                        <input type="text" id="corporation_num" value="{{old('corporation_num',$corporation->corporation_num)}}" class="block text-lg px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                        <label for="corporation_num" name="corporation_num" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">法人番号</label>
                    </div>
                    {{-- <div class="w-full flex flex-col">
                        <label for="corporation_num" class="font-semibold dark:text-gray-100 leading-none mt-4">法人番号</label>
                        <input type="text" name="corporation_num" class="w-auto py-1 bg-gray-400 cursor-not-allowed  placeholder-gray-400 border border-gray-300 rounded mt-1" id="corporation_num" value="{{old('corporation_num',$corporation->corporation_num)}}" readonly>
                    </div> --}}
                </div>
                <div class="w-full flex flex-col">
                    <label for="corporation_name" class="font-semibold dark:text-gray-100 leading-none mt-4">法人正式名称</label>
                    <input type="text" name="corporation_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="corporation_name" value="{{old('corporation_name',$corporation->corporation_name)}}" placeholder="学校法人 烏丸学園">
                </div>
                @error('corporation_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="corporation_kana_name" class="font-semibold dark:text-gray-100 leading-none mt-4">法人正式カナ名称</label>
                    <input type="text" name="corporation_kana_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="corporation_kana_name" value="{{old('corporation_kana_name',$corporation->corporation_kana_name)}}" placeholder="ガッコウホウジン カラスマガクエン">
                </div>
                @error('corporation_kana_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="corporation_short_name" class="font-semibold dark:text-gray-100 leading-none mt-4">法人略称</label>
                    <input type="text" name="corporation_short_name" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="corporation_short_name" value="{{old('corporation_short_name',$corporation->corporation_short_name)}}" placeholder="烏丸学園">
                </div>
                @error('corporation_short_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="credit_limit" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">与信限度額</label>
                    <input type="text" onblur="formatNumberInput(this);" name="credit_limit" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="credit_limit" value="{{old('credit_limit',number_format($corporation->credit_limit))}}" placeholder="">
                </div>
                @error('credit_limit')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="memo" class="font-semibold dark:text-gray-100 leading-none mt-4">備考</label>
                    <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="memo" data-auto-resize="true" cols="30" rows="5" placeholder="法人に関する備考...">{{old('memo',$corporation->memo)}}</textarea>
                </div>
                @error('memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <x-primary-button class="mt-4 mb-4" id="saveButton">
                    変更を確定
                </x-primary-button>
            </form>

        </div>

        <div id="deleteModal-{{$corporation->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded shadow dark:bg-gray-700">
                    <button data-modal-hide="deleteModal-{{$corporation->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                        <div class="flex justify-center">
                            <form action="{{route('corporations.destroy',$corporation->id)}}" method="POST" class="">
                                @csrf
                                @method('delete')
                                <button type="submit" data-modal-hide="deleteModal-{{$corporation->id}}" class="text-white  bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                    削除
                                </button>
                            </form>
                            <button data-modal-hide="deleteModal-{{$corporation->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                やっぱやめます
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

</x-app-layout>