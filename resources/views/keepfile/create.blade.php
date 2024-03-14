<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createKeepfile') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form method="post" action="{{route('keepfile.store')}}" enctype="multipart/form-data">
                @csrf
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_finished" id="is_finished" value="0">
                    <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">完了</span>
                </label>
                <div class="grid gap-4 my-4 md:grid-cols-2">
                    <div>
                        <div class="md:flex items-center">
                            <div class="w-full flex flex-col">
                            <label for="project_num" class="font-semibold dark:text-white text-red-700 leading-none mt-4">プロジェクト№<span class="text-red-500"> *</span></label>
                            <input type="text" name="project_num" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="project_num" value="{{old('project_num')}}" placeholder="例）9999000100" required>
                            </div>
                        </div>
                        @error('project_num')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                   <div>
                        <div class="w-full flex flex-col">
                            <label for="clientname" class="font-semibold dark:text-white text-red-700 leading-none mt-4">顧客名称<span class="text-red-500"> *</span></label>
                            <input type="text" name="clientname" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="clientname" value="{{old('clientname')}}" placeholder="例）学校法人  〇〇大学" required>
                        </div>
                        @error('clientname')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                   </div>
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="keep_at" class="font-semibold dark:text-white text-red-700 leading-none mt-4">預託日<span class="text-red-500"> *</span></label>
                            <input type="date" min="2000-01-01" max="2100-12-31" name="keep_at" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="keep_at" value="{{old('keep_at')}}" required>
                        </div>
                        @error('keep_at')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="return_at" class="font-semibold dark:text-white text-red-700 leading-none mt-4">消去予定日<span class="text-red-500"> *</span></label>
                            <input type="date" min="2000-01-01" max="2100-12-31" name="return_at" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="return_at" value="{{old('return_at')}}" required>
                        </div>
                        @error('return_at')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="purpose" class="font-semibold dark:text-white text-red-700 leading-none mt-4">用途<span class="text-red-500"> *</span></label>
                        <input type="text" name="purpose" class="w-auto py-1 placeholder-gray-500 border border-gray-300 rounded mt-1" id="purpose" value="{{old('purpose')}}" placeholder="例）バージョンアップ" required>
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
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-8">備考</label>
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



            generatePdf
            <button></button>
            <iframe src="{{ route('pdf.generate') }}" style="width:600px; height:500px;"></iframe>

            <div class="w-full max-w-[16rem]">
                <div class="relative">
                    <label for="copy-button" class="sr-only">Label</label>
                    <input id="copy-target" type="text" value="112659-C-C01-0001" class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none" readonly>
                    <button id="copy-button" data-tooltip-target="tooltip-copy-copy-button" class="absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2 inline-flex items-center justify-center">
                        <span id="default-icon">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                            </svg>
                        </span>
                        <span id="success-icon" class="hidden inline-flex items-center">
                            <svg class="w-3.5 h-3.5 text-blue-700 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                            </svg>
                        </span>
                    </button>
                    
                    <div id="tooltip-copy-copy-button" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        <span id="default-tooltip-message">クリップボードにコピー</span>
                        <span id="success-tooltip-message" class="hidden">コピー完了!</span>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

    <script>
    document.getElementById("copy-button").addEventListener("click", copyToClipboard);

async function copyToClipboard() {
    // コピー対象のテキストを取得
    const textToCopy = document.getElementById("copy-target").value;

    // ボタンを無効にする
    document.getElementById("copy-button").disabled = true;

    // 成功時のアイコンを表示
    document.getElementById("default-icon").classList.add("hidden");
    document.getElementById("success-icon").classList.remove("hidden");

    // 成功時のツールチップメッセージを表示
    document.getElementById("default-tooltip-message").classList.add("hidden");
    document.getElementById("success-tooltip-message").classList.remove("hidden");

    // Clipboard APIを使用してクリップボードにコピー
    try {
        await navigator.clipboard.writeText(textToCopy);

        // 成功アイコンとツールチップメッセージを一定時間後に元に戻す
        setTimeout(() => {
            document.getElementById("default-icon").classList.remove("hidden");
            document.getElementById("success-icon").classList.add("hidden");
            document.getElementById("copy-button").disabled = false;

            document.getElementById("default-tooltip-message").classList.remove("hidden");
            document.getElementById("success-tooltip-message").classList.add("hidden");
        }, 3000); // 3000ミリ秒 = 3秒後
    } catch (error) {
        console.error("コピーに失敗しました:", error);
        alert("コピーに失敗しました。");
        document.getElementById("copy-button").disabled = false;
    }
}
    </script>
</x-app-layout>