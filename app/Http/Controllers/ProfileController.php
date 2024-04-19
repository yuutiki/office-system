<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateImage(Request $request)
    {
        
        $userNum = Auth::user()->user_num;

        // プロフ画像のファイル名を生成
        if ($request->hasFile('profile_image')) {
            $extension = $request->profile_image->extension();
            $fileName = $userNum . '_' . 'profile' . '.' . $extension;
            $imagePath = $request->file('profile_image')->storeAs('users/profile_image', $fileName, 'public');

            $user = User::find(Auth::user()->id);
            $user->profile_image = $imagePath;
            $user->save();

            return Redirect::route('profile.edit')->with('success', 'プロフィール画像を更新しました');

        } else {
            // ファイルがアップロードされていない場合の処理
            // アップロードなしのメッセージを表示
            return Redirect::route('profile.edit')->with('error', '画像がアップロードされていません');
        }



        // return Redirect::route('profile.edit')->with('success', 'プロフィール画像を更新しました');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
