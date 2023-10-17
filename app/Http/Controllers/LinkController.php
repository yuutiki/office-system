<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        $per_page =25;
        $links = Link::with(['department'])->sortable()->orderBy('display_order','asc')->paginate($per_page); 
        $departments = Department::all();
        return view('link.index', compact('departments', 'links'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('link.create', compact('departments'));
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
        $departments = Department::all();
        return view('link.edit', compact('departments','link'));
    }

    public function update(Request $request, Link $link)
    {
        $link->fill($request->all())->save();

        return redirect()->route('link.index')->with('success', '正常に更新しました');

    }

    public function destroy(String $id)
    {
        $link = Link::find($id);
        $link->delete();

        return redirect()->route('link.index')->with('success', '正常に削除しました');
    }
}
