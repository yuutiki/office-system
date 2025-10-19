<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-lg text-gray-900 dark:text-white flex items-center">
                {{ Breadcrumbs::render('accountingPeriodMaster') }}
                <div class="ml-4">
                    {{ $count ?? $accountingPeriods->count() }}件
                </div>
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
                <x-buttons.save-button onclick="openDrawer('create')" class="mr-2">
                    {{ __('create') }}
                </x-buttons.save-button>

                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full p-2.5 text-sm font-medium hover:bg-[#313a48] bg-[#364050] text-gray-200 rounded md:w-auto focus:z-10 dark:bg-blue-600 dark:text-gray-100 dark:border-gray-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <x-icon name="ui/dot-option" class="w-4 h-4"></x-icon>
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                {{-- route修正 --}}
                                <x-buttons.csv-upload-button :route="route('corporations.showUploadForm')" gate="admin_masters" />
                            </li>
                            <li>
                                {{-- route修正 --}}
                                <x-buttons.csv-download-button :route="route('support-types.export')" gate="download_masters" />
                            </li>
                            <hr class="border-gray-300 dark:border-gray-500 mx-2">

                            <li>
                                {{-- @can('admin_masters')
                                    <button type="button" data-modal-target="deleteModal-corporations" data-modal-show="deleteModal-corporations" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="flex items-center min-w-6">
                                        <x-icon name="actions/delete"></x-icon>
                                        </div>
                                        <div class="ml-2">データ削除</div>
                                    </button>
                                @else
                                    <button type="button" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="flex items-center min-w-6">
                                            <x-icon name="actions/lock"></x-icon>
                                        </div>
                                        <div class="ml-2">データ削除</div>
                                    </button>
                                @endcan --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md dark:text-gray-900 mt-4">
        <div class="w-full dark:bg-gray-800 p-4">
            <form method="GET" action="{{ route('accounting-period.index') }}" id="search_form" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-2 md:space-y-0">
                @csrf

                {{-- 名称検索 --}}
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-icon name="ui/search" class="w-5 h-5 text-gray-500 dark:text-gray-400 pointer-events-none" />
                    </div>
                    <input type="search" name="name" value="{{ $periodName ?? '' }}" class="input-search" placeholder="名称">
                </div>

                {{-- 期間検索（開始日） --}}
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-icon name="ui/calendar" class="w-5 h-5 text-gray-500 dark:text-gray-400 pointer-events-none" />
                    </div>
                    <input type="date" name="start_date" value="{{ $startDate ?? '' }}" class="input-search pl-10" placeholder="開始日">
                </div>

                {{-- 期間検索（終了日） --}}
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-icon name="ui/calendar" class="w-5 h-5 text-gray-500 dark:text-gray-400 pointer-events-none" />
                    </div>
                    <input type="date" name="end_date" value="{{ $endDate ?? '' }}" class="input-search pl-10" placeholder="終了日">
                </div>

                {{-- ボタン類 --}}
                <div class="flex space-x-2">
                    <x-buttons.search-button />
                    <x-buttons.reset-button />
                </div>
            </form>
        </div>


        <div class="md:w-auto md:mr-2 mb-4 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th scope="col" class="pl-4 py-3 whitespace-nowrap">名称</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">編集</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">開始日</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">終了日</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">期間</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">更新者</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">更新日時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accountingPeriods as $accountingPeriod)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600">
                            <td class="pl-4 py-2 whitespace-nowrap">
                                {{ $accountingPeriod->period_name }}
                            </td>
                            <td class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="text-center">
                                    <button type="button" class="button-edit-primary" onclick="openDrawer('{{$accountingPeriod->id}}')">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                            </svg>
                                            <span class="md:block hidden">編集</span>
                                        </div>
                                    </button>
                                </div>
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap">
                                {{ $accountingPeriod->period_start_at }}
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap">
                                {{ $accountingPeriod->period_end_at }}
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap">
                                @if ($accountingPeriod->duration_months === 12)
                                    <span class="">{{ $accountingPeriod->duration_months }} ヶ月</span>
                                @else
                                    <span class="text-red-600">{{ $accountingPeriod->duration_months }} ヶ月</span>
                                @endif
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap">
                                {{ optional($accountingPeriod->updatedBy)->user_name }}
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap hidden md:block">
                                {{ $accountingPeriod->updated_at }}
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap md:hidden">
                                {{ $accountingPeriod->updated_at->format('Y-m-d') }}
                            </td>
                        </tr>
                        
                        <!-- drawer component -->
                        <div id="drawer-{{$accountingPeriod->id}}" 
                            class="drawer-component fixed top-0 right-0 z-50 h-screen overflow-y-auto bg-white dark:bg-gray-600 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out"
                            style="min-width: 300px; width: min(40rem, 100vw); max-width: 100vw;">
                        
                            {{-- リサイズハンドル --}}
                            <div class="resize-handle absolute left-0 top-0 w-2 h-full cursor-col-resize bg-gray-200 hover:bg-blue-500 opacity-0 hover:opacity-100 transition-opacity">
                            </div>
                    
                            {{-- フォーム部分 --}}
                            <div class="">
                                <form method="POST" action="{{ route('accounting-period.update', $accountingPeriod->id) }}" id="accounting-period-form-{{$accountingPeriod->id}}" data-is-changed="false">
                                    @csrf
                                    @method('PUT')

                                    <div class="flex justify-between items-center p-4">
                                        <button type="button" 
                                            data-drawer-id="{{$accountingPeriod->id}}"
                                            class="p-0.5 rounded text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-500 dark:hover:text-white">
                                            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
                                            </svg>
                                        </button>

                                        <div class="flex gap-4">
                                            <x-buttons.save-button form-id="accounting-period-form-{{$accountingPeriod->id}}" id="saveButton" class="" data-drawer-id="{{$accountingPeriod->id}}">
                                                {{ __("update") }}
                                            </x-buttons.save-button>

                                            <button type="button" data-modal-target="deleteModal-{{$accountingPeriod->id}}" data-modal-show="deleteModal-{{$accountingPeriod->id}}" class="button-delete-primary">
                                                <x-icon name="actions/delete" class="w-5 h-5 mr-1 -ml-1"></x-icon>
                                                {{ __('delete') }}
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4 p-4">
                                        <div class="w-full">
                                            <label for="period_name-{{$accountingPeriod->id}}" class="block font-semibold dark:text-gray-100 text-gray-900">
                                                名称
                                            </label>
                                            <input type="text" 
                                                    name="period_name" 
                                                    id="period_name-{{$accountingPeriod->id}}" 
                                                    value="{{old('period_name',$accountingPeriod->period_name)}}" 
                                                    class="input-secondary" 
                                                    required>
                                            @error('period_name')
                                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="w-full">
                                            <label for="period_start_at-{{$accountingPeriod->id}}" class="block font-semibold dark:text-gray-100 text-gray-900">
                                                開始日
                                            </label>
                                            <input type="date" 
                                                    min="1900-01-01" 
                                                    max="2100-12-31" 
                                                    name="period_start_at" 
                                                    id="period_start_at-{{$accountingPeriod->id}}" 
                                                    value="{{old('period_start_at',$accountingPeriod->period_start_at)->format('Y-m-d')}}" 
                                                    class="input-secondary" 
                                                    required>
                                            @error('period_start_at')
                                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="w-full">
                                            <label for="period_end_at-{{$accountingPeriod->id}}" class="block font-semibold dark:text-gray-100 text-gray-900">
                                                終了日
                                            </label>
                                            <input type="date" 
                                                    min="1900-01-01" 
                                                    max="2100-12-31" 
                                                    name="period_end_at" 
                                                    id="period_end_at-{{$accountingPeriod->id}}" 
                                                    value="{{old('period_end_at',$accountingPeriod->period_end_at)->format('Y-m-d')}}" 
                                                    class="input-secondary" 
                                                    required>
                                            @error('period_end_at')
                                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        {{-- 削除確認モーダル画面 Start --}}
                        <div id="deleteModal-{{$accountingPeriod->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                                    <button data-modal-hide="deleteModal-{{$accountingPeriod->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                    </button>

                                    <div class="p-6 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                                        <form action="{{route('accounting-period.destroy',$accountingPeriod->id)}}" method="POST" class="text-center m-auto">
                                            @csrf
                                            @method('delete')
                                            @can('delete_masters')
                                                <button type="submit" data-modal-hide="deleteModal-{{$accountingPeriod->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-s rounded-e text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    削除
                                                </button>
                                            @endcan
                                        </form>
                                        <button data-modal-hide="deleteModal-{{$accountingPeriod->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            やっぱやめます
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- 削除確認モーダル画面 End --}}
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-1 mb-1 px-4">
            {{ $accountingPeriods->withQueryString()->links('vendor.pagination.custom-tailwind') }}  
        </div> 
    </div>


    {{-- 新規登録用ドロワー --}}
    <div id="drawer-create" 
        class="drawer-component fixed top-0 right-0 z-50 h-screen overflow-y-auto bg-gray-100 dark:bg-gray-600 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out"
        style="min-width: 300px; width: 40rem; max-width: 1200px;">
        
        {{-- リサイズハンドル --}}
        <div class="resize-handle absolute left-0 top-0 w-2 h-full cursor-col-resize bg-gray-200 hover:bg-blue-500 opacity-0 hover:opacity-100 transition-opacity"></div>

        <div class="p-4">
            <form method="POST" 
                action="{{ route('accounting-period.store') }}" 
                id="accounting-period-form-create" 
                data-is-changed="false">
                @csrf

                <div class="flex justify-between items-center">
                    <button type="button" 
                            data-drawer-id="create"
                            class="close-drawer-button p-0.5 rounded text-gray-600 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-500 dark:hover:text-white">
                            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
                            </svg>
                    </button>
                </div>

                <div class="space-y-4 mt-4">
                    <div class="w-full">
                        <label for="period_name" class="block font-semibold dark:text-gray-100 text-gray-900">
                            名称
                        </label>
                        <input type="text" 
                            name="period_name" 
                            id="period_name"
                            value="{{ old('period_name') }}"
                            class="input-secondary" 
                            required>
                        @error('period_name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="period_start_at" class="block font-semibold dark:text-gray-100 text-gray-900">
                            開始日
                        </label>
                        <input type="date" 
                            min="1900-01-01" 
                            max="2100-12-31" 
                            name="period_start_at" 
                            id="period_start_at"
                            value="{{ old('period_start_at') }}"
                            class="input-secondary" 
                            required>
                        @error('period_start_at')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="period_end_at" class="block font-semibold dark:text-gray-100 text-gray-900">
                            終了日
                        </label>
                        <input type="date" 
                            min="1900-01-01" 
                            max="2100-12-31" 
                            name="period_end_at" 
                            id="period_end_at"
                            value="{{ old('period_end_at') }}"
                            class="input-secondary" 
                            required>
                        @error('period_end_at')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <x-buttons.save-button class="mr-2">
                            {{ __('save') }}
                        </x-buttons.save-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            window.FORM_PREFIX = 'accounting-period-form';
        </script>
        <script src="{{ asset('assets/js/drawer-manager.js') }}"></script>
    @endpush
</x-app-layout>