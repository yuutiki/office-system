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
        $keepfiles = keepfile::where('user_id', \Auth::user()->id)->sortable()->paginate(15); 
        $user = auth()->user();
        $users = User::all();
        // $keepfiles = keepfile::orderBy('returndate','asc')->get();　//sortableを使わずに無理やり並べ替える際の記述
        $search = $request->input('search');
        $query = keepfile::query();
        

        $remaining = Keepfile::Remaining();
        // dd($remaining);
    
        if($search)
        {
            $spaceConversion = mb_convert_kana($search, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) 
            {
                $query->where('clientname', 'like', '%'.$value.'%');
            }
        $keepfiles = $query->paginate(20);
        }
        // return view('keepfile.index',compact('keepfiles','user','remaining'))->with(['keepfiles' => $keepfiles, 'search' => $search,]);
        return view('keepfile.index',compact('keepfiles','user','remaining','search','users'));
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
        //
    }
}
