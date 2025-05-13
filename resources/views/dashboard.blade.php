<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight items-center pb-1.5">
            {{ Breadcrumbs::render('dashboard') }}
        </h2>
        <div class="flex justify-end">
            <x-message :message="session('message')"/>
        </div>
    </x-slot>


    <!-- 必要なスクリプト -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@latest/dist/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    {{-- @include('dashboard.components.my-calendar') --}}


        <main class="p-2 md:ml-12 h-full">
            <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-4 mb-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg dark:border-gray-600 h-32 md:h-36">


                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl h-full">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xs uppercase font-bold text-gray-500 dark:text-gray-400 tracking-wider">
                                    @if(isset($currentPeriod))
                                        当期案件規模:{{ $currentPeriod->period_name }}
                                    @else
                                        当期案件規模:-
                                    @endif
                                </h3>
                                <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-white whitespace-nowrap">
                                    {{ number_format($totalRevenue) }}円
                                </p>
                            </div>
                            <div class="bg-red-500 p-3 rounded-full shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="text-green-500 flex items-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                3.48%
                            </span>
                            <span class="whitespace-nowrap">
                                @if(isset($currentPeriod))
                                    {{ $currentPeriod->period_start_at->format('Y年m月d日') }} 〜 {{ $currentPeriod->period_end_at->format('Y年m月d日') }}
                                @else
                                    現在の計上期が設定されていません
                                @endif
                            </span>
                        </div>
                    </div>


                </div>
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-32 md:h-36">


                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl h-full">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xs uppercase font-bold text-gray-500 dark:text-gray-400 tracking-wider">
                                    @if(isset($currentPeriod))
                                        当期売上計上額:{{ $currentPeriod->period_name }}
                                    @else
                                        当期売上計上額:-
                                    @endif
                                </h3>
                                <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-white whitespace-nowrap">
                                    832,456,236円
                                </p>
                            </div>
                            <div class="bg-pink-500 p-3 rounded-full shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="text-orange-500 flex items-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                                56.14%
                            </span>
                            <span class="whitespace-nowrap">対当期売上予算比</span>
                        </div>
                    </div>


                </div>
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-32 md:h-36">


                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl h-full">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xs uppercase font-bold text-gray-500 dark:text-gray-400 tracking-wider">
                                    顧客数（アクティブ）
                                </h3>
                                <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-white whitespace-nowrap">
                                    {{ $clientCount }}
                                </p>
                            </div>
                            <div class="bg-orange-500 p-3 rounded-full shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="text-red-500 flex items-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                                3.48%
                            </span>
                            <span class="whitespace-nowrap">昨期比</span>
                        </div>
                    </div>


                </div>
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-32 md:h-36">


                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl h-full">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xs uppercase font-bold text-gray-500 dark:text-gray-400 tracking-wider">
                                    当期売上予算（事業部）
                                </h3>
                                <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-white whitespace-nowrap">
                                    1,446,856,894円
                                </p>
                            </div>
                            <div class="bg-blue-500 p-3 rounded-full shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="text-green-500 flex items-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                12%
                            </span>
                            <span class="whitespace-nowrap">対前期比</span>
                        </div>
                    </div>


                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-y-4 md:gap-4 mb-4">

                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-96 col-span-2">
                    
                    <div class="w-full p-6 bg-white rounded-lg dark:bg-gray-800 shadow-lg h-full">
                        <div class="flex justify-between mb-3">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">
                                        売上推移
                                        <svg data-popover-target="clicks-info" data-popover-placement="right" class="w-3 h-3 text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                        </svg>
                                        <div data-popover id="clicks-info" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-36 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                            <div class="p-3 space-y-2">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                                    Clicks growth
                                                </h3>
                                                <p>Report helps navigate cumulative growth of community activities.</p>
                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>
                                    </h5>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                        {{ number_format($totalRevenue) }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <button id="dropdownDefaultButton"
                                    data-dropdown-toggle="lastDaysdropdown"
                                    data-dropdown-placement="bottom" type="button" class="px-3 py-2 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        Last week
                                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                        <li>
                                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">所属1</a>
                                        </li>
                                        <li>
                                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">所属2</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="beta-line-chart"></div>
                        {{-- <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between mt-2.5"></div> --}}
                    </div>


                </div>
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600  h-96 col-span-1">
                    @include('dashboard.components.datetime-widget')
                </div>
            </div>
            <div class="border-2 border-dashed rounded-2xl border-gray-300 dark:border-gray-600 h-auto mb-6">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                            サポート件数
                        </h2>
                        <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                        </button>
                    </div>
            
                    {{-- チャートエリア --}}
                    <div id="main" class="h-[320px] sm:h-[360px] md:h-[380px] w-full"></div>
                </div>
            </div>
            

            <div class="grid lg:grid-cols-2 gap-4 mb-4">
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72 overflow-y-auto">
                    <div class="w-full h-full">

                        <!-- 営業個人予算達成率 -->
                        {{-- <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 transition-all duration-300 hover:shadow-xl h-full overflow-y-auto"> --}}
                        <div class="relative flex flex-col min-w-0 bg-white dark:bg-gray-800 w-full mb-6 shadow-lg rounded-lg px-4 py-4 md:px-6 md:py-5 h-full">

                            <h2 class="text-gray-800 text-lg font-semibold dark:text-white mb-4">
                                営業個人予算達成率
                            </h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 rounded-lg">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">

                                        <tr class="bg-gray-50 dark:bg-gray-700">
                                            <th scope="col" class="px-6 py-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-left">氏名</th>
                                            <th scope="col" class="px-6 py-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-left">当期予算額</th>
                                            <th scope="col" class="px-6 py-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-left" style="min-width:140px">達成率</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">末久優</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">125,000,000円</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">60%</span>
                                                    <div class="w-full bg-red-200 rounded-full h-2.5 dark:bg-red-700">
                                                        <div class="bg-red-600 h-2.5 rounded-full" style="width: 60%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">営業担当A</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">115,000,000円</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">70%</span>
                                                    <div class="w-full bg-emerald-200 rounded-full h-2.5 dark:bg-emerald-700">
                                                        <div class="bg-emerald-600 h-2.5 rounded-full" style="width: 70%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">営業担当A</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">115,000,000円</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">70%</span>
                                                    <div class="w-full bg-emerald-200 rounded-full h-2.5 dark:bg-emerald-700">
                                                        <div class="bg-emerald-600 h-2.5 rounded-full" style="width: 70%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">営業担当A</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">115,000,000円</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">70%</span>
                                                    <div class="w-full bg-emerald-200 rounded-full h-2.5 dark:bg-emerald-700">
                                                        <div class="bg-emerald-600 h-2.5 rounded-full" style="width: 70%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">営業担当A</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">115,000,000円</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">70%</span>
                                                    <div class="w-full bg-emerald-200 rounded-full h-2.5 dark:bg-emerald-700">
                                                        <div class="bg-emerald-600 h-2.5 rounded-full" style="width: 70%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">営業担当A</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">115,000,000円</td>
                                            <td class="px-6 py-2.5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">70%</span>
                                                    <div class="w-full bg-emerald-200 rounded-full h-2.5 dark:bg-emerald-700">
                                                        <div class="bg-emerald-600 h-2.5 rounded-full" style="width: 70%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72 overflow-y-auto">
                    @include('dashboard.components.my-attention-table')
                </div>
                
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">

                </div>
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">

                </div>
            </div>

            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-96 mb-4">
                @include('dashboard.components.my-support-table', ['mySupports' => $mySupports])
            </div>
            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-96 mb-4">
                @include('dashboard.components.my-project-table')
            </div>

            {{-- <div class="grid grid-cols-2 gap-4">
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
                </div>
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
                
                </div>
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
                
                </div>
                <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">

                </div>
            </div> --}}
        </main>

                <!-- サポート件数と利用形態 -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- 利用形態円グラフ (1/3幅) -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">利用形態</h2>
                            <div class="relative">
                                <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div id="pieChart" class="h-[380px]"></div>
                    </div>
                </div>


    <script>
        const options = {
            chart: {
                height: "82%",
                maxWidth: "100%",
                type: "line",
                fontFamily: "Inter, sans-serif",
                dropShadow: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
                zoom: {
                    enabled: false, // ← これを追加！
                },
            },
            tooltip: {
                enabled: true,
                x: {
                    show: false,
                },
                y: {
                    formatter: (value) => `¥${value.toLocaleString()}`,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 6,
                curve: 'smooth',
            },
            grid: {
                show: true,
                strokeDashArray: 4,
                padding: {
                    left: 10,
                    right: 10,
                    top: -17,
                },
            },
            series: [
                {
                    name: "受注額",
                    data: @json($monthlyRevenue),
                    color: "#1A56DB",
                },
            ],
            legend: {
                show: true,
            },
            xaxis: {
                categories: @json($xAxisCategories),
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                    },
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                    },
                    formatter: (value) => `¥${value.toLocaleString()}`,
                },
            },
        };
    
        if (document.getElementById("beta-line-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("beta-line-chart"), options);
            chart.render();
        }
    </script>

    <script src="{{ asset('assets/js/chart/barSupport.js') }}"></script>
    <script src="{{ asset('assets/js/chart/pieUsage.js') }}"></script>
</x-app-layout>