<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

<style>
    .fc-col-header-cell {
    color: #ffffff !important;
    background-color: #3e4858 !important;
    }

    .fc-col-header-cell a {
    color: #ffffff !important;
    }
</style>


<div class="max-w-full md:ml-14 mx-auto p-4 dark:bg-gray-800 bg-white rounded-lg shadow-xl mb-4">
    <div id="calendar" class="text-sm dark:text-white text-gray-600"></div>
</div>


<!-- モーダル -->
<div id="eventModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xl max-w-md w-full">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">予定の登録</h2>
        <form id="eventForm" class="space-y-4">
            <div>
                <label for="eventTitle" class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">タイトル</label>
                <input type="text" id="eventTitle" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            </div>
            
            <div>
                <label for="eventDate" class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">日付</label>
                <input type="text" id="eventDate" readonly class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-white">
            </div>
            
            <div>
                <label for="eventDescription" class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">詳細</label>
                <textarea id="eventDescription" rows="3" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"></textarea>
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" id="eventAllDay" class="mr-2 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="eventAllDay" class="text-sm font-medium text-gray-700 dark:text-gray-300">終日</label>
            </div>
            
            <div id="timeInputs" class="space-y-3">
                <div>
                    <label for="eventStartTime" class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">開始時間</label>
                    <input type="time" id="eventStartTime" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
                
                <div>
                    <label for="eventEndTime" class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">終了時間</label>
                    <input type="time" id="eventEndTime" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" id="cancelButton" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg transition-colors">キャンセル</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">保存</button>
            </div>
        </form>
    </div>
</div>



<script src="{{ asset('assets/js/dashboard/fullcalendar.js') }}"></script>
