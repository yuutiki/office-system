<?php

namespace App\Http\Controllers;

use App\Models\Keepfile;
use App\Models\User;
use Illuminate\Http\Request;
use illuminate\pagination\paginator; //addページネーション用



class KeepfileController extends Controller
{
    public function index(Request $request)
    {
        //sortableとpaginateを組み合わせる際の記述＆ログインユーザが登録したものしか表示されない
        $per_page = 15;
        $keepfiles = keepfile::where('user_id', \Auth::user()->id)->sortable()->paginate($per_page); 
        $user = auth()->user();
        $users = User::all();
        // $keepfiles = keepfile::orderBy('returndate','asc')->get();　//sortableを使わずに無理やり並べ替える際の記述

        //検索フォームの値を取得する
        $projectNum = $request->input('project_num');
        $clientName = $request->input('clientname');
        $isFinished = $request->input('is_finished');
        $userId = $request->input('user_id');
        $dayFrom = $request->input('day_from');
        $dayTo = $request->input('day_to');

        //検索Query
        $query = keepfile::query();

        if(!empty($projectNum))
        {
            $query->where('project_num','like',"%{$projectNum}");
        }

        if(!empty($clientName))
        {
            $spaceConversion = mb_convert_kana($clientName, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) 
            {
                $query->where('clientname', 'like', '%'.$value.'%');
            }
        }

        if ($isFinished === '0') {
            $query->where('is_finished', '=', 0);
        } elseif ($isFinished === '1') {
            $query->where('is_finished', '=', 1);
        }
        

        if(!empty($userId))
        {
            $query->where('user_id','like',"%{$userId}%");
        }

        if(!empty($dayFrom && $dayTo))
        {
            $query->whereBetween('return_at', [$dayFrom, $dayTo]);
        }

        $count = $query->count(); // 検索結果の総数を取得
        $keepfiles = $query->sortable()->paginate($per_page);

        return view('keepfile.index',compact('keepfiles','user','users','count','projectNum','clientName','isFinished','userId','dayFrom','dayTo'));
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
        return redirect()->route('keepfile.create')->with('message','登録しました');
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
