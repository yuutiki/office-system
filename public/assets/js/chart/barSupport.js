document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("supportChart").getContext("2d");
    let supportChart = null;

    const labels = ['11月', '12月', '1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月'];
    const datasetsData = {
        '学務': [120, 132, 101, 134, 90, 230, 210, 60, 89, 123, 56, 325],
        '財務': [220, 182, 191, 234, 290, 330, 310, 134, 90, 230, 210, 60],
        '総務': [150, 232, 201, 154, 190, 330, 410, 220, 182, 191, 234, 290],
        '高校': [150, 232, 201, 154, 190, 330, 410, 232, 201, 154, 56, 87],
        'その他': [150, 232, 201, 154, 190, 330, 410, 154, 190, 330, 410, 874],
    };

    function isDarkMode() {
        return document.documentElement.classList.contains("dark") || localStorage.getItem('color-theme') === 'dark';
    }

    function initChart() {
        if (supportChart) {
            supportChart.destroy();
        }

        const darkMode = isDarkMode();
        const textColor = darkMode ? "#E5E7EB" : "#374151";

        const colors = [
            "rgba(59, 130, 246, 0.8)",  // 学務: 青
            "rgba(16, 185, 129, 0.8)",  // 財務: 緑
            "rgba(245, 158, 11, 0.8)",  // 総務: オレンジ
            "rgba(139, 92, 246, 0.8)",  // 高校: 紫
            "rgba(239, 68, 68, 0.8)",   // その他: 赤
        ];

        supportChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: Object.keys(datasetsData).map((key, index) => ({
                    label: key,
                    data: datasetsData[key],
                    backgroundColor: colors[index],
                    borderRadius: 6,
                    barPercentage: 0.7,
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: textColor,
                            font: { size: 13 }
                        }
                    },
                    tooltip: {
                        backgroundColor: darkMode ? 'rgba(31,41,55,0.9)' : 'rgba(255,255,255,0.95)',
                        titleColor: darkMode ? '#F9FAFB' : '#111827',
                        bodyColor: darkMode ? '#E5E7EB' : '#111827',
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw} 件`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: textColor,
                            maxRotation: window.innerWidth < 768 ? 45 : 0,
                        },
                        grid: {
                            color: darkMode ? "rgba(255,255,255,0.1)" : "rgba(0,0,0,0.05)",
                        }
                    },
                    y: {
                        stacked: true,
                        ticks: {
                            color: textColor,
                        },
                        grid: {
                            color: darkMode ? "rgba(255,255,255,0.1)" : "rgba(0,0,0,0.05)",
                        }
                    }
                }
            }
        });
    }

    // 初期化
    initChart();

    // ダークモード切り替え検知
    const observer = new MutationObserver(() => {
        initChart();
    });
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ["class"],
    });

    // PWA表示モード変更検知
    window.matchMedia('(display-mode: standalone)').addEventListener('change', () => {
        initChart();
    });
});
