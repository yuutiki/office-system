document.addEventListener('DOMContentLoaded', function () {
  // 祝日の定義（背景色のみ）
  const holidays = [
    {
      title: '憲法記念日', // タイトルは内部管理用
      start: '2025-05-03',
      display: 'background',
      backgroundColor: 'rgba(239, 68, 68, 0.2)',  // 薄い赤色
      allDay: true
    },
    {
      title: 'みどりの日', // タイトルは内部管理用
      start: '2025-05-04',
      display: 'background',
      backgroundColor: 'rgba(239, 68, 68, 0.2)',  // 薄い赤色
      allDay: true
    },
    {
      title: 'こどもの日', // タイトルは内部管理用
      start: '2025-05-05',
      display: 'background',
      backgroundColor: 'rgba(239, 68, 68, 0.2)',  // 薄い赤色
      allDay: true
    }
  ];
  
  // モーダル関連の要素
  const modal = document.getElementById('eventModal');
  const form = document.getElementById('eventForm');
  const titleInput = document.getElementById('eventTitle');
  const dateInput = document.getElementById('eventDate');
  const descriptionInput = document.getElementById('eventDescription');
  const allDayCheckbox = document.getElementById('eventAllDay');
  const timeInputs = document.getElementById('timeInputs');
  const startTimeInput = document.getElementById('eventStartTime');
  const endTimeInput = document.getElementById('eventEndTime');
  const cancelButton = document.getElementById('cancelButton');
  
  // 予定の日付データを保持する変数
  let selectedInfo = null;

  const calendarEl = document.getElementById('calendar');
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    height: 'auto',
    aspectRatio: 1.5,
    locale: 'ja', // 日本語対応
    buttonText: {
      today: '今日',
      month: '月',
      week: '週',
      day: '日'
    },
    // dayCellContent: function(e) {
    //     e.dayNumberText = e.dayNumberText.replace('日', '');
    // },
    headerToolbar: {
      left: 'dayGridMonth,timeGridWeek',
      center: 'prev,title,next',
      right: 'today'
    },
    dayMaxEvents: true,
    firstDay: 0,
    editable: true, // イベントのドラッグ＆ドロップを有効化
    selectable: true, // 日付の選択を有効化
    selectMirror: true, // 選択中のプレビューを表示
    eventTimeFormat: {
      hour: '2-digit',
      minute: '2-digit',
      meridiem: false,
      hour12: false
    },
    // 祝日の背景のみをイベントに追加
    events: holidays,
    // 日付がクリックされたときの処理
    select: function(info) {
      // 選択した日付情報を保存
      selectedInfo = info;
      
      // モーダルのフォームをリセット
      form.reset();
      
      // 日付を表示
      const dateObj = new Date(info.startStr);
      const formattedDate = dateObj.getFullYear() + '年' + 
                          (dateObj.getMonth() + 1) + '月' + 
                          dateObj.getDate() + '日';
      dateInput.value = formattedDate;
      
      // デフォルトで終日にチェック
      allDayCheckbox.checked = true;
      timeInputs.classList.add('hidden');
      
      // モーダルを表示
      modal.classList.remove('hidden');
      modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');

    },
    // イベントがクリックされたときの処理
    eventClick: function(info) {
      // 背景イベントはクリックできないので、
      // このハンドラーは通常の予定イベントのみ処理
      if (confirm(`「${info.event.title}」の予定を削除しますか？`)) {
        info.event.remove();
      }
    },
    // Tailwindを適用するためのカスタマイズ
    viewDidMount: function() {
      applyCustomStyles();
    }
  });
  calendar.render();
  
  // 終日チェックボックスのイベントリスナー
  allDayCheckbox.addEventListener('change', function() {
    if (this.checked) {
      timeInputs.classList.add('hidden');
    } else {
      timeInputs.classList.remove('hidden');
    }
  });
  
  // フォーム送信処理
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // 入力値を取得
    const title = titleInput.value;
    const description = descriptionInput.value;
    const isAllDay = allDayCheckbox.checked;
    
    if (title) {
      // 予定を追加
      const eventData = {
        title: title,
        start: selectedInfo.startStr,
        end: selectedInfo.endStr,
        allDay: isAllDay,
        backgroundColor: '#a855f7', // bg-purple-500
        borderColor: '#9333ea', // bg-purple-600
        extendedProps: {
          description: description
        }
      };
      
      // 終日でない場合は時間を設定
      if (!isAllDay && startTimeInput.value) {
        // 日付と時間を結合
        const startDateTime = selectedInfo.startStr + 'T' + startTimeInput.value + ':00';
        eventData.start = startDateTime;
        
        if (endTimeInput.value) {
          const endDateTime = selectedInfo.endStr + 'T' + endTimeInput.value + ':00';
          eventData.end = endDateTime;
        }
        
        eventData.allDay = false;
      }
      
      calendar.addEvent(eventData);
    }
    
    // モーダルを閉じる
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');

    calendar.unselect();
  });
  
  // キャンセルボタン
  cancelButton.addEventListener('click', function() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');

    calendar.unselect();
  });
  
    // モーダル外クリックでモーダルを閉じる
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');

            calendar.unselect();
        }
    });
  
  // スタイルを適用する関数
  function applyCustomStyles() {
    // 曜日ヘッダーの背景色を変更
    document.querySelectorAll('.fc-col-header-cell').forEach(el => {
      el.classList.add('bg-[#3e4858]', 'text-white');
    });
    
    // ボーダーカラーを調整
    document.querySelectorAll('.fc-theme-standard td, .fc-theme-standard th').forEach(el => {
      el.classList.add('border-opacity-20', 'border-white');
    });
    
    // ヘッダーボタンのスタイル
    document.querySelectorAll('.fc-button-primary').forEach(el => {
    el.classList.remove('fc-button-primary');
    el.style.backgroundColor = '#6366f1'; // indigo-500
    el.style.color = '#fff';              // text-white
    el.style.border = '1px solid #4338ca'; // border-indigo-700
    el.classList.add('hover:bg-indigo-600', 'px-4', 'py-2', 'rounded', 'transition-colors');
    });

    document.querySelectorAll('.fc-toolbar-chunk').forEach(el => {
    el.classList.add('flex', 'items-center', 'gap-2',);
    });
    document.querySelectorAll('.fc-toolbar-title').forEach(el => {
    el.classList.add('inline-block', );
    });
    
    // 今日の日付のスタイル
    const today = document.querySelector('.fc-day-today');
    if (today) {
      today.classList.add('bg-blue-900', 'bg-opacity-30');
    }
    
    // ヘッダーツールバーのマージン
    document.querySelector('.fc-header-toolbar').classList.add('mb-4');
    
    // ホバー効果を追加
    document.querySelectorAll('.fc-daygrid-day').forEach(el => {
      // マウスオーバー時の背景色変更
      el.addEventListener('mouseenter', function() {
        // すでに今日の日付や祝日でない場合にのみ適用
        if (!this.classList.contains('fc-day-today') && 
            !this.querySelector('.fc-daygrid-bg-harness')) {
          this.classList.add('dark:bg-gray-700', 'bg-blue-200');
        } else if (this.classList.contains('fc-day-today')) {
          // 今日の日付の場合は少し濃い青色に
          this.classList.add('bg-blue-800');
          this.classList.remove('bg-blue-900', 'bg-opacity-30');
        }
      });
      
      // マウスアウト時に元に戻す
      el.addEventListener('mouseleave', function() {
        if (!this.classList.contains('fc-day-today')) {
          this.classList.remove('dark:bg-gray-700', 'bg-blue-200');
        } else {
          // 今日の日付の場合は元の色に戻す
          this.classList.remove('bg-blue-800');
          this.classList.add('bg-blue-900', 'bg-opacity-30');
        }
      });
    });
  }
  
  // 初期レンダリング後に一度だけスタイルを適用
  setTimeout(applyCustomStyles, 50);
});