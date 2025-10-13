<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>422 - 処理できません</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .delay-1 { animation-delay: 0.15s; opacity: 0; }
        .delay-2 { animation-delay: 0.3s; opacity: 0; }
        .delay-3 { animation-delay: 0.45s; opacity: 0; }
        
        /* Subtle grid pattern */
        .grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-slate-900 grid-pattern min-h-screen flex items-center justify-center p-6 font-sans antialiased">
    
    <div class="max-w-3xl w-full">
        
        <div class="grid md:grid-cols-2 gap-12 items-center">
            
            <!-- Left: Error Code -->
            <div class="text-center md:text-right fade-in-up">
                <div class="inline-block">
                    <h1 class="text-[10rem] md:text-[14rem] font-thin text-slate-100 leading-none tracking-tighter">
                        422
                    </h1>
                    <div class="h-0.5 bg-slate-100 w-full"></div>
                </div>
            </div>

            <!-- Right: Message -->
            <div class="space-y-8 fade-in-up delay-1">
                <div>
                    <h2 class="text-2xl md:text-3xl font-light text-slate-100 mb-4 tracking-wide">
                        処理できません
                    </h2>
                    <p class="text-slate-400 leading-relaxed">
                        送信されたデータに問題があり、処理を完了できませんでした。入力内容をご確認ください。
                    </p>
                </div>

                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4 fade-in-up delay-2">
                    <p class="text-slate-300 text-sm mb-2">
                        <span class="font-medium">よくある原因:</span>
                    </p>
                    <ul class="text-slate-400 text-sm space-y-1 list-disc list-inside">
                        <li>必須項目が未入力</li>
                        <li>入力形式が正しくない</li>
                        <li>データが要件を満たしていない</li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <button onclick="history.back()" 
                            class="block w-full md:w-auto text-center px-8 py-3 bg-slate-100 text-slate-900 text-sm font-medium tracking-wide transition-all duration-300 hover:bg-slate-300">
                        前のページへ戻る
                    </button>
                    <a href="{{ route('dashboard') }}" 
                       class="block w-full md:w-auto text-center px-8 py-3 border border-slate-600 text-slate-300 text-sm font-medium tracking-wide transition-all duration-300 hover:border-slate-400 hover:text-slate-100">
                        ホームへ戻る
                    </a>
                </div>
            </div>

        </div>

        <!-- Bottom Info -->
        <div class="mt-16 text-center fade-in-up delay-2">
            <p class="text-slate-500 text-sm mb-2">
                サポートが必要な場合: 
                <a href="mailto:support@example.com" class="text-slate-300 hover:text-slate-100 underline transition-colors">
                    support@example.com
                </a>
            </p>
            <p class="text-slate-600 text-xs font-mono">
                {{ date('Y-m-d H:i:s') }}
            </p>
        </div>

    </div>

</body>
</html>