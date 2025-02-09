<?php

namespace App\Http\Controllers;

use App\Http\Requests\Link\LinkUpdateRequest;
use App\Models\Affiliation2;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        $affiliation2s = Affiliation2::all();


        // フィルタリングクエリを作成
        $query = Link::with('affiliation2');

        // 検索フォームの値を取得する
        $displayName = $request->input('display_name');
        // $clientName = $request->input('clientname');

     
        if (!empty($displayName)) {
            $spaceConversion = mb_convert_kana($displayName, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
    
            foreach ($wordArraySearched as $value) {
                $query->orwhere('display_name', 'like', '%'.$value.'%');
            }
        }


    
        // if (!empty($userId)) {
        //     $query->where('user_id', 'like', "%{$userId}%");
        // }
    

    
        // // 未返却のみのフィルタリング
        // if (!$request->has('unreturned_only')) {
        //     $query->where('is_finished', 0);
        // }
    
        // 検索結果を取得
        $adminLinks = $query->orderby('display_order', 'asc')->paginate();


        // dd($links);

        // $count = $links->total();




        // $links = Link::with(['affiliation2'])->sortable()->orderBy('display_order','asc')->paginate(); 
        return view('link.index', compact('affiliation2s', 'adminLinks','displayName'));
    }

    public function create()
    {
        $affiliation2s = Affiliation2::all();
        return view('link.create', compact('affiliation2s'));
    }

    public function store(Request $request)
    {
        // リクエストデータを使って新しいLinkモデルのインスタンスを作成
        $link = new Link;
        $link->fill($request->all());

        // モデルを保存
        $link->save();

        return redirect()->route('link.index')->with('success', '正常に登録しました');
    }

    public function show(Link $link)
    {
        //
    }

    public function edit(String $id)
    {
        $link=Link::find($id);
        $affiliation2s = Affiliation2::all();
        return view('link.edit', compact('affiliation2s','link'));
    }

    // バリデーション用API
    public function validateLink(LinkUpdateRequest $request)
    {
        // バリデーションが成功すると、何も返さずに200 OK
        return response()->json(['message' => 'Validation passed']);
    }

    public function update(LinkUpdateRequest $request, Link $link)
    {
        // $rules = [
        //     'display_name' => 'required',
        //     'affiliation2_id' => 'required',
        //     'display_order' => 'required|numeric',
        //     'url' => 'required|url',
        // ];
    
        // $validator = Validator::make($request->all(), $rules);
    
        // if ($validator->fails()) {
        //     // バリデーションエラーがある場合
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        
        $link['updated_by'] = Auth::user()->id; // 更新者のIDを更新データに追加
        $link->fill($request->all())->save();
        // セッションから Modal ID を削除
        // Session::forget('openedModalId');

        return redirect()->route('link.index')->with('success', '正常に更新しました');
    }

    public function destroy(String $id)
    {
        $link = Link::find($id);
        $link->delete();

        return redirect()->route('link.index')->with('success', '正常に削除しました');
    }

    public function mordalupdate(Request $request, Link $link)
    {
    // バリデーションのルールを設定
    $rules = [
        'display_name' => 'required',
        'affiliation2_id' => 'required',
        'display_order' => 'required|numeric',
        'url' => 'required|url',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        // バリデーションエラーがある場合
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // バリデーションを通過した場合、データを更新
    $validatedData = $request->validated();
    $link->update($validatedData);

        // バリデーションを通過した場合、データを処理
        // ここにデータの保存や処理のコードを追加
        // $link = new Link;
        // $link->fill($request->all());
        // モデルを保存
        // $link->save();

    }

//     public function saveModalId(Request $request)
// {
//     $modalId = $request->input('savemodalId');

//     // セッションにモーダルIDを保存
//     session(['openedModalId' => $modalId]);

//     return response()->json(['message' => 'Modal ID saved successfully']);
// }
}
