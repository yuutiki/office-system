<div id="rap" class="fixed bottom-11 right-6 z-50">
    <div id="speed-dial-button" class="flex-col items-center mb-4 space-y-2 speed-dial-button" aria-hidden="true">
        <button type="button" data-href="{{ route('supports.create') }}" class="speed-dial-item w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400 shadow-xl">
            <span class="block mb-px text-xs font-medium">サポート</span>
        </button>

        <button type="button" data-href="{{ route('reports.create') }}" class="speed-dial-item w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400 shadow-xl">
            <span class="block mb-px text-xs font-medium">営業報告</span>
        </button>

        <button type="button" data-href="{{ route('projects.create') }}" class="speed-dial-item w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400 shadow-xl">
            <span class="block mb-px text-xs font-medium">案件</span>
        </button>

        <button type="button" data-href="{{ route('keepfiles.create') }}" class="speed-dial-item w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400 shadow-xl">
            <span class="block mb-px text-xs font-medium">預託情報</span>
        </button>

        <button type="button" data-href="{{ route('client-contacts.create') }}" class="speed-dial-item w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400 shadow-xl">
            <span class="block mb-px text-xs font-medium">顧客<br>担当者</span>
        </button>

        <button type="button" data-href="{{ route('clients.create') }}" class="speed-dial-item w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400 shadow-xl">
            <span class="block mb-px text-xs font-medium">顧客</span>
        </button>

        <button type="button" data-href="{{ route('dashboard') }}" class="speed-dial-item w-[56px] h-[56px] text-gray-500 bg-white rounded-full border border-gray-200 dark:border-gray-600 hover:text-gray-900 dark:hover:text-white dark:text-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400 shadow-xl">
            <span class="block mb-px text-xs font-medium">Home</span>
        </button>
    </div>

    <button type="button" id="dial" class="relative w-14 h-14 bg-blue-600 rounded-full focus:outline-none" aria-expanded="false" aria-label="メニューを開く">
        <span class="block absolute left-4 top-[19px] w-6 h-0.5 bg-white transition-all duration-300 ease-in-out" id="line1"></span>
        <span class="block absolute left-4 top-[27px] w-4 h-0.5 bg-white transition-all duration-300 ease-in-out" id="line2"></span>
        <span class="block absolute left-4 top-[35px] w-2 h-0.5 bg-white transition-all duration-300 ease-in-out" id="line3"></span>
    </button>
</div>
