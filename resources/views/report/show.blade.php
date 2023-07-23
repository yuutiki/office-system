<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                営業報告確認
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('report.index')}}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div class="md:w-4/6 flex justify-center md:mx-auto mt-8 ">
        {{-- <div class="mx-4 sm:p-8"> --}}
            {{-- <div class="px-10 mt-4"> --}}
                <div class="bg-white dark:bg-gray-600 dark:text-white w-full  rounded-md px-10 sm:px-4 py-4 shadow-lg hover:shadow-2xl transition duration-500">
                        <p class="text-lg text-gray-700 dark:text-white font-semibold inline-flex whitespace-nowrap">
                            {{ $report->type }}
                        </p>
                        <p class="text-lg text-gray-700 dark:text-white font-semibold inline-flex whitespace-nowrap">
                            ：{{ $report->title }}
                        </p>
                        <hr class="w-full">

                        <div class="flex justify-normal mb-2 flex-wrap">
                            <div class="">
                                <div class="mt-3 text-gtay-600 font-semibold text-xs whitespace-nowrap">顧客番号</div>
                                <p class="text-gray-600 dark:text-white whitespace-nowrap text-sm">{{$report->client->client_num}}</p>
                            </div>
                            <div class="mx-6">
                                <div class="mt-3 text-gtay-600 font-semibold text-xs whitespace-nowrap">顧客名称</div>
                                <p class="text-gray-600 dark:text-white whitespace-nowrap text-sm">{{$report->client->client_name}}</p>
                            </div>
                            <div class="mx-6">
                                <div class="mt-3 text-gtay-600 font-semibold text-xs whitespace-nowrap">取引状態</div>
                                <p class="text-gray-600 dark:text-white whitespace-nowrap text-sm">{{$report->client->tradeStatus->name}}</p>
                            </div>
                            <div class="mx-6">
                                <div class="mt-3 text-gtay-600 font-semibold text-xs whitespace-nowrap">顧客担当者</div>
                                <p class="text-gray-600 dark:text-white whitespace-nowrap text-sm">{{$report->client_representative}}</p>
                            </div>
                        </div>


                        <hr class="my-2">

                        <div class="flex">
                            <div>
                                <div class="mt-1 text-gtay-600 font-semibold text-xs whitespace-nowrap">対応日付</div>
                                <p class="text-gray-600 dark:text-white whitespace-nowrap text-sm">{{$report->contact_at}}</p>
                            </div>
                            
                            <div class="ml-8">
                                <div class="mt-1 text-gtay-600 font-semibold text-xs whitespace-nowrap">対応形式</div>
                                <p class="text-gray-600 dark:text-white whitespace-nowrap text-sm">{{$report->contact_type}}</p>
                            </div>
                        </div>

                        <div>
                            <div class="mt-3 text-gtay-600 font-semibold text-xs whitespace-nowrap">報告内容</div>
                            <p class="text-gray-600 dark:text-white text-sm dark:border-gray-400  border-2 rounded-md p-1 mt-1">{!! nl2br(e($report->content)) !!}</p>
                        </div>
                        
                        <div class="mb-4">
                            <div class="mt-3 text-gtay-600 font-semibold text-xs whitespace-nowrap text-red-600 dark:text-red-500">特記事項</div>
                            <p class="text-gray-600 dark:text-white text-sm dark:border-gray-400 border-2 rounded-md p-1 mt-1">{!! nl2br(e($report->notice)) !!}</p>
                        </div> 

                        <div class="font-semibold text-xs whitespace-nowrap flex flex-row-reverse">
                            <p> {{ $report->reporter->name }} • {{$report->created_at->diffForHumans()}}</p>
                        </div>
                </div>
            {{-- </div> --}}
        {{-- </div> --}}
    </div>

    <div class="container max-w-7xl mx-auto mt-8">
        <div class="w-full mx-auto">
            <h3 class="mt-8 ml-2 text-lg font-semibold dark:text-white">コメント</h3>
            <hr class="my-2">
    
            @foreach ($report->comments as $comment)
                <div class="bg-white shadow-md rounded-md overflow-hidden mt-4">
                    <div class="px-4 py-3 bg-gray-100 flex justify-between">
                        <strong class="text-blue-700">{{ $comment->user->name }}</strong>
                        <div>{{ $comment->created_at }}</div>
                    </div>
                    <div class="px-4 py-3">
                        <p class="text-gray-800">{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
    
            {{-- <div class="bg-white shadow-md rounded-md overflow-hidden mt-4"> --}}
                <div class="py-3 mt-8">
                    <form method="POST" action="{{ route('comment.store', $report->id) }}">
                        @csrf
                        
                        <label for="chat" class="sr-only">Your message</label>
                        <div class="flex items-center pr-1 pl-3 py-2 rounded-md bg-gray-50 dark:bg-gray-700">
                            {{-- <button type="button" class="inline-flex justify-center p-2 text-gray-500 rounded-md cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                    <path fill="currentColor" d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z"/>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 1H2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z"/>
                                </svg>
                                <span class="sr-only">Upload image</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded-md cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.408 7.5h.01m-6.876 0h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM4.6 11a5.5 5.5 0 0 0 10.81 0H4.6Z"/>
                                </svg>
                                <span class="sr-only">Add emoji</span>
                            </button> --}}
                            <textarea id="chat" rows="2" name="content" class="block mx-1 p-2.5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="コメント..."></textarea>
                                <button type="submit" class="inline-flex justify-center p-1.5 text-blue-600 rounded-mdll cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                                    <svg class="w-5 h-5 rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z"/>
                                    </svg>
                                    <span class="sr-only">Send message</span>
                                </button>
                        </div>

                    </form>
                </div>
            {{-- </div> --}}
        </div>
    </div>
    
</x-app-layout>
