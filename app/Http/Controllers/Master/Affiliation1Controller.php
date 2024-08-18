<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Affiliation1;
use App\Models\Prefecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Affiliation1Controller extends Controller
{
    public function index()
    {
        $perPage = config('constants.perPage');
        $affiliation1s = Affiliation1::with('updatedBy')->orderBy('affiliation1_code', 'asc')->withCount('users')->paginate($perPage);

        return view('masters.affiliation1s.affiliation1-index',compact('affiliation1s'));
    }

    public function create()
    {
        $prefectures = Prefecture::all();
        $users = User::all();

        return view('masters.affiliation1s.create', compact('prefectures', 'users'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'cropped_company_logo' => 'nullable|string',
            'cropped_company_stamp' => 'nullable|string',
            // 他のフィールドのバリデーションルールをここに追加
        ]);
    
        $affiliation1 = new Affiliation1();
        $affiliation1->fill($request->except(['cropped_company_logo', 'cropped_company_stamp']));
    
        // 画像処理関数
        $processImage = function ($encodedImage, $type) {
            if (!$encodedImage) {
                return 'companies/' . $type . '/default.png';
            }
    
            preg_match('#^data:image/(\w+);base64,#i', $encodedImage, $matches);
            $extension = $matches[1];
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $encodedImage));
            $fileName = $type . '_' . Str::random(10) . '.' . $extension;
            $imagePath = 'companies/' . $type . '/' . $fileName;
            Storage::disk('public')->put($imagePath, $decodedImage);
            return $imagePath;
        };
    
        // 会社ロゴ画像の処理
        $affiliation1->company_logo_image = $processImage($request->cropped_company_logo, 'company_logo_image');
    
        // 会社印鑑画像の処理
        $affiliation1->company_stamp_image = $processImage($request->cropped_company_stamp, 'company_stamp_image');
    
        $affiliation1->save();
    
        return redirect()->route('affiliation1.index')->with('success', '正常に登録しました。');
    }

    public function show(Affiliation1 $affiliation1)
    {
        //
    }

    public function edit(Affiliation1 $affiliation1)
    {
        $prefectures = Prefecture::all();
        $users = User::all();
    
        return view('masters.affiliation1s.edit', compact('affiliation1', 'prefectures', 'users'));
    }

    public function update(Request $request, Affiliation1 $affiliation1)
    {
        // バリデーション
        $validatedData = $request->validate([
            'cropped_company_logo' => 'nullable|string',
            'cropped_company_stamp' => 'nullable|string',
            // 他のフィールドのバリデーションルールをここに追加
        ]);
    
        $affiliation1->fill($request->except(['cropped_company_logo', 'cropped_company_stamp']));
    
        // 画像処理関数
        $processImage = function ($encodedImage, $type, $oldImage) use ($affiliation1) {
            if (!$encodedImage) {
                return $oldImage; // 新しい画像がアップロードされていない場合、既存の画像パスを返す
            }
    
            // 古い画像を削除（デフォルト画像でない場合）
            if ($oldImage && $oldImage !== 'companies/' . $type . '/default.png') {
                Storage::disk('public')->delete($oldImage);
            }
    
            preg_match('#^data:image/(\w+);base64,#i', $encodedImage, $matches);
            $extension = $matches[1];
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $encodedImage));
            $fileName = $type . '_' . Str::random(10) . '.' . $extension;
            $imagePath = 'companies/' . $type . '/' . $fileName;
            Storage::disk('public')->put($imagePath, $decodedImage);
            return $imagePath;
        };
    
        // 会社ロゴ画像の処理
        if ($request->has('cropped_company_logo')) {
            $affiliation1->company_logo_image = $processImage(
                $request->cropped_company_logo, 
                'company_logo_image',
                $affiliation1->company_logo_image
            );
        }
    
        // 会社印鑑画像の処理
        if ($request->has('cropped_company_stamp')) {
            $affiliation1->company_stamp_image = $processImage(
                $request->cropped_company_stamp, 
                'company_stamp_image',
                $affiliation1->company_stamp_image
            );
        }
    
        $affiliation1->save();
    
        return redirect()->back()->with('success', '正常に更新しました。');
    }

    public function destroy(Affiliation1 $affiliation1)
    {
        //
    }
}
