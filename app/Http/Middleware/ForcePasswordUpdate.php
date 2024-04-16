<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // パスワード変更フラグが立っている場合には、パスワード変更画面にリダイレクトする
        if (auth()->check() && auth()->user()->password_change_required && !$request->is('password/force-update')) {
            return redirect()->route('password-force-update.show');
        }

        return $next($request);
    }
}
