<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\LoginHistory;
use App\Models\PasswordPolicy;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $loginHistories = LoginHistory::where('user_id',$user->id)->orderBy('logged_in_at','desc')->limit(10)->get();

        $passwordPolicy = PasswordPolicy::find(1);
        // return view('profile.edit', ['user' => $request->user(),]);
        return view('profile.edit', compact('user','loginHistories','passwordPolicy'));
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
        $encodedImage = $request->input('cropped_profile_image');
    
        if (!empty($encodedImage)) {
    
            // エンコードされた画像データを取得
            // $encodedImage = $request->cropped_profile_image;
    
            // データURIスキームから拡張子を取得
            // 第1引数: パターンとして使用する正規表現文字列。
            // 第2引数: パターンを照合する対象の文字列。
            // 第3引数: パターンに一致した部分文字列が格納される配列。0番目には全体、1番目には拡張子部分のみ
            if (preg_match('#^data:image/(\w+);base64,#i', $encodedImage, $matches)) {
                $extension = $matches[1];
    
                // エンコードされた画像データをデコード
                $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $encodedImage));
    
                // ファイル名を生成
                $fileName = $userNum . '_' . 'profile' . '.' . $extension;
                $imagePath = 'users/profile_image/' . $fileName;
    
                // 画像を保存
                Storage::disk('public')->put($imagePath, $decodedImage);
    
                // ユーザーのプロフィール画像を更新
                $user = User::find(Auth::user()->id);
                $user->profile_image = $imagePath;
                $user->save();
    
                return Redirect::route('profile.edit')->with('success', 'プロフィール画像を更新しました');
            } else {
                // データURI形式が不正な場合
                return Redirect::route('profile.edit')->with('error', '画像データの形式が正しくありません');
            }
        } else {
            // エンコードされた画像データがリクエストに含まれていない場合の処理
            return Redirect::route('profile.edit')->with('error', '新しい画像が選択されていません');
        }
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
