document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("pieChart").getContext("2d");

    // ページ読み込み時に現在のモードを判定
    const isDarkMode = document.documentElement.classList.contains("dark");

    // ラベルの色をモードに応じて設定
    const getLabelColor = () => isDarkMode ? "#E5E7EB" : "#374151"; // Tailwind: dark:text-gray-200 / text-gray-700
    const getTooltipBackground = () => isDarkMode ? "rgba(31,41,55,0.9)" : "rgba(255,255,255,0.9)"; // dark:bg-gray-800 / bg-white
    const getTooltipTextColor = () => isDarkMode ? "#F9FAFB" : "#111827"; // dark:text-gray-100 / text-gray-900

    // Chart.js グラフ生成
    const pieChart = new Chart(ctx, {
        type: "pie",
        data: {
            labels: ["オンプレミス", "プライベートクラウド", "パブリッククラウド"],
            datasets: [{
                label: "利用形態",
                data: [45, 30, 25],
                backgroundColor: [
                    "rgba(59, 130, 246, 0.7)",   // 青
                    "rgba(16, 185, 129, 0.7)",   // 緑
                    "rgba(245, 158, 11, 0.7)",   // オレンジ
                ],
                borderColor: [
                    "rgba(59, 130, 246, 1)",
                    "rgba(16, 185, 129, 1)",
                    "rgba(245, 158, 11, 1)",
                ],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "bottom",
                    labels: {
                        color: getLabelColor(), // モードに応じて文字色を設定
                        padding: 15,
                        font: { size: 14 }
                    }
                },
                tooltip: {
                    backgroundColor: getTooltipBackground(),
                    titleColor: getTooltipTextColor(),
                    bodyColor: getTooltipTextColor(),
                    callbacks: {
                        label: function (context) {
                            return `${context.label}: ${context.raw} 件`;
                        }
                    }
                }
            }
        }
    });

    // ダークモード切り替え時にグラフを再描画
    const observer = new MutationObserver(() => {
        const darkModeNow = document.documentElement.classList.contains("dark");
        if (darkModeNow !== isDarkMode) {
            pieChart.options.plugins.legend.labels.color = darkModeNow ? "#E5E7EB" : "#374151";
            pieChart.options.plugins.tooltip.backgroundColor = darkModeNow ? "rgba(31,41,55,0.9)" : "rgba(255,255,255,0.9)";
            pieChart.options.plugins.tooltip.titleColor = darkModeNow ? "#F9FAFB" : "#111827";
            pieChart.options.plugins.tooltip.bodyColor = darkModeNow ? "#F9FAFB" : "#111827";
            pieChart.update();
        }
    });

    // <html> タグの class 変更を監視
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ["class"],
    });
});