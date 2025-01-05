<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('affiliation-level-setting') }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />

                <form method="post" action="{{ route('password-policy.update', $passwordPolicy) }}" enctype="multipart/form-data" id="editForm" class="flex items-center">
                    @csrf
                    @method('patch')
                    @can('storeUpdate_corporations')
                        <x-button-save form-id="editForm" id="saveButton" onkeydown="stopTab(event)">
                            {{ __("Update") }}
                        </x-button-save>
                    @endcan
                </form>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>


    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">ポリシー情報</button>
                </li>
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-200 border border-gray-600">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                        <tr class="">
                            <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">
                                ポリシー項目
                            </th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">
                                設定値
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-6 py-1 border text-base border-gray-600">
                                所属階層利用設定（1~30）
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <div class="w-full flex">
                                    <input type="number" form="passwordPolicyForm" name="min_length" class="w-20 py-0.5 rounded dark:bg-gray-100 border-gray-700 border border-transparent dark:text-gray-900 tracking-widest hover:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150" id="min_length" value="{{old('min_length', $passwordPolicy->min_length)}}" placeholder=""  min="8" max="30">
                                    <div class="font-semibold text-base my-auto ml-4">桁</div>
                                </div>
                                @error('min_length')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>

                        {{-- <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-6 py-1 border text-base border-gray-600">
                                記号文字の使用を必須にする
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" form="passwordPolicyForm" name="require_symbol" value="0">
                                    @if($passwordPolicy->require_symbol == 1)
                                        <input type="checkbox" form="passwordPolicyForm" name="require_symbol" id="require_symbol" value="1" class="sr-only peer" checked>
                                    @else
                                        <input type="checkbox" form="passwordPolicyForm" name="require_symbol" id="require_symbol" value="1" class="sr-only peer">
                                    @endif
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
                                </label>
                                @error('require_symbol')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
</x-app-layout>