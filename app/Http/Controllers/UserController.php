<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Employee_status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)//検索用にrequestを受取る
    {
        $per_page = 50; // １ページごとの表示件数
        $users = User::with(['role'])->sortable()->paginate($per_page);
        $roles = Role::all();
        $e_statuses = Employee_status::all();


        //検索フォームに入力された値を取得
        $employee_num = $request->input('employee_num');
        $user_name = $request->input('user_name');
        $role1 = $request->input('role1');
        $employee_status = $request->input('employee_status');

        //検索Query
        $query = user::query();

        //もし社員番号があれば
        if(!empty($employee_num))
        {
            $query->where('employee_id','like',"%{$employee_num}%");
        }

        //もしユーザ名があれば
        if($user_name)
        {
            $spaceConversion = mb_convert_kana($user_name, 's'); //全角スペース⇒半角スペースへ変換
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) 
            {
                $query->where('name', 'like', "%{$value}%");
            }
        }
        
        //もし権限があれば
        if(!empty($role1))
        {
            $query->where('role_id','like',"%{$role1}%");
        }

        //もし在職状態があれば
        if(!empty($employee_status))
        {
            $query->where('employee_status_id','like',"%{$employee_status}%");
        }

        $users = $query->paginate($per_page);

        return view('admin.user.index',compact('roles','users','e_statuses','employee_num','user_name','role1','employee_status'));
    }


















    public function create()
    {
        $roles = Role::orderBy('id','desc')->get();
        $e_statuses = Employee_status::orderBy('id','asc')->get();
        return view('admin.user.create',compact('roles','e_statuses'));
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->employee_id = $request->employee_id;
        $user->name = $request->name;
        $user->name_kana = $request->name_kana;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->employee_status_id = $request->employee_status_id;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('user.create')->with('message','登録しました');
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
        $e_statuses = Employee_status::with('users')->get();
        $user_role = $user->role_id;
        $user_e_status = $user->employee_status_id;
        return view('admin.user.edit',compact('user','roles','user_role','e_statuses','user_e_status'));
    }

    public function update(Request $request, $id)
    {
        $user=user::find($id);
        $user->employee_id = $request->employee_id;
        $user->name = $request->name;
        $user->name_kana = $request->name_kana;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->employee_status_id = $request->employee_status_id;
        $user->access_ip = $request->ip();

        if($request->filled('password'))
        { // パスワード入力があるときだけ変更
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect()->route('user.index',$id)->with('message','更新しました');
    }

    public function destroy(string $id)
    {
        $user = user::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('message', '削除しました');
    }
}
