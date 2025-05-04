<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Jobs\SendLoginInformationJob;
use App\Mail\SendLoginInformation;
use App\Models\Affiliation1;
use App\Models\Affiliation2;
use App\Models\Affiliation3;
use App\Models\User;
use App\Models\Role;
use App\Models\EmployeeStatus;
use App\Models\RoleGroup;
use App\Models\UserRolegroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)//検索用にrequestを受取る
    {
        $per_page = config('constants.perPage');
        $users = User::with(['affiliation1', 'affiliation2', 'affiliation3', 'employeeStatus']);
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();
        $employeeStatuses = EmployeeStatus::all();


        //検索フォームに入力された値を取得
        $filters = $request->only(['user_num', 'user_name', 'affiliation2_id','employee_status_ids']);

        // 同じ条件を別の変数にも格納(画面の検索条件入力欄にセットするために利用する)
        $userNum = $filters['user_num'] ?? null;
        $userName = $filters['user_name'] ?? null;
        $affiliation2Id = $filters['affiliation2_id'] ?? null;
        $employeeStatusIds = $filters['employee_status_ids'] ?? [];


        //検索Query
        $query = User::query();

        // ここでEagerロードを設定
        $query->with(['affiliation1', 'affiliation2', 'affiliation3', 'employeeStatus', 'updatedBy']);

        // システム管理者でない場合は、id1のユーザーを非表示にする
        if (!$this->isSysAdmin()) {
            $query->where('id', '!=', 1);
        }

        //もし社員番号があれば
        if(!empty($userNum))
        {
            // $query->where('user_num','like',"%{$userNum}%");
            $query->where('user_num','LIKE', '%' . $userNum . '%');
        }

        if(!empty($affiliation2Id))
        {
            $query->where('affiliation2_id','=',$affiliation2Id);
        }

        //もしユーザ名があれば
        if($userName)
        {
            $spaceConversion = mb_convert_kana($userName, 's'); //全角スペース⇒半角スペースへ変換
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) 
            {
                $query->where('user_name', 'like', "%{$value}%");
            }
        }
        
        //もし在職状態があれば
        if(!empty($employeeStatusIds))
        {
            $query->whereIn('employee_status_id', $employeeStatusIds);
        }

        $users = $query->sortable()->paginate($per_page);
        $count = $users->total();

        return view('admin.user.index',compact('users', 'employeeStatuses', 'userNum', 'userName', 'count', 'affiliation1s','affiliation2s','affiliation3s','employeeStatusIds','affiliation2Id', 'filters'));
    }

    private function isSysAdmin()
    {
        return Auth::check() && Auth::user()->id === 1;
    }
    


    public function create()
    {
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();
        $roles = Role::orderBy('id','desc')->get();
        $e_statuses = EmployeeStatus::orderBy('id','asc')->get();
        $maxlength = config('constants.int_phone_maxlength');


        return view('admin.user.create',compact('roles','e_statuses','affiliation1s','affiliation2s','affiliation3s','maxlength'));
    }

    public function store(UserStoreRequest $request)
    {
        // 社員番号の頭0埋め6桁にする
        $userNum =  str_pad($request->user_num, 6, '0', STR_PAD_LEFT);

        // プロフ画像のファイル名を生成
        if ($request->filled('cropped_profile_image')) {
            // エンコードされた画像データを取得
            $encodedImage = $request->cropped_profile_image;
            
            // データURIスキームから拡張子を取得
            preg_match('#^data:image/(\w+);base64,#i', $encodedImage, $matches);
            $extension = $matches[1];

            // エンコードされた画像データをデコード
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $encodedImage));

            // ファイル名を生成
            $fileName = $userNum . '_' . 'profile' . '.' . $extension;
            $imagePath = 'users/profile_image/' . $fileName;

            // 画像を保存
            Storage::disk('public')->put($imagePath, $decodedImage);

        } else {
            $profileImagePath = 'users/profile_image/default.png'; // ファイルがアップロードされなかった場合はデフォルトを設定する
        }

        if ($request->filled('cropped_user_stamp_image')) {
            // エンコードされた画像データを取得
            $encodedImage = $request->cropped_user_stamp_image;
            
            // データURIスキームから拡張子を取得
            preg_match('#^data:image/(\w+);base64,#i', $encodedImage, $matches);
            $extension = $matches[1];

            // エンコードされた画像データをデコード
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $encodedImage));

            // ファイル名を生成
            $fileName = $userNum . '_' . 'stamp' . '.' . $extension;
            $imagePath = 'users/stamp_image/' . $fileName;

            // 画像を保存
            Storage::disk('public')->put($imagePath, $decodedImage);

        } else {
            $stampImagePath = 'users/stamp_image/default_user_stamp.png'; // ファイルがアップロードされなかった場合はデフォルトを設定する
        }

        // // パスワード作成（生年月日8桁＋A%＋携帯番号下4桁）
        // $birth = str_replace('-', '', $request->birth); // 生年月日からハイフンを削除する
        // $phoneLast4Digits = substr($request->ext_phone, -4); // 携帯番号から下4桁を取得する
        // $password = $birth . 'A%' . $phoneLast4Digits;
        $password = $this->generateTemporaryPassword($request->birth, $request->ext_phone);

        $user = new User();
        $user->user_num = $userNum;
        $user->user_name = $request->user_name;
        $user->user_kana_name = $request->user_kana_name;
        $user->email = $request->email;
        $user->int_phone = $request->int_phone;
        $user->ext_phone = $request->ext_phone;
        $user->birth = $request->birth;
        $user->affiliation1_id = $request->affiliation1_id;
        $user->affiliation2_id = $request->affiliation2_id;
        $user->affiliation3_id = $request->affiliation3_id;
        $user->employee_status_id = $request->employee_status_id;
        $user->is_enabled = $request->is_enabled;
        $user->password = bcrypt($password);
        $user->profile_image = $profileImagePath;
        $user->user_stamp_image = $stampImagePath;
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
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();
        $e_statuses = EmployeeStatus::all();
        $user_e_status = $user->employee_status_id;

        // 参照中のユーザに紐づく権限グループのIDを取得
        $roleGroupIdsQuery = DB::table('user_rolegroup')
        ->where('user_id', $user->id)
        ->pluck('role_group_id');

        // 権限グループモデルからIDが$roleGroupIdsQueryに含まれる権限グループを取得
        $roleGroups = RoleGroup::whereIn('id', $roleGroupIdsQuery)->get();

        $maxlength = config('constants.int_phone_maxlength');

        return view('admin.user.edit',compact('user', 'e_statuses', 'user_e_status', 'affiliation1s', 'affiliation2s', 'affiliation3s', 'maxlength', 'roleGroups',));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $userNum =  str_pad($request->user_num, 6, '0', STR_PAD_LEFT);

        $user = User::find($user->id);

        if ($request->filled('cropped_profile_image')) {
            // エンコードされた画像データを取得
            $encodedImage = $request->cropped_profile_image;
            
            // データURIスキームから拡張子を取得
            preg_match('#^data:image/(\w+);base64,#i', $encodedImage, $matches);
            $extension = $matches[1];

            // エンコードされた画像データをデコード
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $encodedImage));

            // ファイル名を生成
            $fileName = $userNum . '_' . 'profile' . '.' . $extension;
            $imagePath = 'users/profile_image/' . $fileName;

            // 画像を保存
            Storage::disk('public')->put($imagePath, $decodedImage);

            // ユーザーのプロフィール画像を更新
            $user->profile_image = $imagePath;
        }


        if ($request->filled('cropped_user_stamp_image')) {
            // エンコードされた画像データを取得
            $encodedImage = $request->cropped_user_stamp_image;
            
            // データURIスキームから拡張子を取得
            preg_match('#^data:image/(\w+);base64,#i', $encodedImage, $matches);
            $extension = $matches[1];

            // エンコードされた画像データをデコード
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $encodedImage));

            // ファイル名を生成
            $fileName = $userNum . '_' . 'stamp' . '.' . $extension;
            $imagePath = 'users/stamp_image/' . $fileName;

            // 画像を保存
            Storage::disk('public')->put($imagePath, $decodedImage);

            // ユーザーの印鑑画像を更新
            $user->user_stamp_image = $imagePath;
        }

        $user->user_name = $request->user_name;
        $user->user_kana_name = $request->user_kana_name;
        $user->email = $request->email;
        $user->int_phone = $request->int_phone;
        $user->ext_phone = $request->ext_phone;
        $user->affiliation1_id = $request->affiliation1_id;
        $user->affiliation2_id = $request->affiliation2_id;
        $user->affiliation3_id = $request->affiliation3_id;
        $user->employee_status_id = $request->employee_status_id;
        $user->user_num = $userNum;
        $user->is_enabled = $request->is_enabled;
        $user->password_change_required = $request->password_change_required;
        $user->birth = $request->birth;
        $user->access_ip = $request->ip();
        $user->save();

        // if($request->filled('password_' . $id))
        // { // パスワード入力があるときだけ変更
        //     $user->password = bcrypt($request->input('password_' . $id));
        // }

        if ($request->password_change_required)
        {
            // ログイン情報メールを送信する

            // アプリケーションのURLを取得する
            $url = config('app.url');

            // パスワード作成（生年月日8桁＋A%＋携帯番号下4桁）
            // $birth = str_replace('-', '', $request->birth); // 生年月日からハイフンを削除する
            // $phoneLast4Digits = substr($request->ext_phone, -4); // 携帯番号から下4桁を取得する
            // $password = $birth . 'A%' . $phoneLast4Digits;
            $password = $this->generateTemporaryPassword($request->birth, $request->ext_phone);

            SendLoginInformationJob::dispatch($url, $request->email, $password, $request->locale ?? 'ja');
        }



        return redirect()->back()->with('success','正常に更新しました');
    }

    public function destroy(string $id)
    {
        $user = user::find($id);
        $user->delete();

        $name = $user->name;
        return redirect()->back()->with('success', $name . 'を正常に削除しました');
    }

    public function bulkDelete(Request $request)
    {
        $selectedIds = $request->input('selectedIds', []);
    
        if (empty($selectedIds)) {
            return redirect()->back()->with('error', '削除するレコードが選択されていません');
        }
    
        // 削除できないユーザーのIDを取得（在職中のユーザー）
        $usersInOffice = User::whereIn('id', $selectedIds)
            ->where('employee_status_id', 1)
            ->pluck('id')
            ->toArray();
    
        // 削除可能なユーザーのIDを取得（在職中でないユーザー）
        $usersToDelete = array_diff($selectedIds, $usersInOffice);
    
        if (!empty($usersToDelete)) {
            User::whereIn('id', $usersToDelete)->delete();
        }
    
        // メッセージを設定
        if (!empty($usersInOffice)) {
            return redirect()->back()->with('error', '在職中のユーザーが含まれていたため、一部削除できませんでした。');
        }
    
        return redirect()->back()->with('success', '選択されたユーザーを削除しました');
    }

    // 仮で作成 ログが発火しない
    public function bulkDisable(Request $request)
    {
        $selectedIds = $request->input('selectedIds', []);

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', '対象ユーザーが選択されていません。');
        }

        // 一括で更新
        $users = User::whereIn('id', $selectedIds)->get();

        foreach ($users as $user) {
            $user->is_enable = 0;
            $user->save(); // イベント発火、1回のSELECT＋N回のUPDATE
        }

        // User::whereIn('id', $selectedIds)->update(['is_enabled' => 1]);

        return redirect()->back()->with('success', '選択されたユーザーを無効にしました。');
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
            
            $user->affiliation2_id = $row[8];
            
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
        $userName = $request->user_name;
        $affiliation1Id = $request->affiliation1_id;
        $affiliation2Id = $request->affiliation2_id;
        $affiliation3Id = $request->affiliation3_id;

        // クエリ作成
        $query = User::with('affiliation1', 'affiliation2', 'affiliation3')
            ->where('employee_status_id', 1) // 退職者を除外
            ->where('role', '!=', 'system_admin'); // システム管理者を除外

        if (!empty($userName)){
            $query->where('user_name', 'like', '%' . $userName . '%');
        }
        if (!empty($affiliation1Id)){
            $query->where('affiliation1_id', $affiliation1Id);
        }
        if (!empty($affiliation2Id)){
            $query->where('affiliation2_id', $affiliation2Id);
        }
        if (!empty($affiliation3Id)){
            $query->where('affiliation3_id', $affiliation3Id);
        }

        // クエリ実行
        $users = $query->get();

        // 検索結果をJSON形式で返す
        return response()->json($users);
    }

    public function searchUsers2(Request $request)
    {
        $search = $request->input('query', '');
        $users = User::where('name', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%")
                     ->limit(50)
                     ->get(['id', 'name', 'email']);
        
        return response()->json($users);
    }

    public function addGroupsToUser(Request $request)
    {
        // クライアントからのリクエストからグループIDとユーザIDリストを取得
        $userId = $request->input('user_id');
        $roleGroupIds = $request->input('role_group_ids');
    
        // roleGroupIds が NULL でないことを確認し、ループ処理を行う
        if (!is_null($roleGroupIds)) {
            // ユーザIDリストをループし、中間テーブルに登録
            foreach ($roleGroupIds as $roleGroupId) {
                // 既存の中間テーブルに同じ組み合わせが存在するかチェック
                $existingRecord = UserRolegroup::where('user_id', $userId)
                    ->where('role_group_id', $roleGroupId)
                    ->exists();
        
                // 既存のレコードが存在しない場合のみ新しいレコードを作成
                if (!$existingRecord) {
                    UserRolegroup::create([
                        'user_id' => $userId,
                        'role_group_id' => $roleGroupId
                    ]);
                }
            }
        
            // 登録が成功した場合は成功レスポンスを返す
            // return response()->json(['message' => 'Users added to group successfully'], 200);
            return redirect()->back()->with('success', '正常に権限グループを紐づけました');
        } else {
            // roleGroupIds が NULL の場合、何もせずにエラーレスポンスを返す
            // return response()->json(['error' => 'User IDs are required'], 400);
            return redirect()->back()->with('error', '権限グループIDが必要です');
        }
    }
}
