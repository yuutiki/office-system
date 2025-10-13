document.addEventListener('DOMContentLoaded', function () {
    const dial = document.getElementById('dial');
    const speedDial = document.getElementById('speed-dial-button');
    const line1 = document.getElementById('line1');
    const line2 = document.getElementById('line2');
    const line3 = document.getElementById('line3');

    if (!dial || !speedDial) return;

    // トグル処理
    dial.addEventListener('click', function () {
        const isActive = dial.classList.toggle('active');
        speedDial.classList.toggle('show');

        // aria-expanded 更新
        dial.setAttribute('aria-expanded', isActive ? 'true' : 'false');

        if (isActive) {
            // open state
            line1.classList.remove('top-[19px]', 'left-3');
            line1.classList.add('top-[50%]', 'translate-y-[0px]', 'rotate-[-45deg]', 'w-[50%]', 'left-[13.7px]');

            line2.classList.add('opacity-0');

            line3.classList.remove('top-[35px]', 'left-3');
            line3.classList.add('top-[50%]', '-translate-y-[0px]', 'rotate-[45deg]', 'w-[50%]', 'left-[13.7px]');
        } else {
            // close state
            line1.classList.remove('top-[50%]', 'translate-y-[0px]', 'rotate-[-45deg]', 'w-[50%]', 'left-[13.7px]');
            line1.classList.add('top-[19px]', 'left-3');

            line2.classList.remove('opacity-0');

            line3.classList.remove('top-[50%]', '-translate-y-[0px]', 'rotate-[45deg]', 'w-[50%]', 'left-[13.7px]');
            line3.classList.add('top-[35px]', 'left-3');
        }
    });

    // speed-dial の各ボタンをクリックしたら data-href に飛ぶ（JS側でナビゲート）
    speedDial.addEventListener('click', function (e) {
        const btn = e.target.closest('button[data-href]');
        if (!btn) return;
        const href = btn.getAttribute('data-href');
        if (!href) return;

        // 必要ならここで確認ダイアログやトラッキングを入れられる
        window.location.href = href;
    });

    // スクロール時：ページ下部で自動的に閉じる（表示は CSS の show を外す）
    function handleScroll() {
        const scrollThreshold = 1;
        const isBottom = (window.innerHeight + window.scrollY) >= document.body.offsetHeight - scrollThreshold;
        if (isBottom) {
            speedDial.classList.remove('show');
            dial.classList.remove('active');
            dial.setAttribute('aria-expanded', 'false');
            // ハンバーガー戻す（簡易）
            line1.classList.remove('top-[50%]', 'translate-y-[0px]', 'rotate-[-45deg]', 'w-[50%]', 'left-[13.7px]');
            line1.classList.add('top-[19px]', 'left-3');
            line2.classList.remove('opacity-0');
            line3.classList.remove('top-[50%]', '-translate-y-[0px]', 'rotate-[45deg]', 'w-[50%]', 'left-[13.7px]');
            line3.classList.add('top-[35px]', 'left-3');
        }
    }

    window.addEventListener('scroll', handleScroll, { passive: true });
});
