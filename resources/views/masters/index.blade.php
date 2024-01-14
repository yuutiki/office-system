<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            {{-- マスタ一覧 --}}
            {{ Breadcrumbs::render('masters') }}
        </h2>
        <x-message :message="session('message')" />
    </x-slot>
    <div class="w-5/6 relative overflow-x-auto shadow-md rounded-lg mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
        <table class="w-full text-sm font-medium text-left text-gray-800 dark:text-gray-400">
            <thead class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="pl-4 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            №
                        </div>
                    </th>
                    {{-- <th scope="col" class="px-2 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('status_flag','ステータス')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th> --}}
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            マスタ名称
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            参照
                        </div>
                    </th>
                </tr>
            </thead>
            @foreach ($masters as $master)
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white dark:hover:bg-gray-600">
                        <td class="pl-4 py-2 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$master['name']}}
                        </td>
                        {{-- <td class="px-1 py-2 whitespace-nowrap">
                            <a href="{{ route($master['route']) }}" class="button-edit">参照ボタン</a>
                        </td> --}}
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="text-center">
                                <button class="button-edit" type="button" onclick="location.href='{{route($master['route'])}}'">
                                編集
                                </button>
                            </div>
                        </td>
                        {{-- <td class="px-1 py-2 whitespace-nowrap">
                            {{$project->accountingType->accounting_type_name}}
                        </td> --}}
                    </tr>
                </tbody>
            @endforeach
        </table>
        <div class="mt-2 mb-2 px-4">
        {{-- {{ $projects->withQueryString()->links('vendor.pagination.custum-tailwind') }}   --}}
        </div> 
    </div>
</x-app-layout>