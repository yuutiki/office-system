<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Division;
use App\Models\User;
use App\Models\Role;
use App\Models\EmployeeStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class UserController extends Controller
{
    public function index(Request $request)//検索用にrequestを受取る
    {
        $per_page = 50; // １ページごとの表示件数
        $users = User::with(['role','company','department','division'])->sortable()->paginate($per_page);
        $roles = Role::all();
        $companies = Company::all();
        $departments = Department::all();
        $divisions = Division::all();
        $e_statuses = EmployeeStatus::all();


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
            // $query->where('employee_num','like',"%{$employee_num}%");
            $query->where('employee_num','=',$employee_num);
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
            $query->where('role_id','=',$role1);
        }

        //もし在職状態があれば
        if(!empty($employee_status))
        {
            $query->where('employee_status_id','=',$employee_status);
        }

        $users = $query->paginate($per_page);
        $count = $users->total();

        return view('admin.user.index',compact('roles','users','e_statuses','employee_num','user_name','role1','employee_status','count','companies','departments','divisions'));
    }


    public function create()
    {
        $companies = Company::all();
        $departments = Department::all();
        $divisions = Division::all();
        $roles = Role::orderBy('id','desc')->get();
        $e_statuses = EmployeeStatus::orderBy('id','asc')->get();

        return view('admin.user.create',compact('roles','e_statuses','companies','departments','divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),User::$rules);

        if ($validator->fails()) {
            // バリデーションエラーが発生した場合
            session()->flash('error', '入力内容にエラーがあります。');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->employee_num = $request->employee_num;
        $user->name = $request->name;
        $user->kana_name = $request->kana_name;
        $user->email = $request->email;
        $user->int_phone = $request->int_phone;
        $user->ext_phone = $request->ext_phone;
        $user->role_id = $request->role_id;
        $user->company_id = $request->company_id;
        $user->department_id = $request->department_id;
        $user->division_id = $request->division_id;
        $user->employee_status_id = $request->employee_status_id;
        $user->is_enabled = $request->is_enabled;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('user.index')->with('success','登録しました');
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
        $e_statuses = EmployeeStatus::with('users')->get();
        $companies = Company::all();
        $departments = Department::all();
        $divisions = Division::all();
        $e_statuses = EmployeeStatus::all();
        $user_role = $user->role_id;
        $user_e_status = $user->employee_status_id;
        return view('admin.user.edit',compact('user','roles','user_role','e_statuses','user_e_status','companies','departments','divisions'));
    }

    public function update(Request $request, $id)
    {
        // パスワードが入力されたかどうかをチェック
        $passwordIsProvided = !empty($request['password']);

        // バリデーションルールを初期化
        $rules = User::$rules;

        // パスワードが入力された場合、パスワードのバリデーションルールを追加
        if ($passwordIsProvided) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            // バリデーションエラーが発生した場合
            session()->flash('error', '入力内容にエラーがあります。');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user=user::find($id);
        $user->employee_num = $request->employee_num;
        $user->name = $request->name;
        $user->kana_name = $request->kana_name;
        $user->email = $request->email;
        $user->int_phone = $request->int_phone;
        $user->ext_phone = $request->ext_phone;
        $user->role_id = $request->role_id;
        $user->company_id = $request->company_id;
        $user->department_id = $request->department_id;
        $user->division_id = $request->division_id;
        $user->employee_status_id = $request->employee_status_id;
        $user->is_enabled = $request->is_enabled;
        $user->access_ip = $request->ip();

        if($request->filled('password'))
        { // パスワード入力があるときだけ変更
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect()->route('user.index',$id)->with('success','更新しました');
    }

    public function destroy(string $id)
    {
        $user = user::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('message', '削除しました');
    }

    public function upload(Request $request)
    {
        
        $csvValidator = Validator::make($request->all(),User::$uploadRules);

        if ($csvValidator->fails()) {
            // バリデーションエラーが発生した場合
            session()->flash('error', 'CSVファイルを添付してください');
            return redirect()->back()->withErrors($csvValidator)->withInput();
        }

        $csvFile = $request->file('csv_input');
        
        // CSVファイルの一時保存先パス
        $csvPath = $csvFile->getRealPath();
        
        // CSVデータのパースとデータベースへの登録処理
        $this->parseCSVAndSaveToDatabase($csvPath);

        // 成功時のリダイレクトやメッセージを追加するなどの処理を行う
        return redirect()->back()->with('success', 'CSVファイルをアップロードしました。');
    }

    private function parseCSVAndSaveToDatabase($csvPath)
    {
        // CSVファイルの文字コードを自動判定
        $fromCharset = mb_detect_encoding(file_get_contents($csvPath), 'UTF-8, Shift_JIS, EUC-JP, JIS, SJIS-win', true);
        
        $config = new LexerConfig();
        $config->setFromCharset($fromCharset);

        $config->setIgnoreHeaderLine(true); // ヘッダを無視する設定
        $lexer = new Lexer($config);
        $interpreter = new Interpreter();

         // CSV行をパースした際に実行する処理を定義
        $interpreter->addObserver(function (array $row) {
            $user = new User();
            $user->employee_num = $row[0];
            $user->name = $row[1];
            $user->kana_name = $row[2];
            $user->email = $row[3];
            $user->ext_phone = $row[4];
            $user->int_phone = $row[5];
            $user->password = bcrypt($row[6]);



            $user->company_id = $row[7];
            
            
            $user->department_id = $row[8];
            
            
            
            $divisionCode = $row[9];
            $division = Division::where('division_code', $divisionCode)->first();
            if ($division) {
                $user->division_id = $division->id;
            } else {
                // divisionが見つからない場合のエラーハンドリング
            }
            $roleNum = $row[10];
            $role = Role::where('role_num', $roleNum)->first();
            if ($role) {
                $user->role_id = $role->id;
            } else {
                // divisionが見つからない場合のエラーハンドリング
            }
            $employeeStatusNum = $row[11];
            $employee_status = EmployeeStatus::where('employee_status_num', $employeeStatusNum)->first();
            if ($employee_status) {
                $user->employee_status_id = $employee_status->id;
            } else {
                // divisionが見つからない場合のエラーハンドリング
            }
            $user->is_enabled = $row[12];
            $user->save();
        });

        $lexer->parse($csvPath, $interpreter);
    }
}
