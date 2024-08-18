<x-app-layout>
     <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('prefectureMaster') }}
                <div class="ml-4">
                    {{-- {{ $count }}件 --}}
                </div>
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md  dark:text-gray-900 mt-4">
        <div class="w-full">
            <div class="relative bg-white dark:bg-gray-800">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="コード / 名称 / 英名称">
                            </div>
                        </form>
                    </div>
                    <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                        <button type="button" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add
                        </button>
                        <div class="flex items-center w-full space-x-3 md:w-auto">
                            {{-- <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                                Actions
                            </button>
                            <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass Edit</a>
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete all</a>
                                </div>
                            </div> --}}
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                    Filter
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown menu -->
                        <div id="filterDropdown" class="z-10 hidden w-48 p-3 bg-white rounded shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                Category
                            </h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                <li class="flex items-center">
                                    <input id="apple" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                    <label for="apple" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        Apple (56)
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="md:w-auto md:ml-14 md:mr-2 mb-4 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="pl-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            コード
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            名称
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            見積住所1
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            見積住所2
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            見積住所3
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            TEL
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            FAX
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            Mail
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            会社URL
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            最終更新者
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            更新日時
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estimateAddresses as $estimateAddress)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white dark:hover:bg-gray-600">
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ $estimateAddress->estimate_address_code }}
                        </td>
                        <td class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $estimateAddress->estimate_address_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $estimateAddress->estimate_address_1 }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $estimateAddress->estimate_address_2 }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $estimateAddress->estimate_address_3 }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $estimateAddress->estimate_address_tel }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $estimateAddress->estimate_address_fax }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $estimateAddress->estimate_address_mail }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $estimateAddress->estimate_address_url }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ optional($estimateAddress->updatedBy)->user_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $estimateAddress->updated_at }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap ">
                            <button type="button" data-drawer-target="dupdateModal-{{ $estimateAddress->ulid }}" data-drawer-show="dupdateModal-{{ $estimateAddress->ulid }}" data-drawer-placement="right" aria-controls="dupdateModal-{{ $estimateAddress->ulid }}"  class="button-edit-primary">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                    <span class=" md:block hidden">編集</span>
                                </div>
                            </button>
                        </td>
                    </tr>

                    <!-- drawer component -->
                    <div id="dupdateModal-{{ $estimateAddress->ulid }}" class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform w-[30rem] translate-x-full bg-white  dark:bg-gray-800" tabindex="-1" aria-labelledby="dupdateModal-{{ $estimateAddress->ulid }}">
                        <div class="">
                            <h5 id="dupdateModal-{{ $estimateAddress->ulid }}" class="inline-flex items-center mb-4 font-semibold text-xl text-gray-500 dark:text-gray-400">
                                見積住所マスタ編集
                            </h5>
                            <button type="button" data-drawer-hide="dupdateModal-{{ $estimateAddress->ulid }}" aria-controls="dupdateModal-{{ $estimateAddress->ulid }}" class="text-gray-400 bg-transparent ml-8 hover:bg-gray-200 hover:text-gray-900 rounded-md text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('estimate-address.update', $estimateAddress->ulid) }}">
                            @csrf
                            @method('PUT')
                            <div class="w-full flex flex-col col-span-2 mt-10">
                                <label for="estimate_address_code-{{ $estimateAddress->ulid }}" class="dark:text-gray-100 text-gray-900 leading-none mt-1">見積住所コード</label>
                                <input type="text" name="estimate_address_code" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="estimate_address_code" value="{{ old('estimate_address_code', $estimateAddress->estimate_address_code) }}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="estimate_address_name-{{ $estimateAddress->ulid }}" class="dark:text-gray-100 text-gray-900 leading-none mt-1">見積住所名称</label>
                                <input type="text" name="estimate_address_name" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="estimate_address_name-{{ $estimateAddress->ulid }}" value="{{ old('estimate_address_name', $estimateAddress->estimate_address_name) }}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="estimate_address_1-{{ $estimateAddress->ulid }}" class="dark:text-gray-100 text-gray-900 leading-none mt-1">見積住所1</label>
                                <input type="text" name="estimate_address_1" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="estimate_address_1-{{ $estimateAddress->ulid }}" value="{{ old('estimate_address_1', $estimateAddress->estimate_address_1) }}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="estimate_address_2-{{ $estimateAddress->ulid }}" class="dark:text-gray-100 text-gray-900 leading-none mt-1">見積住所2</label>
                                <input type="text" name="estimate_address_2" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="estimate_address_2-{{ $estimateAddress->ulid }}" value="{{ old('estimate_address_2', $estimateAddress->estimate_address_2) }}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="estimate_address_3-{{ $estimateAddress->ulid }}" class="dark:text-gray-100 text-gray-900 leading-none mt-1">見積住所3</label>
                                <input type="text" name="estimate_address_3" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="estimate_address_3-{{ $estimateAddress->ulid }}" value="{{ old('estimate_address_3', $estimateAddress->estimate_address_3) }}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="estimate_address_tel-{{ $estimateAddress->ulid }}" class="dark:text-gray-100 text-gray-900 leading-none mt-1">見積TEL</label>
                                <input type="text" name="estimate_address_tel" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="estimate_address_tel-{{ $estimateAddress->ulid }}" value="{{ old('estimate_address_tel', $estimateAddress->estimate_address_tel) }}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="estimate_address_fax-{{ $estimateAddress->ulid }}" class="dark:text-gray-100 text-gray-900 leading-none mt-1">見積FAX</label>
                                <input type="text" name="estimate_address_fax" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="estimate_address_fax-{{ $estimateAddress->ulid }}" value="{{ old('estimate_address_fax', $estimateAddress->estimate_address_fax) }}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="estimate_address_mail-{{ $estimateAddress->ulid }}" class="dark:text-gray-100 text-gray-900 leading-none mt-1">見積Mail</label>
                                <input type="text" name="estimate_address_mail" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="estimate_address_mail-{{ $estimateAddress->ulid }}" value="{{ old('estimate_address_mail', $estimateAddress->estimate_address_mail) }}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="estimate_address_url-{{ $estimateAddress->ulid }}" class="dark:text-gray-100 text-gray-900 leading-none mt-1">見積URL</label>
                                <input type="text" name="estimate_address_url" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="estimate_address_url-{{ $estimateAddress->ulid }}" value="{{ old('estimate_address_url', $estimateAddress->estimate_address_url) }}">
                            </div>
                            <div>
                                <label for="project_affiliation1-{{ $estimateAddress->ulid }}" class="text-sm text-gray-900 dark:text-white leading-none mt-4">所属階層1</label>
                                <select id="project_affiliation1-{{ $estimateAddress->ulid }}" name="project_affiliation1" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">未選択</option>
                                    @foreach($affiliation1s as $affiliation1)
                                        <option value="{{ $affiliation1->id }}" @selected( $affiliation1->id == $estimateAddress->project_affiliation1)>{{ $affiliation1->affiliation1_name }}</option>
                                    @endforeach
                                </select>
                                @error('project_affiliation1')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="project_affiliation2-{{ $estimateAddress->ulid }}" class="text-sm text-gray-900 dark:text-white leading-none mt-4">所属階層2</label>
                                <select id="project_affiliation2-{{ $estimateAddress->ulid }}" name="project_affiliation2" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">未選択</option>
                                    @foreach($affiliation2s as $affiliation2)
                                        <option value="{{ $affiliation2->id }}" @selected( $affiliation2->id == $estimateAddress->project_affiliation2)>{{ $affiliation2->affiliation2_name }}</option>
                                    @endforeach
                                </select>
                                @error('project_affiliation2')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="project_affiliation3-{{ $estimateAddress->ulid }}" class="text-sm text-gray-900 dark:text-white leading-none mt-4">所属階層3</label>
                                <select id="project_affiliation3-{{ $estimateAddress->ulid }}" name="project_affiliation3" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">未選択</option>
                                    @foreach($affiliation3s as $affiliation3)
                                        <option value="{{ $affiliation3->id }}" @selected( $affiliation3->id == $estimateAddress->project_affiliation3)>{{ $affiliation3->affiliation3_name }}</option>
                                    @endforeach
                                </select>
                                @error('project_affiliation3')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <button type="submit" class="w-full justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ __('Update') }}
                                </button>
                                <button type="button" class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="mt-1 mb-1 px-4">
            {{-- {{ $estimateAddresss->withQueryString()->links('vendor.pagination.custum-tailwind') }} --}}
        </div> 
    </div> 
</x-app-layout>