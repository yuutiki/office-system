<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddClientHintsHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // UA-CH をリクエストするヘッダ
        $response->headers->set(
            'Accept-CH',
            'Sec-CH-UA, Sec-CH-UA-Mobile, Sec-CH-UA-Platform, Sec-CH-UA-Arch, Sec-CH-UA-Model'
        );

        // キャッシュ差異を正しく扱うために Vary を追加
        $response->headers->set(
            'Vary',
            'Sec-CH-UA, Sec-CH-UA-Mobile, Sec-CH-UA-Platform, Sec-CH-UA-Arch, Sec-CH-UA-Model'
        );

        // Permissions-Policy を追加（UA-CH の送信を許可）
        $response->headers->set(
            'Permissions-Policy',
            'ch-ua=*; ch-ua-mobile=*; ch-ua-platform=*; ch-ua-arch=*; ch-ua-model=*'
        );

        return $response;
    }
}