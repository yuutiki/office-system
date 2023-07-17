<?php

namespace App\Http\Controllers;

use App\Models\Report;//add
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request , $reportId)
    {
        $report = Report::find($reportId);

        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->report_id = $report->id;
        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->back()->with('message','コメントが投稿されました');
    }


    // 投稿に対するコメントを表示する
    public function show($reportId)
    {
        $report = Report::findOrFail($reportId);
        return view('comment.show', compact('report'));
    }

    public function edit(Comment $comment)
    {
        //
    }

    public function update(Request $request, Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        //
    }
}
