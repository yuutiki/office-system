<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("ログインしました") }}
                </div>
            </div>
        </div>
    </div> --}}

{{-- <div class="bg-dark py-6 sm:py-8 lg:py-10 w-5/6">
    
    <div class=" flex justify-normal">
        <div class="group border-2 ml-32  mx-auto w-full mb-2 block h-64 overflow-hidden rounded-lg bg-gray-700 shadow-lg lg:mb-3">
            事業部予算
        </div>
        <div class="group border-2 ml-2  mx-auto w-full mb-2 block h-64 overflow-hidden rounded-lg bg-gray-700 shadow-lg lg:mb-3">
            個人予算
            <span>売上予算:￥125,000,000-</span>
            <span>粗利予算:￥65,000,000-</span>
        </div>
    </div>

    <div class="mb-6 flex items-end justify-between gap-4 mx-auto max-w-screen-2xl px-4 md:px-8">>
        <div class="grid gap-x-4 gap-y-6 sm:grid-cols-2 md:gap-x-6 lg:grid-cols-3 xl:grid-cols-5 border-2">
            <div class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-700 shadow-lg lg:mb-3">
                aaaaaaaaaaaaaaaaaaaaaaaaa
            </div>
            <div class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-700 shadow-lg lg:mb-3">
                aaaaaaaaaaaaaaaaaaaaaaaaa
            </div>
            <div class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-700 shadow-lg lg:mb-3">
                aaaaaaaaaaaaaaaaaaaaaaaaa
            </div>
        </div>
    </div>
</div> --}}




  <body class="text-blueGray-700 antialiased">
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root">

      <div class="relative  bg-blueGray-50">
        <nav class="absolute top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-nowrap md:justify-start flex items-center p-4">
          <div class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
            <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
              <a class="text-blueGray-500 block" href="#pablo" onclick="openDropdown(event,'user-dropdown')">
                <div class="items-center flex">
                  <span class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"></span>
                </div>
              </a>
              <div
                class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
                style="min-width: 12rem;"
                id="user-dropdown">
                <a
                  href="#pablo"
                  class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                  >Action</a>
                <a
                  href="#pablo"
                  class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">
                  Another action
                </a>
                <a
                  href="#pablo"
                  class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                  >Something else here
                </a>
                <div class="h-0 my-2 border border-solid border-blueGray-100"></div>
                <a
                  href="#pablo"
                  class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                  >Seprated link
                </a>
              </div>
            </ul>
          </div>
        </nav>
        <!-- Header -->
        <div class="relative  pb-32 pt-12">
          <div class="px-4 md:px-10 mx-auto w-full">
            <div>
              <!-- Card stats -->
              <div class="flex flex-wrap">
                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                  <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                    <div class="flex-auto p-4">
                      <div class="flex flex-wrap">
                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                          <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                            Traffic
                          </h5>
                          <span class="font-semibold text-xl text-blueGray-700">
                            350,897
                          </span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                          <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                            <i class="far fa-chart-bar"></i>
                          </div>
                        </div>
                      </div>
                        <p class="text-sm text-blueGray-400 mt-4">
                        <span class="text-emerald-500 mr-2">
                          <i class="fas fa-arrow-up"></i> 3.48%
                        </span>
                        <span class="whitespace-nowrap">
                          Since last month
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                  <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                    <div class="flex-auto p-4">
                      <div class="flex flex-wrap">
                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                          <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                            users
                          </h5>
                          <span class="font-semibold text-xl text-blueGray-700">
                            2,356
                          </span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                          <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-orange-500">
                            <i class="fas fa-chart-pie"></i>
                          </div>
                        </div>
                      </div>
                      <p class="text-sm text-blueGray-400 mt-4">
                        <span class="text-red-500 mr-2">
                          <i class="fas fa-arrow-down"></i> 3.48%
                        </span>
                        <span class="whitespace-nowrap">
                          Since last week
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                  <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                    <div class="flex-auto p-4">
                      <div class="flex flex-wrap">
                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                          <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                            Sales
                          </h5>
                          <span class="font-semibold text-xl text-blueGray-700">
                            924
                          </span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                          <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-pink-500">
                            <i class="fas fa-users"></i>
                          </div>
                        </div>
                      </div>
                      <p class="text-sm text-blueGray-400 mt-4">
                        <span class="text-orange-500 mr-2">
                          <i class="fas fa-arrow-down"></i> 1.10%
                        </span>
                        <span class="whitespace-nowrap">
                          Since yesterday
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                  <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                    <div class="flex-auto p-4">
                      <div class="flex flex-wrap">
                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                          <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                            Performance
                          </h5>
                          <span class="font-semibold text-xl text-blueGray-700">
                            49,65%
                          </span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                          <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-lightBlue-500">
                            <i class="fas fa-percent"></i>
                          </div>
                        </div>
                      </div>
                      <p class="text-sm text-blueGray-400 mt-4">
                        <span class="text-emerald-500 mr-2">
                          <i class="fas fa-arrow-up"></i> 12%
                        </span>
                        <span class="whitespace-nowrap">
                          Since last month
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="px-4 md:px-10 mx-auto w-full -m-24">
          <div class="flex flex-wrap">
            <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
              <div
                class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-blueGray-800"
              >
                <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
                  <div class="flex flex-wrap items-center">
                    <div class="relative w-full max-w-full flex-grow flex-1">
                      <h6
                        class="uppercase text-blueGray-100 mb-1 text-xs font-semibold"
                      >
                        Overview
                      </h6>
                      <h2 class="text-white text-xl font-semibold">
                        Sales value
                      </h2>
                    </div>
                  </div>
                </div>
                <div class="p-4 flex-auto">
                  <!-- Chart -->
                  <div class="relative" style="height:350px">
                    <canvas id="line-chart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="w-full xl:w-4/12 px-4">
              <div
                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded"
              >
                <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
                  <div class="flex flex-wrap items-center">
                    <div class="relative w-full max-w-full flex-grow flex-1">
                      <h6
                        class="uppercase text-blueGray-400 mb-1 text-xs font-semibold"
                      >
                        Performance
                      </h6>
                      <h2 class="text-blueGray-700 text-xl font-semibold">
                        Total orders
                      </h2>
                    </div>
                  </div>
                </div>
                <div class="p-4 flex-auto">
                  <!-- Chart -->
                  <div class="relative" style="height:350px">
                    <canvas id="bar-chart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap mt-4">
            <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                  <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                      <h3 class="font-semibold text-base text-blueGray-700">
                        Page visits
                      </h3>
                    </div>
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                      <button
                        class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1"
                        type="button"
                        style="transition:all .15s ease"
                      >
                        See all
                      </button>
                    </div>
                  </div>
                </div>
                <div class="block w-full overflow-x-auto">
                  <!-- Projects table -->
                  <table class="items-center w-full bg-transparent border-collapse">
                    <thead>
                      <tr>
                        <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                          Page name
                        </th>
                        <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                          Visitors
                        </th>
                        <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                          Unique users
                        </th>
                        <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                          Bounce rate
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          /argon/
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          4,569
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          340
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <i class="fas fa-arrow-up text-emerald-500 mr-4"></i>
                          46,53%
                        </td>
                      </tr>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          /argon/index.html
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          3,985
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          319
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <i class="fas fa-arrow-down text-orange-500 mr-4"></i>
                          46,53%
                        </td>
                      </tr>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          /argon/charts.html
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          3,513
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          294
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <i class="fas fa-arrow-down text-orange-500 mr-4"></i>
                          36,49%
                        </td>
                      </tr>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          /argon/tables.html
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          2,050
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          147
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <i class="fas fa-arrow-up text-emerald-500 mr-4"></i>
                          50,87%
                        </td>
                      </tr>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          /argon/profile.html
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          1,795
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          190
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <i class="fas fa-arrow-down text-red-500 mr-4"></i>
                          46,53%
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="w-full xl:w-4/12 px-4">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                  <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                      <h3 class="font-semibold text-base text-blueGray-700">
                        Social traffic
                      </h3>
                    </div>
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                      <button
                        class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1"
                        type="button"
                        style="transition:all .15s ease"
                      >
                        See all
                      </button>
                    </div>
                  </div>
                </div>
                <div class="block w-full overflow-x-auto">
                  <!-- Projects table -->
                  <table class="items-center w-full bg-transparent border-collapse">
                    <thead class="thead-light">
                      <tr>
                        <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                          Referral
                        </th>
                        <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                          Visitors
                        </th>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                          style="min-width:140px"
                        ></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          Facebook
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          1,480
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <div class="flex items-center">
                            <span class="mr-2">60%</span>
                            <div class="relative w-full">
                              <div class="overflow-hidden h-2 text-xs flex rounded bg-red-200">
                                <div
                                  style="width:60%"
                                  class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          Facebook
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          5,480
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <div class="flex items-center">
                            <span class="mr-2">70%</span>
                            <div class="relative w-full">
                              <div class="overflow-hidden h-2 text-xs flex rounded bg-emerald-200">
                                <div
                                  style="width:70%"
                                  class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          Google
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          4,807
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <div class="flex items-center">
                            <span class="mr-2">80%</span>
                            <div class="relative w-full">
                              <div class="overflow-hidden h-2 text-xs flex rounded bg-purple-200">
                                <div
                                  style="width:80%"
                                  class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-500"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          Instagram
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          3,678
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <div class="flex items-center">
                            <span class="mr-2">75%</span>
                            <div class="relative w-full">
                              <div class="overflow-hidden h-2 text-xs flex rounded bg-lightBlue-200">
                                <div
                                  style="width:75%"
                                  class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-lightBlue-500"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                          twitter
                        </th>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          2,645
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                          <div class="flex items-center">
                            <span class="mr-2">30%</span>
                            <div class="relative w-full">
                              <div class="overflow-hidden h-2 text-xs flex rounded bg-orange-200">
                                <div
                                  style="width:30%"
                                  class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <span id="javascript-date" class="hidden"></span>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-dark py-6 sm:py-8 lg:py-10 mt-10">
      <div class="mx-auto max-w-screen-2xl px-4 md:px-8 w-5/6">
        <div class="mb-6 flex items-end justify-between gap-4">
          <h2 class="text-2xl font-bold dark:text-gray-100 lg:text-3xl">リンク</h2>
          <a href="#" class="inline-block rounded-lg border bg-white px-4 py-2 text-center text-sm font-semibold text-gray-500 outline-none ring-indigo-300 transition duration-100 hover:bg-gray-100 focus-visible:ring active:bg-gray-200 md:px-8 md:py-3 md:text-base">
            Show more
          </a>
        </div>
    
        <div class="grid gap-x-4 gap-y-6 sm:grid-cols-2 md:gap-x-6 lg:grid-cols-3 xl:grid-cols-5">
          <!-- 出退勤システム - start -->
          <div>
            <a target="_blank" href="https://e-timecard.systemd.co.jp:18443/WebTimeCard/Auth/Login?ReturnUrl=%2FWebTimeCard%2FHome%2FList" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
              <img src="{{ asset('/assets/image/tokei.png') }}" loading="lazy" alt="Photo by Austin Wade" class="object-contain h-full w-full  object-center transition duration-200 group-hover:scale-110" />
            </a>
    
            <div class="flex flex-col">
              <a target="_blank" href="https://e-timecard.systemd.co.jp:18443/WebTimeCard/Auth/Login?ReturnUrl=%2FWebTimeCard%2FHome%2FList" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">TimeCard</a>
            </div>
          </div>
          <!-- 出退勤システム - end -->
    
          <!-- サイボウズ - start -->
          <div>
              <a target="_blank" href="https://cybozu.systemd.co.jp/" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                  <img src="{{ asset('/assets/image/cybozu.png') }}" loading="lazy" alt="Photo by engin akyurt" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
              </a>
    
              <div class="flex flex-col">
                  <a target="_blank" href="https://cybozu.systemd.co.jp/" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">Cybozu</a>
              </div>
          </div>
          <!-- サイボウズ - end -->
          <!-- 郵送依頼 - start -->
          <div>
              <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                  <img src="{{ asset('/assets/image/mail.png') }}" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
              </a>
    
              <div class="flex flex-col">
                  <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">郵送依頼</a>
              </div>
          </div>
          <!-- 郵送依頼 - end -->
          <!-- どこキャビ - start -->
          <div>
              <a target="_blank" href="https://fwddoc.dococab.jp/fw/dfw?AGENT_DFW=https%3a%2f%2fb.dococab.jp%2fagt&path=%2fapp3%2fvbw%2findex.html&query=lf%3ddlv%252Frequest&tid=TID20230303161732393792A0-7fc9-e73fa880-agent_docab#dlv/request" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                  <img src="{{ asset('/assets/image/cabinet.png') }}" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
              </a>
      
              <div class="flex flex-col">
                  <a target="_blank" href="https://fwddoc.dococab.jp/fw/dfw?AGENT_DFW=https%3a%2f%2fb.dococab.jp%2fagt&path=%2fapp3%2fvbw%2findex.html&query=lf%3ddlv%252Frequest&tid=TID20230303161732393792A0-7fc9-e73fa880-agent_docab#dlv/request" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">どこキャビ</a>
              </div>
          </div>
          <!-- どこキャビ - end -->
  
    
          <!--制度変更情報 - start -->
          <div>
              <a target="_blank" href="http://getsserver:50001/wordpress/" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                  <img src="{{ asset('/assets/image/link.png') }}" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
              </a>
    
              <div class="flex flex-col">
                  <a target="_blank" href="http://getsserver:50001/wordpress/" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">制度変更ポータル</a>
              </div>
          </div>
          <!-- 制度変更情報 - end -->
          
          <!-- ナレッジスイート - start -->
          <div>
              <a target="_blank" href="https://gridy.jp/home" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                  <img src="{{ asset('/assets/image/link.png') }}" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
              </a>
      
              <div class="flex flex-col">
                  <a target="_blank" href="https://gridy.jp/home" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">knowledge suite</a>
              </div>
          </div>
          <!-- ナレッジスイート - end -->
  
          <!-- プロゲート - start -->
          <div>
              <a target="_blank" href="https://prog-8.com/dashboard" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                  <img src="{{ asset('/assets/image/progate.png') }}" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
              </a>
      
              <div class="flex flex-col">
                  <a target="_blank" href="https://prog-8.com/dashboard" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">Progate</a>
              </div>
          </div>
          <!-- プロゲート - end -->
  
          <!-- クラウドWiki - start -->
          <div>
              <a target="_blank" href="http://cloudunyo/wordpress/" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                  <img src="https://images.unsplash.com/photo-1552668693-d0738e00eca8?auto=format&q=75&fit=crop&crop=top&w=600&h=700" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-cover object-center transition duration-200 group-hover:scale-110" />
              </a>
      
              <div class="flex flex-col">
                  <a target="_blank" href="http://cloudunyo/wordpress/" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">クラウドWiki</a>
              </div>
          </div>
          <!-- product - end -->
          <!-- product - start -->
          <div>
              <a target="_blank" href="http://www.ntrsupport.jp/setbox/" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                  <img src="https://images.unsplash.com/photo-1552668693-d0738e00eca8?auto=format&q=75&fit=crop&crop=top&w=600&h=700" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-cover object-center transition duration-200 group-hover:scale-110" />
              </a>
      
              <div class="flex flex-col">
                  <a target="_blank" href="http://www.ntrsupport.jp/setbox/" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">NTR support</a>
              </div>
          </div>
          <!-- product - end -->  
  
          <!-- product - start -->
          <div>
              <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="group mb-2 block h-36 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                  <img src="https://images.unsplash.com/photo-1552668693-d0738e00eca8?auto=format&q=75&fit=crop&crop=top&w=600&h=700" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-cover object-center transition duration-200 group-hover:scale-110" />
              </a>
      
              <div class="flex flex-col">
                  <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">#</a>
              </div>
          </div>
          <!-- product - end -->    
        </div>
      </div>
    </div>
























    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
      charset="utf-8"
    ></script>
    <script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
    <script type="text/javascript">
      /* Sidebar - Side navigation menu on mobile/responsive mode */
      function toggleNavbar(collapseID) {
        document.getElementById(collapseID).classList.toggle("hidden");
        document.getElementById(collapseID).classList.toggle("bg-white");
        document.getElementById(collapseID).classList.toggle("m-2");
        document.getElementById(collapseID).classList.toggle("py-3");
        document.getElementById(collapseID).classList.toggle("px-6");
      }
      /* Function for dropdowns */
      function openDropdown(event, dropdownID) {
        let element = event.target;
        while (element.nodeName !== "A") {
          element = element.parentNode;
        }
        var popper = Popper.createPopper(element, document.getElementById(dropdownID), {
          placement: "bottom-end"
        });
        document.getElementById(dropdownID).classList.toggle("hidden");
        document.getElementById(dropdownID).classList.toggle("block");
      }


      (function() {
        /* Add current date to the footer */
        document.getElementById("javascript-date").innerHTML = new Date().getFullYear();
        /* Chart initialisations */
        /* Line Chart */
        var config = {
          type: "line",
          data: {
            labels: [
              "January",
              "February",
              "March",
              "April",
              "May",
              "June",
              "July"
            ],
            datasets: [
              {
                label: new Date().getFullYear(),
                backgroundColor: "#4c51bf",
                borderColor: "#4c51bf",
                data: [65, 78, 66, 44, 56, 67, 75],
                fill: false
              },
              {
                label: new Date().getFullYear() - 1,
                fill: false,
                backgroundColor: "#ed64a6",
                borderColor: "#ed64a6",
                data: [40, 68, 86, 74, 56, 60, 87]
              }
            ]
          },
          options: {
            maintainAspectRatio: false,
            responsive: true,
            title: {
              display: false,
              text: "Sales Charts",
              fontColor: "white"
            },
            legend: {
              labels: {
                fontColor: "white"
              },
              align: "end",
              position: "bottom"
            },
            tooltips: {
              mode: "index",
              intersect: false
            },
            hover: {
              mode: "nearest",
              intersect: true
            },
            scales: {
              xAxes: [
                {
                  ticks: {
                    fontColor: "rgba(255,255,255,.7)"
                  },
                  display: true,
                  scaleLabel: {
                    display: false,
                    labelString: "Month",
                    fontColor: "white"
                  },
                  gridLines: {
                    display: false,
                    borderDash: [2],
                    borderDashOffset: [2],
                    color: "rgba(33, 37, 41, 0.3)",
                    zeroLineColor: "rgba(0, 0, 0, 0)",
                    zeroLineBorderDash: [2],
                    zeroLineBorderDashOffset: [2]
                  }
                }
              ],
              yAxes: [
                {
                  ticks: {
                    fontColor: "rgba(255,255,255,.7)"
                  },
                  display: true,
                  scaleLabel: {
                    display: false,
                    labelString: "Value",
                    fontColor: "white"
                  },
                  gridLines: {
                    borderDash: [3],
                    borderDashOffset: [3],
                    drawBorder: false,
                    color: "rgba(255, 255, 255, 0.15)",
                    zeroLineColor: "rgba(33, 37, 41, 0)",
                    zeroLineBorderDash: [2],
                    zeroLineBorderDashOffset: [2]
                  }
                }
              ]
            }
          }
        };
        var ctx = document.getElementById("line-chart").getContext("2d");
        window.myLine = new Chart(ctx, config);

        /* Bar Chart */
        config = {
          type: "bar",
          data: {
            labels: [
              "January",
              "February",
              "March",
              "April",
              "May",
              "June",
              "July"
            ],
            datasets: [
              {
                label: new Date().getFullYear(),
                backgroundColor: "#ed64a6",
                borderColor: "#ed64a6",
                data: [30, 78, 56, 34, 100, 45, 13],
                fill: false,
                barThickness: 8
              },
              {
                label: new Date().getFullYear() - 1,
                fill: false,
                backgroundColor: "#4c51bf",
                borderColor: "#4c51bf",
                data: [27, 68, 86, 74, 10, 4, 87],
                barThickness: 8
              }
            ]
          },
          options: {
            maintainAspectRatio: false,
            responsive: true,
            title: {
              display: false,
              text: "Orders Chart"
            },
            tooltips: {
              mode: "index",
              intersect: false
            },
            hover: {
              mode: "nearest",
              intersect: true
            },
            legend: {
              labels: {
                fontColor: "rgba(0,0,0,.4)"
              },
              align: "end",
              position: "bottom"
            },
            scales: {
              xAxes: [
                {
                  display: false,
                  scaleLabel: {
                    display: true,
                    labelString: "Month"
                  },
                  gridLines: {
                    borderDash: [2],
                    borderDashOffset: [2],
                    color: "rgba(33, 37, 41, 0.3)",
                    zeroLineColor: "rgba(33, 37, 41, 0.3)",
                    zeroLineBorderDash: [2],
                    zeroLineBorderDashOffset: [2]
                  }
                }
              ],
              yAxes: [
                {
                  display: true,
                  scaleLabel: {
                    display: false,
                    labelString: "Value"
                  },
                  gridLines: {
                    borderDash: [2],
                    drawBorder: false,
                    borderDashOffset: [2],
                    color: "rgba(33, 37, 41, 0.2)",
                    zeroLineColor: "rgba(33, 37, 41, 0.15)",
                    zeroLineBorderDash: [2],
                    zeroLineBorderDashOffset: [2]
                  }
                }
              ]
            }
          }
        };
        ctx = document.getElementById("bar-chart").getContext("2d");
        window.myBar = new Chart(ctx, config);
      })();
    </script>
  </body>

</x-app-layout>