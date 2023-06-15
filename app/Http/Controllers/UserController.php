<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;




class UserController extends Controller
{
    public function index(Request $request)//検索用にrequestを追加
    {
        $per_page = 15; // １ページごとの表示件数
        $users = User::with(['role'])->sortable()->paginate($per_page);
        $roles = Role::all();

        //検索
        $search = $request->input('search');
        $query = user::query();

        if($search)
        {
            $spaceConversion = mb_convert_kana($search, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) 
            {
                $query->where('name', 'like', '%'.$value.'%');
            }
        $users = $query->paginate(20);
        }


        return view('admin.user.index',compact('roles','search'))->with('users', $users);
    }

    public function create()
    {
        $roles = Role::orderBy('id','desc')->get();
        return view('admin.user.create',compact('roles'));
    }

    public function store(Request $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->name_kana = $request->name_kana;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('user.create')->with('message','ユーザを登録しました');

    }

    public function show($id)
    {
        // $user = user::find($id);
        // return view('user.show',compact('user'));
    }

    public function edit(string $id)
    {
        $user=user::find($id);
        $roles = Role::with('users')->get();
        $user_role = $user->role_id;
        return view('admin.user.edit',compact('user','roles','user_role'));
    }

    public function update(Request $request, $id)
    {
        $user=user::find($id);
        $user->name = $request->name;
        $user->name_kana = $request->name_kana;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->access_ip = $request->ip();

        if($request->filled('password'))
        { // パスワード入力があるときだけ変更
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect()->route('user.index',$id)->with('message','ユーザを更新しました');
    }

    public function destroy(string $id)
    {
        $user = user::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('message', 'ユーザを削除しました');
    }
}
