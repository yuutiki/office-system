<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            預託情報の個別表示
        </h2>
        <div tubindex="0" class="flex flex-row-reverse">
            <x-general-button class="mt-4" onclick="location.href='{{route('keepfile.index', $keepfile)}}'">
                一覧へ
            </x-general-button>
        </div>
        <x-message :message="session('message')" />
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <div class="px-10 mt-4">

                <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <h1 class="text-lg text-gray-700 font-semibold">
                            {{ $keepfile->project_num }}
                            {{-- <a href="{{route('keepfile.edit', $keepfile)}}">
                                <x-primary-button class="bg-teal-700 float-right">編集</x-primary-button>
                            </a> --}}
                            {{-- <x-general-button class="mt-4 float-right" onclick="location.href='{{route('keepfile.edit', $keepfile)}}'">
                                編集
                            </x-general-button> --}}
                        </h1>
                        <hr class="w-full">
                        <div class="mt-4 text-gtay-600 font-semibold">ステータス</div>
                        
                        @if($keepfile->is_finished == "0")
                            <p class="ml-4 text-gray-600 py-1 whitespace-pre-line">未返却</p>
                        @else
                            <p class="ml-4 text-gray-600 py-1 whitespace-pre-line">返却済</p>
                        @endif
                        
                        <div class="mt-4 text-gtay-600 font-semibold">顧客名</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line">{{$keepfile->clientname}}</p>
                        <div class="mt-4 text-gtay-600 font-semibold">用途</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line">{{$keepfile->purpose}}</p>
                        <div class="mt-4 text-gtay-600 font-semibold">預託日</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line">{{$keepfile->keep_at}}</p>
                        <div class="mt-4 text-gtay-600 font-semibold">返却日</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line">{{$keepfile->return_at}}</p>
                        <div class="mt-4 text-gtay-600 font-semibold">備考</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line">{{$keepfile->memo}}</p>
                        <div class="text-sm font-semibold flex flex-row-reverse">
                            <p> {{ $keepfile->user->name }} • {{$keepfile->created_at->diffForHumans()}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>