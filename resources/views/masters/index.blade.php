<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            マスタ一覧
        </h2>
        <x-message :message="session('message')" />
    </x-slot>

    <div class="grid gap-4 mb-4 sm:grid-cols-2 md:ml-16 mt-5">
        <div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
            <h2 id="accordion-color-heading-99">
                <button type="button" class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border border-b-0 bg-white dark:bg-gray-600 border-gray-200 rounded-t-xl focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-slate-50  hover:bg-blue-200 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-1" aria-expanded="false" aria-controls="accordion-color-body-1">
                    <span>都道府県マスタ</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>

            <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-99">
                <div class="p-3 border border-b-0 bg-white dark:bg-gray-600 border-gray-200 dark:border-gray-700 ">
                
                    {{-- ツールチップ --}}
                    <button data-tooltip-target="tooltip-animation" type="button" data-tooltip-placement="right" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">利用箇所</button>
                    <div id="tooltip-animation" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        住所入力箇所で共通利用
                        {{-- <div class="tooltip-arrow" data-popper-arrow></div> --}}
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        {{-- <div class="flex items-center justify-between py-4 bg-white dark:bg-gray-800">
                        </div> --}}
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-3">
                                        <div class="flex items-center">
                                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        №
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        code
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prefectures as $prefecture)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-4 p-2">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="flex items-center px-6 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center">
                                            {{ $prefecture->prefecture_code }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center">
                                            {{ $prefecture->prefecture_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <!-- Modal toggle -->
                                        <a href="#" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編集</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Edit user modal -->
                        <div id="editUserModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <form action="#" class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Edit user
                                        </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editUserModal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-6 space-y-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                                                <input type="text" name="first-name" id="first-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Bonnie" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                                                <input type="text" name="last-name" id="last-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Green" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                                <input type="email" name="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="example@company.com" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="phone-number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                                                <input type="number" name="phone-number" id="phone-number" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g. +(12)3456 789" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="department" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                                                <input type="text" name="department" id="department" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Development" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                                                <input type="number" name="company" id="company" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123456" required="">
                                            </div>
 
                                        </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="flex items-center p-6 space-x-2 border-t bg-white dark:bg-gray-600 border-gray-200 rounded-b dark:border-gray-600">
                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save all</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- アコーディオン1　Start --}}
            <h2 id="accordion-productType-head">
                <button type="button" class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border border-b-0 bg-white dark:bg-gray-600 border-gray-200 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-slate-50  hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-productType-body" aria-expanded="false" aria-controls="accordion-productType-body">
                    <span>製品種別マスタ</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-productType-body" class="hidden" aria-labelledby="accordion-productType-head">
                <div class="p-3 border border-b-0 bg-white dark:bg-gray-600 border-gray-200 dark:border-gray-700">
                    {{-- ツールチップ --}}
                    <button data-tooltip-target="tooltip-productType" type="button" data-tooltip-placement="right" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">利用箇所</button>
                    <div id="tooltip-productType" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        製品情報で利用
                        {{-- <div class="tooltip-arrow" data-popper-arrow></div> --}}
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        {{-- <div class="flex items-center justify-between py-4 bg-white dark:bg-gray-800">
                        </div> --}}
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-3">
                                        <div class="flex items-center">
                                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        №
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        code
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productTypes as $productType)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-4 p-2">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="flex items-center px-6 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center">
                                            {{ $productType->type_code }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center">
                                            {{ $productType->type_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <!-- Modal toggle -->
                                        <a href="#" type="button" data-modal-target="editProductTypeModal" data-modal-show="editProductTypeModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編集</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Edit user modal -->
                        <div id="editProductTypeModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <form action="#" class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            製品種別編集
                                        </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editProductTypeModal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-6 space-y-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">code</label>
                                                <input type="text" name="first-name" id="first-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Bonnie" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                <input type="text" name="last-name" id="last-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Green" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="department" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                                                <input type="text" name="department" id="department" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Development" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                                                <input type="text" name="company" id="company" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123456" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="flex items-center p-6 space-x-2 border-t bg-white dark:bg-gray-600 border-gray-200 rounded-b dark:border-gray-600">
                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save all</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- アコーディオン1　End --}}

            {{-- アコーディオン　Start --}}
            <h2 id="accordion-color-heading-3">
                <button type="button" class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border bg-white dark:bg-gray-600 border-gray-200 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-slate-50  hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-3" aria-expanded="false" aria-controls="accordion-color-body-3">
                    <span>製品内訳種別マスタ</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
                <div class="p-3 border border-t-0 bg-white dark:bg-gray-600 border-gray-200 dark:border-gray-700">
                    {{--  --}}
                </div>
            </div>
            {{-- アコーディオン　End --}}
            {{-- アコーディオン　Start --}}
            <h2 id="accordion-color-heading-3">
                <button type="button" class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border bg-white dark:bg-gray-600 border-gray-200 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-slate-50  hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-3" aria-expanded="false" aria-controls="accordion-color-body-3">
                    <span>所属-会社マスタ</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
                <div class="p-3 border border-t-0 bg-white dark:bg-gray-600 border-gray-200 dark:border-gray-700">
                    {{--  --}}
                </div>
            </div>
            {{-- アコーディオン　End --}}
            {{-- アコーディオン　Start --}}
            <h2 id="accordion-color-heading-3">
                <button type="button" class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border bg-white dark:bg-gray-600 border-gray-200 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-slate-50  hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-3" aria-expanded="false" aria-controls="accordion-color-body-3">
                    <span>所属-事業部マスタ</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
                <div class="p-3 border border-t-0 bg-white dark:bg-gray-600 border-gray-200 dark:border-gray-700">
                    {{--  --}}
                </div>
            </div>
            {{-- アコーディオン　End --}}
            {{-- アコーディオン　Start --}}
            <h2 id="accordion-color-heading-3">
                <button type="button" class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border bg-white dark:bg-gray-600 border-gray-200 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-slate-50  hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-3" aria-expanded="false" aria-controls="accordion-color-body-3">
                    <span>所属-部署マスタ</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
                <div class="p-3 border border-t-0 bg-white dark:bg-gray-600 border-gray-200 dark:border-gray-700">
                    {{--  --}}
                </div>
            </div>
            {{-- アコーディオン　End --}}        
        </div>











        <div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
            <h2 id="accordion-color-heading-98">
            <button type="button" class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border border-b-0 bg-white dark:bg-gray-600 border-gray-200 rounded-t-xl focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-slate-50  hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-98" aria-expanded="false" aria-controls="accordion-color-body-98">
                <span>サポート時間マスタ</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
            </button>
            </h2>
            <div id="accordion-color-body-98" class="hidden" aria-labelledby="accordion-color-heading-98">
            <div class="p-3 border border-b-0 bg-white dark:bg-gray-600 border-gray-200 dark:border-gray-700 ">
                {{--  --}}
            </div>
            </div>
            <h2 id="accordion-color-heading-2">
            <button type="button" class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border border-b-0 bg-white dark:bg-gray-600 border-gray-200 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-slate-50  hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-2" aria-expanded="false" aria-controls="accordion-color-body-2">
                <span>サポート種別マスタ</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
            </button>
            </h2>
            <div id="accordion-color-body-2" class="hidden" aria-labelledby="accordion-color-heading-2">
            <div class="p-3 border border-b-0 bg-white dark:bg-gray-600 border-gray-200 dark:border-gray-700">
                {{--  --}}
            </div>
            </div>
            <h2 id="accordion-color-heading-3">
            <button type="button" class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border bg-white dark:bg-gray-600 border-gray-200 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-slate-50  hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-3" aria-expanded="false" aria-controls="accordion-color-body-3">
                <span>取引状態マスタ</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
            </button>
            </h2>
            <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
            <div class="p-3 border border-t-0 bg-white dark:bg-gray-600 border-gray-200 dark:border-gray-700">
                {{--  --}}
            </div>
            </div>
        </div>
    </div>
</x-app-layout>