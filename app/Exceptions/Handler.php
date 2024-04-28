<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    
    public function render($request, Throwable $exception)
    {
        // CSRFトークンの期限切れエラーの場合はログインページにリダイレクト
        if ($exception instanceof TokenMismatchException) {
            return redirect()->route('login')->withErrors(['session_expired' => 'セッションが期限切れになりました。もう一度ログインしてください。']);
        }

        // その他の例外はデフォルトの処理を行う
        return parent::render($request, $exception);
    }
}
