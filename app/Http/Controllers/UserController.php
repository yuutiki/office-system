<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $per_page = 10; // １ページごとの表示件数
        $users = User::sortable()->paginate($per_page);
        $roles = Role::all();
        return view('admin.user.index',compact('roles'))->with('users', $users);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $result = $user->save();
        return ['result' => $result];
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->filled('password')) { // パスワード入力があるときだけ変更
            $user->password = bcrypt($request->password);
        }

        $result = $user->save();
        return ['result' => $result];
    }

    public function destroy(User $user)
    {
        $result = $user->delete();
        return ['result' => $result];
    }
}
