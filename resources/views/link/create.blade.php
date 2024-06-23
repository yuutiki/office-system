<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                所属別リンク登録
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('link.index')}}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form method="post" action="{{route('link.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="mt-2 p-4 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="md:flex items-center">
                        <div class="w-full flex flex-col">
                        <label for="display_name" class="font-semibold dark:text-gray-100 leading-none mt-2">表示名</label>
                        <input type="text" name="display_name" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="display_name" value="{{old('display_name')}}" required>
                        </div>
                    </div>
                    @error('display_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                    <div class="md:flex items-center">
                        <div class="w-full flex flex-col">
                        <label for="url" class="font-semibold dark:text-gray-100 leading-none mt-2">URL</label>
                        <input type="text" name="url" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="url" value="{{old('url')}}" required>
                        </div>
                    </div>
                    @error('url')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                    
                    <div class="grid gap-4 mb-4 md:grid-cols-2 ">
                        <div class="w-full flex flex-col">
                            <label for="affiliation2_id" class="font-semibold dark:text-gray-100 leading-none mt-2">事業部</label>
                            <select name="affiliation2_id" class=" w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="affiliation2_id" value="{{old('affiliation2_id')}}" required>
                                @foreach($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}">{{ $affiliation2->affiliation2_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('affiliation2_id')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                        <div class="md:flex items-center">
                            <div class="w-full flex flex-col">
                            <label for="display_order" class="font-semibold dark:text-gray-100 leading-none mt-2">表示順</label>
                            <input type="number" name="display_order" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="display_order" value="{{old('display_order')}}" required>
                            </div>
                        </div>
                        @error('display_order')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <x-primary-button class="mt-2 mb-2">
                    新規登録する
                </x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>