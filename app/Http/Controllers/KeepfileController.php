<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeepfileStoreRequest;
use App\Http\Requests\KeepfileUpdateRequest;
use App\Models\Client;
use App\Models\Keepfile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use PDF;

class KeepfileController extends Controller
{
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');

        // 検索条件を取得してセッションに保存
        Session::put('search_params', $request->all());
        $searchParams = $request->session()->get('search_params', []);  

    
        // 検索フォームの値を取得する
        $projectNum = $request->input('project_num');
        $clientName = $request->input('client_name');
        $dayFrom = $request->input('day_from');
        $dayTo = $request->input('day_to');
        $selectedUserId = $request->selected_user_id;

        $loggedInUser = Auth::user();
        // UserモデルのisSystemAdmin()メソッドを呼び出す
        if ($loggedInUser && $loggedInUser->role ==  config('sytemadmin.system_admin')) {
            // システム管理者を含む全てのユーザーを取得
            $salesUsers = User::all();
        } else {
            // システム管理者を除くユーザーを取得
            $salesUsers = User::where('role', '!=', config('sytemadmin.system_admin'))->get();
        }

        // フィルタリングクエリを作成
        $keepfileQuery = Keepfile::sortable()->with('user', 'project', 'project.client');
    
        if (!empty($projectNum)) {
            // Project テーブルからプロジェクト番号を部分一致で検索して該当する ID を取得
            $projectIds = Project::where('project_num', 'like', "%{$projectNum}%")->pluck('id')->toArray();

            // 取得したプロジェクト ID を使って Keepfile テーブルを検索する
            $keepfileQuery->whereIn('project_id', $projectIds);
        }
    
        if (!empty($clientName)) {
            // 全角文字を半角に変換
            $spaceConversion = mb_convert_kana($clientName, 's');
            // 文字列を単語の配列に分割
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
    
            // クライアント名に基づいてクライアントを検索するクエリ
            $keepfileQuery->whereHas('project.client', function ($keepfileQuery) use ($wordArraySearched) {
                foreach ($wordArraySearched as $value) {
                    // 配列内のいずれかの単語に一致するクライアント名を検索
                    $keepfileQuery->where('client_name', 'like', '%' . $value . '%');
                }
            });
        }
    
        if (!empty($selectedUserId)) {
            $keepfileQuery->where('user_id', $selectedUserId);
        }
    
        if (!empty($dayFrom) && !empty($dayTo)) {
            $keepfileQuery->whereBetween('return_at', [$dayFrom, $dayTo]);
        }
    
        // 未返却のみのフィルタリング
        if (!$request->has('unreturned_only')) {
            $keepfileQuery->where('is_finished', 0);
        }
    
        // 検索結果を取得
        $keepfiles = $keepfileQuery->orderby('return_at', 'asc')->paginate($perPage);
        $count = $keepfiles->total();
    
        return view('keepfiles.index', compact('keepfiles', 'count', 'projectNum', 'clientName', 'selectedUserId', 'dayFrom', 'dayTo', 'salesUsers'));
    }


    public function create()
    {
        $users = User::all();
        return view('keepfiles.create',compact('users'));
    }

    public function store(KeepfileStoreRequest $request)
    {
        // ファイル名用に取得
        $ClientName = Project::where('id', $request->project_id)->first()->client->client_name;
    
        // PDFファイルがアップロードされた場合のみ保存する
        if ($request->hasFile('pdf_file')) {
            // ファイル名を生成
            $fileName = $request->project_num . '_' . $ClientName . '_' . $request->return_at . '_' . now()->format('YmdHis') . '.pdf';
            // ファイルを指定した名前で保存
            $pdfFilePath = $request->file('pdf_file')->storeAs('keepfiles/pdf', $fileName, 'public');
        } else {
            $pdfFilePath = null; // ファイルがアップロードされなかった場合はnullを保存する
        }

        $keepfile = new keepfile();
        $keepfile->project_id = $request->project_id;
        $keepfile->purpose = $request->purpose;
        $keepfile->keep_at = $request->keep_at;
        $keepfile->return_at = $request->return_at;
        $keepfile->keepfile_memo = $request->keepfile_memo;
        $keepfile->is_finished = $request->is_finished;
        $keepfile->pdf_file = $pdfFilePath;
        $keepfile->user_id = $request->depositor; // 取得者
        $keepfile->save();
        return redirect()->route('keepfiles.index')->with('success','正常に登録しました');
    }

    public function show($id)
    {

    }

    public function edit(string $id)
    {
        $users = User::all();
        $keepfile = keepfile::find($id);
    
        // ファイル名とファイルサイズの初期化
        $fileName = null;
        $formattedFileSize = null;
    
        // ファイルが添付されている場合のみ処理を行う
        if ($keepfile->pdf_file) {
            // ファイルのフルパスを取得
            $filePath = storage_path('app/public/' . $keepfile->pdf_file);
    
            // ファイルが存在するかチェック
            if (file_exists($filePath)) {
                // ファイル名を取得
                $fileName = basename($filePath);
                // ファイルサイズを取得 (ファイルサイズはバイト単位)
                $fileSize = filesize($filePath);
                // ファイルサイズを人間が読みやすい形式に変換
                $formattedFileSize = Number::fileSize($fileSize, precision: 2);
            }
        }
    
        return view('keepfiles.edit', compact('keepfile', 'fileName', 'formattedFileSize','users'));
    }
    
    public function update(KeepfileUpdateRequest $request, string $id)
    {
        $keepfile = keepfile::find($id);

        // 新しいPDFファイルがアップロードされた場合は処理する
        if ($request->hasFile('pdf_file')) {
            // 古いPDFファイルを削除
            if ($keepfile->pdf_file) {
                Storage::disk('public')->delete($keepfile->pdf_file);
            }

            // ファイル名用に取得
            $ClientName = Project::where('id', $request->project_id)->first()->client->client_name;

            $fileName = $request->project_num . '_' . $ClientName . '_' . $request->return_at . '_' . now()->format('YmdHis') . '.pdf';

            // ファイルを指定した名前で保存
            $pdfFilePath = $request->file('pdf_file')->storeAs('keepfiles/pdf', $fileName, 'public');
            $keepfile->pdf_file = $pdfFilePath;
        }

        $keepfile->purpose = $request->purpose;
        $keepfile->keep_at = $request->keep_at;
        $keepfile->return_at = $request->return_at;
        $keepfile->keepfile_memo = $request->keepfile_memo;
        $keepfile->is_finished = $request->is_finished;
        $keepfile->user_id = $request->depositor;
        $keepfile->save();
        return redirect()->route('keepfiles.edit',$id)->with('success','正常に更新しました');
    }

    public function destroy(string $id)
    {
        $keepfile = keepfile::find($id);
        $keepfile->delete();
        return redirect()->route('keepfiles.index')->with('success', '正常に削除しました');
    }

    public function deletePdf($id)
    {
        $keepfile = Keepfile::findOrFail($id);
    
        if ($keepfile->pdf_file) {
            // PDFファイルを削除
            Storage::disk('public')->delete($keepfile->pdf_file);
            // PDFファイルのパスをnullに更新
            $keepfile->pdf_file = null;
            $keepfile->save();
        }
    
        return back()->with('success', '添付ファイルを削除しました');
    }
}
