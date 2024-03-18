<?php

namespace App\Http\Controllers;

use App\Models\Keepfile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class KeepfileController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 15;
        $user = auth()->user();
        $users = User::all();
        
        // フィルタリングクエリを作成
        $query = Keepfile::where('user_id', $user->id)->sortable()->with('user','project');
    
        // 検索フォームの値を取得する
        $projectNum = $request->input('project_num');
        $clientName = $request->input('client_name');
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
        $inputs = $request->validate([
            'project_id'=>'required',
            'purpose'=>'required|max:255',
            'keep_at'=>'required|max:10',
            'return_at'=>'required|max:10',
            'keepfile_memo'=>'max:255',
            'pdf_file' => ['nullable', 'max:1024', 'mimes:pdf'],
        ]);

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
        $keepfile->user_id = auth()->user()->id;
        $keepfile->save();
        return redirect()->route('keepfile.index')->with('success','正常に登録しました');
    }

    public function show($id)
    {

    }

    public function edit(string $id)
    {
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
                // ファイルサイズを MB に変換
                $fileSizeMB = $fileSize / (1024 * 1024);
                // ファイルサイズを人間が読みやすい形式に変換
                $formattedFileSize = $this->formatBytes($fileSizeMB);
            }
        }
    
        return view('keepfile.edit', compact('keepfile', 'fileName', 'formattedFileSize'));
    }
    
    /**
     * ファイルサイズを人間が読みやすい形式に変換します
     *
     * @param float $bytes ファイルサイズ (MB 単位)
     * @return string 人間が読みやすい形式に変換されたファイルサイズ
     */
    private function formatBytes(float $bytes): string
    {
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' GB';
        } elseif ($bytes >= 1) {
            return number_format($bytes, 2) . ' MB';
        } else {
            return number_format($bytes * 1024, 0) . ' KB';
        }
    }

    public function update(Request $request, string $id)
    {
        $keepfile = keepfile::find($id);

        $request->validate([
            'project_id'=>'required',
            'purpose'=>'required|max:255',
            'keep_at'=>'required|max:10',
            'return_at'=>'required|max:10',
            'keepfile_memo'=>'max:255',
            'pdf_file' => ['nullable', 'max:1024', 'mimes:pdf'],
        ]);

        // 新しいPDFファイルがアップロードされた場合は処理する
        if ($request->hasFile('pdf_file')) {
            // 古いPDFファイルを削除
            if ($keepfile->pdf_file) {
                Storage::disk('public')->delete($keepfile->pdf_file);
            }

            $fileName = $request->project_num . '_' . $request->project->client->client_name . '_' . $request->return_at . '_' . now()->format('YmdHis') . '.pdf';

        // ファイルを指定した名前で保存
        $pdfFilePath = $request->file('pdf_file')->storeAs('keepfiles/pdf', $fileName, 'public');
            $keepfile->pdf_file = $pdfFilePath;
        }

        $keepfile->project_id = $request->project_id;
        $keepfile->purpose = $request->purpose;
        $keepfile->keep_at = $request->keep_at;
        $keepfile->return_at = $request->return_at;
        $keepfile->keepfile_memo = $request->keepfile_memo;
        $keepfile->is_finished = $request->is_finished;
        $keepfile->user_id = auth()->user()->id;
        $keepfile->save();
        return redirect()->route('keepfile.edit',$id)->with('success','正常に更新しました');
    }

    public function destroy(string $id)
    {
        $keepfile = keepfile::find($id);
        $keepfile->delete();
        return redirect()->route('keepfile.index')->with('success', '正常に削除しました');
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
