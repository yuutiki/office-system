<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use App\Http\Requests\UserStoreRequest;
use App\Jobs\SendLoginInformationJob;
use App\Mail\SendLoginInformation;
use App\Models\Affiliation1;
use App\Models\Department;
use App\Models\Affiliation3;
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
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(Request $request)//検索用にrequestを受取る
    {
        $per_page = 50;
        $users = User::with(['role','affiliation1s','department','affiliation3']);
        $affiliation1s = Affiliation1::all();
        $departments = Department::all();
        $affiliation3s = Affiliation3::all();
        $employeeStatuses = EmployeeStatus::all();


        //検索フォームに入力された値を取得
        $user_num = $request->input('user_num');
        $user_name = $request->input('user_name');
        $departmentId = $request->input('department_id');
        // $roles1 = $request->input('roles');
        $selectedRoles = $request->input('roles', []); 
        $selectedEmployeeStatues = $request->input('employeeStatuses',[]);

        //検索Query
        $query = User::query();

        // システム管理者でない場合は、id1のユーザーを非表示にする
        if (!$this->isSysAdmin()) {
            $query->where('id', '!=', 1);
        }

        //もし社員番号があれば
        if(!empty($user_num))
        {
            // $query->where('user_num','like',"%{$user_num}%");
            $query->where('user_num','=',$user_num);
        }

        if(!empty($departmentId))
        {
            $query->where('department_id','=',$departmentId);
        }

        //もしユーザ名があれば
        if($user_name)
        {
            $spaceConversion = mb_convert_kana($user_name, 's'); //全角スペース⇒半角スペースへ変換
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) 
            {
                $query->where('user_name', 'like', "%{$value}%");
            }
        }
        
        //もし権限があれば
        if (!empty($selectedRoles))
        {
            $query->whereIn('role_id', $selectedRoles);
        }

        //もし在職状態があれば
        if(!empty($selectedEmployeeStatues))
        {
            $query->whereIn('employee_status_id', $selectedEmployeeStatues);
        }

        $users = $query->sortable()->paginate($per_page);
        $count = $users->total();

        return view('admin.user.index',compact('users','employeeStatuses','user_num','user_name','selectedRoles','count','affiliation1s','departments','affiliation3s','selectedEmployeeStatues','departmentId'));
    }

    private function isSysAdmin()
    {
        return Auth::check() && Auth::user()->id === 1;
    }
    


    public function create()
    {
        $affiliation1s = Affiliation1::all();
        $departments = Department::all();
        $affiliation3s = Affiliation3::all();
        $roles = Role::orderBy('id','desc')->get();
        $e_statuses = EmployeeStatus::orderBy('id','asc')->get();
        $maxlength = config('constants.int_phone_maxlength');


        return view('admin.user.create',compact('roles','e_statuses','affiliation1s','departments','affiliation3s','maxlength'));
    }

    public function store(UserStoreRequest $request)
    {
        // 社員番号の頭0埋め6桁にする
        $emploeeNum =  str_pad($request->user_num, 6, '0', STR_PAD_LEFT);

        // プロフ画像のファイル名を生成
        if ($request->hasFile('profile_image')) {
            $extension = $request->profile_image->extension();
            $fileName = $emploeeNum . '_' . 'profile' . '.' . $extension;
            $imagePath = $request->file('profile_image')->storeAs('users/profile_image', $fileName, 'public');
        } else {
            $imagePath = 'users/profile_image/default.png'; // ファイルがアップロードされなかった場合はデフォルトを設定する
        }

        // // パスワード作成（生年月日8桁＋A%＋携帯番号下4桁）
        // $birth = str_replace('-', '', $request->birth); // 生年月日からハイフンを削除する
        // $phoneLast4Digits = substr($request->ext_phone, -4); // 携帯番号から下4桁を取得する
        // $password = $birth . 'A%' . $phoneLast4Digits;
        $password = $this->generateTemporaryPassword($request->birth, $request->ext_phone);

        $user = new User();
        $user->user_num = $emploeeNum;
        $user->user_name = $request->user_name;
        $user->user_kana_name = $request->user_kana_name;
        $user->email = $request->email;
        $user->int_phone = $request->int_phone;
        $user->ext_phone = $request->ext_phone;
        $user->birth = $request->birth;
        $user->affiliation1_id = $request->affiliation1_id;
        $user->department_id = $request->department_id;
        $user->affiliation3_id = $request->affiliation3_id;
        $user->employee_status_id = $request->employee_status_id;
        $user->is_enabled = $request->is_enabled;
        $user->password = bcrypt($password);
        $user->profile_image = $imagePath;
        $user->password_change_required = $request->password_change_required;
        $user->save();

        // ログイン情報メールを送信する
            // アプリケーションのURLを取得する
        $url = config('app.url');

        // SendLoginInformationJobジョブをディスパッチする
        SendLoginInformationJob::dispatch($url, $request->email, $password);
        // Mail::to($request->email)->send(new SendLoginInformation($url, $request->email, $password)); // SendLoginInformationはメールクラス名

        return redirect()->route('users.index')->with('success','登録しました');
    }

    // 一時パスワードを生成するメソッド（生年月日8桁＋A%＋携帯番号下4桁）
    private function generateTemporaryPassword($birth, $phone)
    {
        $birth = str_replace('-', '', $birth); // 生年月日からハイフンを削除する
        $phoneLast4Digits = substr($phone, -4); // 携帯番号から下4桁を取得する
        return $birth . 'A%' . $phoneLast4Digits;
    }

    public function show($id)
    {
        // $user = user::find($id);
        // return view('user.show',compact('user'));
    }

    public function edit(string $id)
    {
        $user=user::find($id);
        // $roles = Role::with('users')->get();
        $e_statuses = EmployeeStatus::with('users')->get();
        $affiliation1s = Affiliation1::all();
        $departments = Department::all();
        $affiliation3s = Affiliation3::all();
        $e_statuses = EmployeeStatus::all();
        $user_role = $user->role_id;
        $user_e_status = $user->employee_status_id;

        $maxlength = config('constants.int_phone_maxlength');

        return view('admin.user.edit',compact('user','user_role','e_statuses','user_e_status','affiliation1s','departments','affiliation3s', 'maxlength',));
    }

    public function update(Request $request, User $user)
    {
        // // パスワードが入力されたかどうかをチェック
        // $passwordIsProvided = !empty($request['password_' . $id]);

        // // バリデーションルールを初期化
        // $rules = User::rules($id);

        // // パスワードが入力された場合、パスワードのバリデーションルールを追加
        // if ($passwordIsProvided) {
        //     $rules['password_' . $id] = 'required|string|min:8|confirmed';
        // }
        

        // // バリデーション実行
        // $validator = Validator::make($request->all(), $rules);

        //     // カスタム属性名を設定
        // $validator->setAttributeNames([
        //     'password_' . $id => 'パスワード',
        //     'name_' . $id => '氏名',
        //     'kana_name_' . $id => 'カナ氏名',
        //     'email_' . $id => 'メールアドレス',
        //     'int_phone_' . $id => '内線電話番号',
        //     'ext_phone_' . $id => '外線電話番号',
        //     'role_id_' . $id => '権限',
        //     'affiliation1_id_' . $id => '[所属]会社',
        //     'department_id_' . $id => '[所属]部署',
        //     'affiliation3_id_' . $id => '[所属]部門',
        //     'employee_status_id_' . $id => '在職状態',
        //     'is_enabled_' . $id => '有効フラグ',
        //     // 他の属性も必要に応じて追加
        // ]);


        // if ($validator->fails()) {
        //     // バリデーションエラーが発生した場合
        //     session()->flash('error', '入力内容にエラーがあります。');
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // $user=user::find($id);
        // $user->user_name = $request->input('user_name_' . $id);
        // $user->user_kana_name = $request->input('user_kana_name_' . $id);
        // $user->email = $request->input('email_' . $id);
        // $user->int_phone = $request->input('int_phone_' . $id);
        // $user->ext_phone = $request->input('ext_phone_' . $id);
        // $user->affiliation1_id = $request->input('affiliation1_id_' . $id);
        // $user->department_id = $request->input('department_id_' . $id);
        // $user->affiliation3_id = $request->input('affiliation3_id_' . $id);
        // $user->employee_status_id = $request->input('employee_status_id_' . $id);
        // $user->user_num = $request->input('user_num_' . $id);
        // $user->is_enabled = $request->input('is_enabled_' . $id);
        // $user->access_ip = $request->ip();

        // if($request->filled('password_' . $id))
        // { // パスワード入力があるときだけ変更
        //     $user->password = bcrypt($request->input('password_' . $id));
        // }

        // $user=user::find($id);
        // $user->user_name = $request->input('user_name_' . $id);
        // $user->user_kana_name = $request->input('user_kana_name_' . $id);
        // $user->email = $request->input('email_' . $id);
        // $user->int_phone = $request->input('int_phone_' . $id);
        // $user->ext_phone = $request->input('ext_phone_' . $id);
        // $user->affiliation1_id = $request->input('affiliation1_id_' . $id);
        // $user->department_id = $request->input('department_id_' . $id);
        // $user->affiliation3_id = $request->input('affiliation3_id_' . $id);
        // $user->employee_status_id = $request->input('employee_status_id_' . $id);
        // $user->user_num = $request->input('user_num_' . $id);
        // $user->is_enabled = $request->input('is_enabled_' . $id);
        // $user->access_ip = $request->ip();

        // if($request->filled('password_' . $id))
        // { // パスワード入力があるときだけ変更
        //     $user->password = bcrypt($request->input('password_' . $id));
        // }

        $userNum =  str_pad($request->user_num, 6, '0', STR_PAD_LEFT);

        // プロフ画像のファイル名を生成
        if ($request->hasFile('profile_image')) {
            $extension = $request->profile_image->extension();
            $fileName = $userNum . '_' . 'profile' . '.' . $extension;
            $imagePath = $request->file('profile_image')->storeAs('users/profile_image', $fileName, 'public');
        } else {
            $imagePath = 'users/profile_image/default.png'; // ファイルがアップロードされなかった場合はデフォルトを設定する
        }
        

        $user = User::find($user->id);
        $user->user_name = $request->user_name;
        $user->user_kana_name = $request->user_kana_name;
        $user->email = $request->email;
        $user->int_phone = $request->int_phone;
        $user->ext_phone = $request->ext_phone;
        $user->affiliation1_id = $request->affiliation1_id;
        $user->department_id = $request->department_id;
        $user->affiliation3_id = $request->affiliation3_id;
        $user->employee_status_id = $request->employee_status_id;
        $user->user_num = $userNum;
        $user->is_enabled = $request->is_enabled;
        $user->password_change_required = $request->password_change_required;
        $user->birth = $request->birth;
        $user->profile_image = $imagePath;
        $user->access_ip = $request->ip();

        // if($request->filled('password_' . $id))
        // { // パスワード入力があるときだけ変更
        //     $user->password = bcrypt($request->input('password_' . $id));
        // }

        $user->save();
        return redirect()->back()->with('success','正常に更新しました');
    }

    public function destroy(string $id)
    {
        $user = user::find($id);
        $user->delete();

        $name = $user->name;
        return redirect()->back()->with('success', $name . 'を正常に削除しました');
    }

    public function upload(CsvUploadRequest $request)
    {
        $csvFile = $request->file('csv_upload');
        
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

            $user->user_num = str_pad($row[0], 6, '0', STR_PAD_LEFT);
            $user->user_name = $row[1];
            $user->user_kana_name = $row[2];
            $user->email = $row[3];
            $user->ext_phone = $row[4];
            $user->int_phone = $row[5];
            $user->password = bcrypt($row[6]);

            $user->affiliation1_id = $row[7];
            
            $user->department_id = $row[8];
            
            $affiliation3Code = $row[9];
            $affiliation3 = Affiliation3::where('affiliation3_code', $affiliation3Code)->first();
            if ($affiliation3) {
                $user->affiliation3_id = $affiliation3->id;
            } else {
                // affiliation3が見つからない場合のエラーハンドリング
            }

            $employeeStatusNum = $row[11];
            $employee_status = EmployeeStatus::where('employee_status_num', $employeeStatusNum)->first();
            if ($employee_status) {
                $user->employee_status_id = $employee_status->id;
            } else {
                // affiliation3が見つからない場合のエラーハンドリング
            }
            $user->is_enabled = $row[12];
            $user->save();
        });

        $lexer->parse($csvPath, $interpreter);
    }

    public function showUploadForm()
    {
        return view('admin.user.upload-form');
    }

    public function searchUsers(Request $request)
    {
        // $term = $request->input('q'); // Select2からの検索クエリ

        // // 検索クエリがない場合は全てのユーザーを取得
        // if (empty($term)) {
        //     $users = User::all();
        // } else {
        //     // もし検索クエリがある場合は、部分一致でユーザーを検索
        //     $users = User::where('name', 'like', '%' . $term . '%')->get();
        // }
    
        // return response()->json($users);

        $query = $request->input('query');
        $affiliation1Id = $request->input('affiliation1_id');
        $departmentId = $request->input('department_id');
        $affiliation3Id = $request->input('affiliation3_id');


        $users = User::with('affiliation1','department','affiliation3')
        ->where('user_name', 'like', '%' . $query . '%')
        ->where('affiliation1_id', 'like', '%' . $affiliation1Id . '%')
        ->where('department_id', 'like', '%' . $departmentId . '%')
        ->where('affiliation3_id', 'like', '%' . $affiliation3Id . '%')
        ->where('employee_status_id', 1) // 退職者を除外する条件を追加
        ->where('id', '!=', 1)// システム管理者を除外する条件を追加
        ->get();
        // 検索結果をJSON形式で返す
        return response()->json($users);
    }
}
