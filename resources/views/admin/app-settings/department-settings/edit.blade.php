<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('departmentSetting') }}
            </h2>
            <div class="flex items-center space-x-2">
                <form method="post" action="{{ route('department-settings.update', $departmentSetting) }}" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('put')
                    @can('storeUpdate_corporations')
                        <x-button-save form-id="editForm" id="saveButton" onkeydown="stopTab(event)">
                            {{ __("update") }}
                        </x-button-save>
                    @endcan
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex -mb-px text-sm" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">設定情報</button>
                </li>
            </ul>
        </div>
        
        <div class="p-2 md:p-4 mb-4 rounded bg-gray-50 dark:bg-gray-800 shadow-md" id="base" role="tabpanel" aria-labelledby="base-tab">
            <table class="w-full text-sm text-gray-900 dark:text-gray-200 border border-gray-600">
                <thead class="text-sm text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-3 py-2 border-x border-gray-600">設定項目</th>
                        <th class="px-2 py-2 border-x border-gray-600">設定値</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-3 py-1 border border-gray-600 text-xs md:text-base">
                            所属部門の最大階層数（1~10）
                        </td>
                        <td class="px-2 py-2 border border-gray-600">
                            <div class="flex items-center">
                                <input type="number" 
                                       form="editForm" 
                                       name="max_level" 
                                       inputmode="numeric" 
                                       class="no-spinners w-16 py-0.5 text-sm rounded-sm bg-gray-100 border border-gray-700 text-gray-900 focus:ring-2 focus:ring-indigo-500 transition duration-150" 
                                       id="max_level" 
                                       value="{{old('max_level', $departmentSetting->max_level)}}" 
                                       min="1" 
                                       max="10">
                                <span class="text-base ml-2">階層</span>
                            </div>
                            @error('max_level')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-3 py-1 border border-gray-600 text-xs md:text-base">
                            所属部門コードの桁数（1~10）
                        </td>
                        <td class="px-2 py-2 border border-gray-600">
                            <div class="flex items-center">
                                <input type="number" 
                                       form="editForm" 
                                       name="code_length" 
                                       inputmode="numeric" 
                                       class="no-spinners w-16 py-0.5 text-sm rounded-sm bg-gray-100 border border-gray-700 text-gray-900 focus:ring-2 focus:ring-indigo-500 transition duration-150" 
                                       id="code_length" 
                                       value="{{old('code_length', $departmentSetting->code_length)}}" 
                                       min="1" 
                                       max="10">
                                <span class="text-base ml-2">桁</span>
                            </div>
                            @error('code_length')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .no-spinners::-webkit-outer-spin-button,
        .no-spinners::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .no-spinners[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
</x-app-layout>