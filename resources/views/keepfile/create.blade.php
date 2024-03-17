<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createKeepfile') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="post" action="{{route('keepfile.store')}}" enctype="multipart/form-data">
            @csrf


            <label class="relative inline-flex items-center cursor-pointer mt-6">
                <input type="hidden" name="is_finished" id="is_finished" value="0">
                <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">完了</span>
            </label>

            <div class="grid gap-4 my-4 md:grid-cols-2">
                <div>
                    <div class="md:flex items-center">
                        <div class="w-full flex flex-col">
                        <label for="project_num" class="dark:text-white text-red-700 leading-none text-sm">プロジェクト№<span class="text-red-500"> *</span></label>
                        <input type="text" name="project_num" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="project_num" value="{{old('project_num')}}" placeholder="例）9999000100" required>
                        </div>
                    </div>
                    @error('project_num')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="clientname" class="dark:text-white text-red-700 leading-none text-sm">顧客名称<span class="text-red-500"> *</span></label>
                        <input type="text" name="clientname" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="clientname" value="{{old('clientname')}}" placeholder="例）学校法人  〇〇大学" required>
                    </div>
                    @error('clientname')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="keep_at" class="dark:text-white text-red-700 leading-none text-sm">預託日<span class="text-red-500"> *</span></label>
                        <input type="date" min="2000-01-01" max="2100-12-31" name="keep_at" class="input-primary" id="keep_at" value="{{old('keep_at')}}" required>
                    </div>
                    @error('keep_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="return_at" class="dark:text-white text-red-700 leading-none text-sm">消去予定日<span class="text-red-500"> *</span></label>
                        <input type="date" min="2000-01-01" max="2100-12-31" name="return_at" class="input-primary" id="return_at" value="{{old('return_at')}}" required>
                    </div>
                    @error('return_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div>
                <div class="w-full flex flex-col">
                    <label for="purpose" class="dark:text-white text-red-700 leading-none text-sm">用途<span class="text-red-500"> *</span></label>
                    <input type="text" name="purpose" class="input-primary" id="purpose" value="{{old('purpose')}}" placeholder="例）バージョンアップ" required>
                </div>
                @error('purpose')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div class="mt-8">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="pdf_file_help">
                        PDF (最大 1024KB)
                    </p>
                    <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" class="block w-full text-sm text-gray-900 border border-gray-300 rounded cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help">
                </div>
                @error('pdf_file')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <div class="w-full flex flex-col">
                    <label for="memo" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">備考</label>
                    <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-500" id="memo" value="{{old('memo')}}" cols="30" rows="5" data-auto-resize="true" placeholder="例）預託期限が来たため延長しました。"></textarea>
                </div>           
                @error('memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <x-primary-button class="mt-4 mb-4">
                新規登録する
            </x-primary-button>
        </form>
    </div>

    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
</x-app-layout>