<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                プロジェクト種別マスタ
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('masters.index')}}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div class="w-5/6 m-auto relative overflow-x-auto rounded-s rounded-e mt-4 shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-50">
            <div class="w-full">
              <!-- Start coding here -->
              <div class="relative bg-white dark:bg-gray-800">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                  <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                      <label for="simple-search" class="sr-only">Search</label>
                      <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                          <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                          </svg>
                        </div>
                        <input type="text" id="simple-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="名称" required="">
                      </div>
                    </form>
                  </div>
                  <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                    <button type="button" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                      <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                      </svg>
                      Add
                    </button>
                    <div class="flex items-center w-full space-x-3 md:w-auto">
                      {{-- <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
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
                      <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filter
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                      </button>
                      <!-- Dropdown menu -->
                      <div id="filterDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                          Category
                        </h6>
                        <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                          <li class="flex items-center">
                            <input id="apple" type="checkbox" value=""
                              class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
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
                            コード
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            名称
                        </div>
                    </th>
                    {{-- <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            英名称
                        </div>
                    </th> --}}
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
                @foreach ($projectTypes as $projectType)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white dark:hover:bg-gray-600">
                        {{-- <td class="pl-4 py-2 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td> --}}
                        <td class="pl-4 py-2 whitespace-nowrap">
                            {{ $projectType->project_type_code }}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$projectType->project_type_name}}
                        </td>
                        {{-- <td class="px-1 py-2 whitespace-nowrap">
                            {{$projectType->projectType_eng_name}}
                        </td> --}}
                        {{-- <td class="px-1 py-2 whitespace-nowrap">
                            {{$projectType->created_at}}
                        </td> --}}
                        {{-- <td class="px-1 py-2 whitespace-nowrap">
                            {{$projectType->created_by}}
                        </td> --}}
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{-- {{$projectType->updatedBy->name}} --}}
                            {{ optional($projectType->updatedBy)->name }}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$projectType->updated_at}}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="text-center">
                                <button class="button-edit" type="button" data-drawer-target="dupdateModal-{{$projectType->id}}" data-drawer-show="dupdateModal-{{$projectType->id}}" data-drawer-placement="right" aria-controls="dupdateModal-{{$projectType->id}}">
                                編集
                                </button>
                            </div>
                        </td>
                    </tr>
                                    <!-- drawer component -->
                    <div id="dupdateModal-{{$projectType->id}}" class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform w-[30rem] translate-x-full bg-white  dark:bg-gray-800" tabindex="-1" aria-labelledby="dupdateModal-{{$projectType->id}}">
                        <div class="">
                            <h5 id="dupdateModal-{{$projectType->id}}" class="inline-flex items-center mb-4 font-semibold text-xl text-gray-500 dark:text-gray-400">
                                報告種別マスタ編集
                            </h5>
                            <button type="button" data-drawer-hide="dupdateModal-{{$projectType->id}}" aria-controls="dupdateModal-{{$projectType->id}}" class="text-gray-400 bg-transparent ml-8 hover:bg-gray-200 hover:text-gray-900 rounded-md text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('project-type.update', $projectType->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="w-full flex flex-col col-span-2 mt-10">
                                <label for="project_type_code-{{$projectType->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">コード</label>
                                <input type="text" maxlength="2" name="project_type_code" id="project_-{{$projectType->id}}" value="{{old('project_type_code',$projectType->project_type_code)}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                            </div>
                            @error('project_type_code')
                            <div class="text-red-500">{{ $message }}</div>
                          @enderror
                            <div class="w-full flex flex-col col-span-2">
                                <label for="project_type_name-{{$projectType->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">名称</label>
                                <input type="text" maxlength="10" name="project_type_name" id="project_type_name-{{$projectType->id}}" value="{{old('project_type_name',$projectType->project_type_name)}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                            </div>
                            @error('project_type_name')
                              <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            {{-- <div class="w-full flex flex-col col-span-2">
                                <label for="product_type_eng_name-{{$projectType->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">英名称</label>
                                <input type="text" name="product_type_eng_name" id="product_type_eng_name-{{$projectType->id}}" value="{{old('projectType_eng_name',$projectType->projectType_eng_name)}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1">
                            </div> --}}

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <button type="submit" class="w-full justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
        <div class="mt-1 mb-1 px-4">
        {{ $projectTypes->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    </div>
</x-app-layout>