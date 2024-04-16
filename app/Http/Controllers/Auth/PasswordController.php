<?php
// プロフィール画面のPasswordアップデートと強制アップデータ


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }


    /**
     * Show the form for changing the password.
     *
     * @return \Illuminate\View\View
     */
    public function showForceUpdatePasswordForm()
    {
        return view('auth.change-password');
    }



    /**
     * Handle an incoming password change request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceUpdate(PasswordRequest $request)
    {
        // $request->validate([
        //     'current_password' => 'required',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        $user = User::find(Auth::id()); // ユーザーのインスタンスを取得

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // パスワードを変更して保存
        $user->password = Hash::make($request->password);

        // password_change フラグを 0 に更新
        $user->password_change_required = 0;

        $user->save();

        // パスワードを変更した後、ダッシュボードに遷移する
        return redirect()->route('dashboard')->with('success', 'Password has been updated successfully.');
    }
}
