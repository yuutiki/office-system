<?php

namespace App\Http\Controllers;

use App\Http\Requests\Link\LinkUpdateRequest;
use App\Models\Department;
use App\Models\Link;
use App\Services\PaginationService;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index(Request $request, PaginationService $paginationService)
    {
        $perPage = $paginationService->getPerPage($request);
        $rawdepartments = Department::all();
        $departments = Department::buildTree($rawdepartments); // 親子順に並んだリストを取得

        // クエリビルダーを作成
        $linksQuery = Link::with('department', 'updatedBy');

        $filters = $request->only('display_name', 'department_id');

        if (!empty($filters['display_name'])) {
            $spaceConversion = mb_convert_kana($filters['display_name'], 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
    
            $linksQuery->where(function($q) use ($wordArraySearched) {
                foreach ($wordArraySearched as $value) {
                    $q->orWhere('display_name', 'like', '%'.$value.'%');
                }
            });
        }

        if (!empty($filters['department_id'])) {
            $department = Department::find($filters['department_id']);

            if ($department) {
                $ids = $department->getDescendantIds();
                $ids[] = $department->id; // 自身のIDを追加
                $linksQuery->whereIn('department_id', $ids);
            }
        }

        $adminLinks = $linksQuery->orderBy('display_order', 'asc')->paginate($perPage);

        return view('link.index', compact('adminLinks', 'filters', 'departments'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // リクエストデータを使って新しいLinkモデルのインスタンスを作成
        $link = new Link;
        $link->fill($request->only([
            'display_name',
            'display_order',
            'url',
            'department_id',
            'created_by',
            'updated_by'
        ]));
        $link->save();

        return redirect()->route('link.index')->with('success', '正常に登録しました');
    }

    public function show(Link $link)
    {
        //
    }

    public function edit(String $id)
    {
        //
    }

    public function update(LinkUpdateRequest $request, Link $link)
    {
        $link->fill($request->only([
            'display_name',
            'display_order',
            'url',
            'department_id',
            'created_by',
            'updated_by'
        ]));
        $link->save();

        return redirect()->route('link.index')->with('success', '正常に更新しました');
    }

    public function destroy(String $id)
    {
        $link = Link::find($id);
        $link->delete();

        return redirect()->route('link.index')->with('success', '正常に削除しました');
    }
}
