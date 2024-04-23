<?php

namespace App\Http\Requests\Auth;

use App\Models\LoginHistory;
use App\Models\User;
use App\Models\PasswordPolicy;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            // throw ValidationException::withMessages([
            //     'email' => trans('auth.failed'),
            // ]);

            // Check if the email address exists in the database
            $user = User::where('email', $this->email)->first();

            if ($user === null) {
                $errorMessage = trans('auth.invalid_email');
            } else {
                $errorMessage = trans('auth.invalid_password');
            }

            throw ValidationException::withMessages([
                'credentials' => $errorMessage,
            ]);
        }

        $user = Auth::user();

        if (!$user->is_enabled) {
            Auth::logout();
            RateLimiter::hit($this->throttleKey());
    
            throw ValidationException::withMessages([
                'credentials' => trans('auth.Your account is not active.'),
            ]);
        }

        // デバイスとブラウザを取得
        $userAgent = $this->userAgent();
        list($device, $browser) = $this->parseUserAgent($userAgent);

        // ログイン成功時にログイン履歴を保存
        LoginHistory::create([
            'user_id' => Auth::user()->id,
            'device' => $device,
            'browser' => $browser,
            'ip_address' => $this->ip(),
            'logged_in_at' => now(),
        ]);

        RateLimiter::clear($this->throttleKey());
    }

    private function parseUserAgent($userAgent)
    {
        // デフォルト値を設定
        $device = 'Unknown';
        $browser = 'Unknown';

        // デバイスの判別
        if (strpos($userAgent, 'Windows') !== false) {
            $device = 'Windows';
        } elseif (strpos($userAgent, 'Macintosh') !== false) {
            $device = 'Mac';
        } elseif (strpos($userAgent, 'iPhone') !== false) {
            $device = 'iPhone';
        } elseif (strpos($userAgent, 'iPad') !== false) {
            $device = 'iPad';
        } elseif (strpos($userAgent, 'Android') !== false) {
            $device = 'Android';
        }

        // ブラウザの判別
        if (strpos($userAgent, 'Chrome') !== false) {
            $browser = 'Chrome';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            if (strpos($userAgent, 'Version') !== false) {
                $browser = 'Safari';
            }
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $browser = 'Firefox';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            $browser = 'Edge';
        }

        return [$device, $browser];
    }


    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        $passwordPolicy = PasswordPolicy::firstOrFail();

        if (! RateLimiter::tooManyAttempts($this->throttleKey(), $passwordPolicy->max_login_attempt)) {
            return;
        }

        // RateLimiter::hit メソッドを追加
        RateLimiter::hit($this->throttleKey());

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
