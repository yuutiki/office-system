<?php

namespace App\Http\Controllers;

use App\Models\Keepfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\pagination\paginator; //addページネーション用



class KeepfileController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 15;
        $user = auth()->user();
        $users = User::all();
        
        // フィルタリングクエリを作成
        $query = Keepfile::where('user_id', $user->id)->sortable()->with('user');
    
        // 検索フォームの値を取得する
        $projectNum = $request->input('project_num');
        $clientName = $request->input('clientname');
        $userId = $request->input('user_id');
        $dayFrom = $request->input('day_from');
        $dayTo = $request->input('day_to');
    
        if (!empty($projectNum)) {
            $query->where('project_num', 'like', "%{$projectNum}");
        }
    
        if (!empty($clientName)) {
            $spaceConversion = mb_convert_kana($clientName, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
    
            foreach ($wordArraySearched as $value) {
                $query->where('clientname', 'like', '%'.$value.'%');
            }
        }
    
        if (!empty($userId)) {
            $query->where('user_id', 'like', "%{$userId}%");
        }
    
        if (!empty($dayFrom) && !empty($dayTo)) {
            $query->whereBetween('return_at', [$dayFrom, $dayTo]);
        }
    
        // 未返却のみのフィルタリング
        if (!$request->has('unreturned_only')) {
            $query->where('is_finished', 0);
        }
    
        // 検索結果を取得
        $keepfiles = $query->orderby('return_at', 'asc')->paginate($per_page);
        $count = $keepfiles->total();
    
        return view('keepfile.index', compact('keepfiles', 'user', 'users', 'count', 'projectNum', 'clientName', 'userId', 'dayFrom', 'dayTo'));
    }


    public function create()
    {
        return view('keepfile.create');
    }

    public function store(Request $request)
    {
        $inputs=$request->validate([
            'project_num'=>'required|max:13',
            'clientname'=>'required|max:255',
            'purpose'=>'required|max:255',
            'keep_at'=>'required|max:10',
            'return_at'=>'required|max:10',
            'memo'=>'max:255'
        ]);

    
    //store時にクライアントのipを取得

        $keepfile=new keepfile();
        $keepfile->project_num=$request->project_num;
        $keepfile->clientname=$request->clientname;
        $keepfile->purpose=$request->purpose;
        $keepfile->keep_at=$request->keep_at;
        $keepfile->return_at=$request->return_at;
        $keepfile->memo=$request->memo;
        $keepfile->is_finished=$request->is_finished;
        $keepfile->user_id=auth()->user()->id;
        $keepfile->save();
        return redirect()->route('keepfile.index')->with('success','登録しました');
    }

    public function show($id)
    {
        $keepfile = Keepfile::find($id);
        return view('keepfile.show',compact('keepfile'));
    }

    public function edit(string $id)
    {
        $keepfile=keepfile::find($id);
        return view('keepfile.edit',compact('keepfile'));
    }

    public function update(Request $request, string $id)
    {
        $keepfile=keepfile::find($id);

        $inputs=$request->validate([
            'project_num'=>'required|max:13',
            'clientname'=>'required|max:255',
            'purpose'=>'required|max:255',
            'keep_at'=>'required|max:10',
            'return_at'=>'required|max:10',
            'memo'=>'max:255'
        ]);

        $keepfile->project_num=$inputs['project_num'];
        $keepfile->clientname=$inputs['clientname'];
        $keepfile->purpose=$inputs['purpose'];
        $keepfile->keep_at=$inputs['keep_at'];
        $keepfile->return_at=$inputs['return_at'];
        $keepfile->memo=$inputs['memo'];
        $keepfile->is_finished=$request->is_finished;
        $keepfile->user_id=auth()->user()->id;
        $keepfile->save();
        return redirect()->route('keepfile.index',$id)->with('message','更新しました');
    }

    public function destroy(string $id)
    {
        $keepfile = keepfile::find($id);
        $keepfile->delete();
        return redirect()->route('keepfile.index')->with('message', '削除しました');
    }
}
