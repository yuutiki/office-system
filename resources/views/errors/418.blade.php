<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>418 - I'm a teapot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes steam {
            0%, 100% { opacity: 0.3; transform: translateY(0) scale(1); }
            50% { opacity: 0.6; transform: translateY(-10px) scale(1.1); }
        }
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .delay-1 { animation-delay: 0.15s; opacity: 0; }
        .delay-2 { animation-delay: 0.3s; opacity: 0; }
        .delay-3 { animation-delay: 0.45s; opacity: 0; }
        .steam {
            animation: steam 2s ease-in-out infinite;
        }
        .steam-2 {
            animation: steam 2s ease-in-out infinite;
            animation-delay: 0.5s;
        }
        .steam-3 {
            animation: steam 2s ease-in-out infinite;
            animation-delay: 1s;
        }
        
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
            
            <!-- Left: Error Code with Teapot Icon -->
            <div class="text-center md:text-right fade-in-up">
                <div class="inline-block relative">
                    <!-- Steam effect -->
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 flex gap-2">
                        <div class="w-2 h-6 bg-slate-400 rounded-full steam opacity-30"></div>
                        <div class="w-2 h-6 bg-slate-400 rounded-full steam-2 opacity-30"></div>
                        <div class="w-2 h-6 bg-slate-400 rounded-full steam-3 opacity-30"></div>
                    </div>
                    
                    <h1 class="text-[10rem] md:text-[14rem] font-thin text-slate-100 leading-none tracking-tighter">
                        418
                    </h1>
                    <div class="h-0.5 bg-slate-100 w-full"></div>
                    
                    <!-- Teapot SVG Icon -->
                    <div class="mt-6 flex justify-center md:justify-end">
                        <svg class="w-16 h-16 text-slate-300 dark:text-slate-300" fill="currentColor" version="1.0" xmlns="http://www.w3.org/2000/svg" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" stroke="none">
                                <path d="M2400 4376 c-64 -14 -100 -34 -100 -56 0 -9 23 -51 50 -95 28 -44 50
                                    -82 50 -85 0 -3 -50 -16 -112 -28 -212 -44 -393 -127 -576 -265 l-93 -70 -132
                                    -24 c-230 -43 -255 -80 -138 -205 107 -115 131 -171 99 -231 -19 -35 -149
                                    -201 -165 -211 -30 -17 -105 7 -236 74 -148 75 -194 87 -283 71 -95 -18 -180
                                    -65 -259 -145 -66 -67 -104 -120 -94 -131 3 -2 47 5 99 15 115 24 159 25 207
                                    5 77 -33 101 -74 168 -295 66 -219 120 -329 211 -430 28 -31 33 -46 43 -125
                                    38 -297 113 -508 260 -728 117 -174 283 -331 435 -413 28 -15 78 -54 111 -88
                                    66 -67 103 -84 245 -108 103 -18 694 -18 810 0 161 25 187 36 266 115 39 40
                                    109 95 155 124 341 211 598 569 674 942 9 42 19 78 23 81 4 3 25 12 47 19 252
                                    84 439 314 495 611 15 80 13 236 -5 303 -33 126 -100 218 -191 263 -48 23 -63
                                    26 -127 22 -39 -3 -88 -13 -107 -22 -19 -9 -26 -14 -15 -10 47 14 137 16 181
                                    4 63 -18 154 -103 193 -181 42 -84 55 -156 48 -274 -14 -250 -142 -484 -331
                                    -606 -55 -36 -164 -84 -172 -76 -2 2 -1 18 2 35 5 26 18 38 73 68 230 128 409
                                    494 347 708 -21 72 -53 124 -102 164 -111 92 -279 80 -397 -28 l-53 -48 -29
                                    46 c-41 65 -41 65 -4 59 26 -4 45 2 81 24 80 48 164 72 238 67 36 -3 80 -13
                                    99 -22 18 -10 30 -13 26 -7 -32 53 -195 62 -309 18 -50 -20 -86 -27 -136 -27
                                    l-69 0 -110 97 c-145 126 -145 131 -8 281 104 113 89 148 -81 177 -121 22
                                    -144 31 -212 87 -128 104 -298 198 -450 248 -78 26 -224 59 -262 60 -16 0 -28
                                    3 -28 6 0 4 23 46 50 94 54 93 56 111 12 129 -78 32 -303 41 -412 17z m344
                                    -24 c67 -23 68 -38 4 -51 -117 -26 -374 -8 -385 25 -13 40 282 60 381 26z
                                    m-260 -81 c50 -5 136 -5 191 -1 55 5 102 6 105 4 7 -7 -43 -93 -68 -117 -21
                                    -19 -34 -21 -136 -22 -131 0 -136 2 -186 91 -35 62 -36 68 -13 60 9 -4 58 -11
                                    107 -15z m401 -195 c150 -37 284 -96 418 -183 69 -44 167 -129 167 -144 0 -15
                                    -76 -48 -167 -74 -282 -79 -881 -95 -1254 -34 -204 33 -369 82 -369 108 0 15
                                    101 93 205 158 116 73 235 126 359 159 138 36 208 43 386 39 122 -3 176 -9
                                    255 -29z m-1425 -380 c0 -25 19 -36 95 -55 57 -14 253 -38 440 -53 210 -17
                                    979 -17 1175 0 217 18 389 42 445 60 44 15 50 20 50 45 -1 26 1 27 30 22 109
                                    -22 125 -50 48 -83 -82 -34 -237 -60 -538 -89 -256 -25 -982 -24 -1245 0 -313
                                    30 -524 68 -588 107 -47 29 -41 45 22 61 56 13 66 11 66 -15z m75 -141 c91
                                    -16 298 -39 520 -57 193 -16 872 -15 1075 1 163 13 489 48 528 56 20 5 19 1
                                    -14 -42 -52 -68 -68 -108 -55 -144 5 -16 66 -84 135 -152 69 -68 126 -128 126
                                    -134 0 -37 -315 -103 -670 -140 -236 -25 -983 -25 -1220 0 -309 32 -590 90
                                    -590 122 0 5 34 51 76 100 42 50 82 104 90 122 33 76 8 163 -70 248 -24 25
                                    -36 43 -27 40 9 -4 52 -13 96 -20z m-600 -349 c19 -8 63 -35 97 -59 80 -56
                                    132 -83 194 -98 27 -6 53 -15 57 -19 5 -4 -3 -31 -17 -59 -53 -104 -108 -308
                                    -131 -483 -3 -27 -11 -48 -18 -48 -20 0 -102 97 -136 159 -17 33 -50 109 -72
                                    168 -71 190 -102 238 -171 274 -42 21 -166 26 -215 9 -27 -10 -27 -9 7 20 69
                                    60 229 130 325 143 17 2 34 5 38 6 4 0 23 -6 42 -13z m3380 -157 c84 -24 155
                                    -133 155 -238 -1 -120 -75 -301 -162 -397 -51 -55 -130 -114 -153 -114 -8 0
                                    -14 39 -19 118 -7 116 -27 235 -65 384 -19 73 -19 79 -3 129 34 107 127 151
                                    247 118z m-406 -67 c36 -71 73 -184 103 -312 20 -83 22 -123 23 -325 0 -250
                                    -9 -313 -64 -478 -104 -307 -349 -581 -660 -737 -95 -47 -280 -106 -416 -132
                                    -167 -31 -429 -31 -596 0 -295 55 -509 167 -694 363 -247 262 -379 591 -392
                                    977 -8 240 26 438 108 620 l31 69 73 -23 c247 -78 634 -118 1150 -118 514 0
                                    992 50 1215 128 36 13 71 24 77 25 7 0 26 -25 42 -57z"/>
                                <path d="M1795 3720 c8 -12 148 -49 243 -64 177 -28 388 -39 652 -33 322 8
                                505 32 624 82 50 21 41 29 -12 11 -61 -22 -268 -54 -421 -66 -336 -25 -784 0
                                -1020 59 -39 10 -68 14 -66 11z"/>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Right: Message -->
            <div class="space-y-8 fade-in-up delay-1">
                <div>
                    <h2 class="text-2xl md:text-3xl font-light text-slate-100 mb-4 tracking-wide">
                        I'm a teapot
                    </h2>
                    <p class="text-slate-400 leading-relaxed">
                        申し訳ございません。このサーバーはティーポットです。コーヒーを淹れることはできません。
                    </p>
                    <p class="text-slate-500 text-sm mt-3 italic">
                        ※ RFC 2324 ハイパーテキストコーヒーポット制御プロトコル
                    </p>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('dashboard') }}" 
                       class="block w-full md:w-auto text-center px-8 py-3 bg-slate-100 text-slate-900 text-sm font-medium tracking-wide transition-all duration-300 hover:bg-slate-300">
                        ホームへ戻る
                    </a>
                    <button onclick="location.reload()" 
                            class="block w-full md:w-auto text-center px-8 py-3 border border-slate-600 text-slate-300 text-sm font-medium tracking-wide transition-all duration-300 hover:border-slate-400 hover:text-slate-100">
                        お茶を淹れてみる
                    </button>
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