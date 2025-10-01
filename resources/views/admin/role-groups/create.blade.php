<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createRoleGroup') }}
            </h2>
            <form method="post" class="ml-auto" action="{{route('role-groups.store')}}" enctype="multipart/form-data" id="createForm">
                @csrf
                <x-buttons.save-button form-id="createForm" id="saveButton" onkeydown="stopTab(event)">
                    {{ __("save") }}
                </x-buttons.save-button>
            </form>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTabContent" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">グループ情報</button>
                </li>
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">
            <div>
                <div  class="w-full flex flex-col">
                    <label for="role_group_code" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">権限グループコード<span class="text-red-500"> *</span></label>
                    <input type="text" form="createForm" maxlength="4" name="role_group_code" class="input-primary" id="role_group_code" value="{{old('role_group_code')}}" tabindex="-1">
                </div>
                @error('role_group_code')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div class="w-full flex flex-col">
                <label for="role_group_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">権限グループ名称<span class="text-red-500"> *</span></label>
                <input type="text" form="createForm" name="role_group_name" class="input-secondary" id="role_group_name" value="{{old('role_group_name')}}">
                @error('role_group_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div  class="w-full flex flex-col">
                    <label for="role_group_eng_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">権限グループ英名称<span class="text-red-500"> *</span></label>
                    <input type="text" form="createForm" name="role_group_eng_name" class="input-secondary" id="role_group_eng_name" value="{{old('role_group_eng_name')}}">
                </div>
                @error('role_group_eng_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div class="w-full flex flex-col">
                    <label for="role_group_memo" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">備考</label>
                    <input type="text" form="createForm" name="role_group_memo" class="input-secondary" id="role_group_memo" value="{{old('role_group_memo')}}">
                </div>
                @error('role_group_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
</x-app-layout>