<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;//add
use App\Models\Client;//add
use App\Models\Comment;//add
use Illuminate\Pagination\Paginator;//add

use Illuminate\Http\Request;


class ReportController extends Controller
{
    public function index()
    {
        $per_page = 25;
        $reports = Report::with('client')->sortable()->paginate($per_page);
        $count = $reports->count();
        $user = User::all();

        return view('report.index',compact('reports' , 'user' , 'count'));
    }

    public function create()
    {
        $users = User::all();
        return view('report.create',compact('users'));
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'content' => 'required',
        ];

        $request->validate($rules);

        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');

        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        $report = new Report();
        $report->client_id = $clientId;
        $report->contact_at = $request->input('contact_at');
        $report->type = $request->input('type');
        $report->title = $request->input('title');
        $report->contact_type = $request->input('contact_type');
        $report->content = $request->input('content');
        $report->notice = $request->input('notice');
        $report->client_representative = $request->input('client_representative');
        $report->user_id = auth()->id();//ログインユーザのIDを取得

        $report->save();


        // 選択された報告先ユーザを中間テーブルに登録
        $selectedRecipientsId = $request->input('selectedRecipientsId');
        $report->recipients()->attach($selectedRecipientsId);


        return redirect()->route('report.index')->with('message','報告を新規作成しました');
    }

    public function show($id)
    {
        $report = Report::find($id);
        $comments = $report->comments;
        return view('report.show',compact('report'));
    }

    // 顧客情報から飛ぶ画面
    public function showFromClient($id)
    {
        $report = Report::find($id);
        $comments = $report->comments;
        return view('report.show-from-client',compact('report'));
    }

    public function edit(report $report)
    {
        //
    }

    public function update(Request $request, report $report)
    {
        //
    }

    public function destroy(string $id)
    {
        $report = Report::find($id);
        $report->delete();
        return redirect()->back()->with('message', '削除しました');
    }

    //ユーザが報告先を選択した際に実行されるメソッド
    public function addReportToRecipient(Request $request,$userId)
    {
        $selectedRecipientsId = $request->input('selected_reports');

        if(!empty($selectedRecipientsId)){
            $user = User::find($userId);

            $user->reports()->attach($selectedRecipientsId);
        }

                // 登録後に適切なリダイレクト先にリダイレクトするなど、処理の終了を行う
        // 例えば、報告先が登録された後にユーザー詳細ページにリダイレクトする
        return redirect()->route('user.show', ['user' => $userId]);
    }
}
