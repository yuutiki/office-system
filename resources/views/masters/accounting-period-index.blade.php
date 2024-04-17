<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            会計期マスタ
        </h2>
        <div class="flex justify-end">
            <x-general-button onclick="location.href='{{route('masters.index')}}'">
                戻る
            </x-general-button>
            <x-message :message="session('message')"/>
        </div>
    </x-slot>

    <div class="w-5/6 m-auto relative overflow-x-auto rounded-s rounded-e">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    {{-- <th scope="col" class="pl-4 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            №
                        </div>
                    </th> --}}

                    <th scope="col" class="pl-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            名称
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            開始日
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            終了日
                        </div>
                    </th>
                    {{-- <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            作成日時
                        </div>
                    </th> --}}
                    {{-- <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            作成者
                        </div>
                    </th> --}}
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            更新者
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
                @foreach ($accountingPeriods as $accountingPeriod)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white dark:hover:bg-gray-600">
                        {{-- <td class="pl-4 py-2 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td> --}}
                        <td class="pl-4 py-2 whitespace-nowrap">
                            {{ $accountingPeriod->period_name }}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$accountingPeriod->period_start_at}}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$accountingPeriod->period_end_at}}
                        </td>
                        {{-- <td class="px-1 py-2 whitespace-nowrap">
                            {{$accountingPeriod->created_at}}
                        </td> --}}
                        {{-- <td class="px-1 py-2 whitespace-nowrap">
                            {{$accountingPeriod->created_by}}
                        </td> --}}
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{-- {{$accountingPeriod->updatedBy->name}} --}}
                            {{ optional($accountingPeriod->updatedBy)->user_name }}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$accountingPeriod->updated_at}}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="text-center">
                                <button class="button-edit-primary" type="button" data-drawer-target="dupdateModal-{{$accountingPeriod->id}}" data-drawer-show="dupdateModal-{{$accountingPeriod->id}}" data-drawer-placement="right" aria-controls="dupdateModal-{{$accountingPeriod->id}}">
                                編集
                                </button>
                            </div>
                        </td>
                    </tr>
                                    <!-- drawer component -->
                    <div id="dupdateModal-{{$accountingPeriod->id}}" class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform w-[40rem] translate-x-full bg-white  dark:bg-gray-800" tabindex="-1" aria-labelledby="dupdateModal-{{$accountingPeriod->id}}">
                        <div class="">
                            <h5 id="dupdateModal-{{$accountingPeriod->id}}" class="inline-flex items-center mb-4 font-semibold text-xl text-gray-500 dark:text-gray-400">
                                都道府県マスタ編集
                            </h5>
                            <button type="button" data-drawer-hide="dupdateModal-{{$accountingPeriod->id}}" aria-controls="dupdateModal-{{$accountingPeriod->id}}" class="text-gray-400 bg-transparent ml-8 hover:bg-gray-200 hover:text-gray-900 rounded-md text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('accounting-period.update', $accountingPeriod->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="w-full flex flex-col col-span-2 mt-10">
                                <label for="period_name-{{$accountingPeriod->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">名称</label>
                                <input type="text" name="period_name" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="period_name-{{$accountingPeriod->id}}" value="{{old('period_name',$accountingPeriod->period_name)}}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="period_start_at-{{$accountingPeriod->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">開始日</label>
                                <input type="date" min="1900-01-01" max="2100-12-31" name="period_start_at" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="period_start_at-{{$accountingPeriod->id}}" value="{{old('period_start_at',$accountingPeriod->period_start_at)}}">
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="period_end_at-{{$accountingPeriod->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">終了日</label>
                                <input type="date" min="1900-01-01" max="2100-12-31" name="period_end_at" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="period_end_at-{{$accountingPeriod->id}}" value="{{old('period_end_at',$accountingPeriod->period_end_at)}}">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <button type="submit" class="w-full justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    Update
                                </button>
                                <button type="button" class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    Delete
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2 mb-2 px-4">
        {{-- {{ $projects->withQueryString()->links('vendor.pagination.custum-tailwind') }}   --}}
        </div> 
    </div>
</x-app-layout>