<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientPerson;
use App\Models\Department;
use App\Models\Prefecture;
use Illuminate\Http\Request;

class ClientPersonController extends Controller
{
    public function index()
    {
        $clientPersons = ClientPerson::with(['client'])->orderBy('client_id','asc')->paginate();

        $count = $clientPersons->total();

        return view('client-person.index', compact('clientPersons', 'count'));
    }

    public function create()
    {
        $prefectures = Prefecture::all();
        $departments = Department::all();
        return view('client-person.create', compact('prefectures', 'departments'));
    }

    public function store(Request $request)
    {
        ////以下にFormRequestのバリデーションを通過した場合の処理を記述////
        $request->validate([
            // 'tel1' => 'required',
            // 'last_name' => 'required'
        ]);

        $inputPost = $request->head_post_code;
        $formattedPost = Client::formatPostCode($inputPost);

        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');

        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        // 顧客データを保存
        $clientPerson = new ClientPerson();

        $clientPerson->client_id = $clientId; // 取得したclient_id
        $clientPerson->last_name = $request->last_name;
        $clientPerson->first_name = $request->first_name;
        $clientPerson->last_name_kana = $request->last_name_kana;
        $clientPerson->first_name_kana = $request->first_name_kana;
        $clientPerson->division_name = $request->division_name;
        $clientPerson->position_name = $request->position_name;
        $clientPerson->tel1 = $request->tel1;
        $clientPerson->tel2 = $request->tel2;
        $clientPerson->fax1 = $request->fax1;
        $clientPerson->fax2 = $request->fax2;
        $clientPerson->int_tel = $request->int_tel;
        $clientPerson->phone = $request->phone;
        $clientPerson->mail = $request->mail;

        $clientPerson->head_post_code = $request->head_post_code; //変換後の郵便番号をセット
        $clientPerson->prefecture_id = $request->head_prefecture;
        $clientPerson->head_address1 = $request->head_addre1;
        $clientPerson->person_memo = $request->person_memo;

        $clientPerson->is_retired = $request->has('is_retired') ? 1 : 0;
        $clientPerson->is_billing_receiver = $request->has('is_billing_receiver') ? 1 : 0;
        $clientPerson->is_payment_receiver = $request->has('is_payment_receiver') ? 1 : 0;
        $clientPerson->is_support_info_receiver = $request->has('is_support_info_receiver') ? 1 : 0;
        $clientPerson->is_closing_info_receiver = $request->has('is_closing_info_receiver') ? 1 : 0;
        $clientPerson->is_exhibition_info_receiver = $request->has('is_exhibition_info_receiver') ? 1 : 0;
        $clientPerson->is_cloud_info_receiver = $request->has('is_cloud_info_receiver') ? 1 : 0;
        $clientPerson->save();

        return redirect()->back()->with('success', '正常に登録しました');
    }

    public function show(ClientPerson $clientPerson)
    {
        //
    }

    public function edit(ClientPerson $clientPerson)
    {
        $prefectures = Prefecture::all();
        $departments = Department::all();
        return view('client-person.edit', compact('prefectures', 'departments', 'clientPerson'));
    }

    public function update(Request $request, ClientPerson $clientPerson)
    {
            // FormRequestのバリデーションを通過した場合の処理を記述
    $request->validate([
        // 'tel1' => 'required',
        // 'last_name' => 'required'
    ]);

    $inputPost = $request->head_post_code;
    $formattedPost = Client::formatPostCode($inputPost);

    // フォームからの値を変数に格納
    $clientNum = $request->input('client_num');

    // client_numからclient_idを取得する
    $client = Client::where('client_num', $clientNum)->first();
    $clientId = $client->id;

    // 顧客データを更新
    // $clientPerson = ClientPerson::find($id);

    $clientPerson->client_id = $clientId; // 取得したclient_id
    $clientPerson->last_name = $request->last_name;
    $clientPerson->first_name = $request->first_name;
    $clientPerson->last_name_kana = $request->last_name_kana;
    $clientPerson->first_name_kana = $request->first_name_kana;
    $clientPerson->division_name = $request->division_name;
    $clientPerson->position_name = $request->position_name;
    $clientPerson->tel1 = $request->tel1;
    $clientPerson->tel2 = $request->tel2;
    $clientPerson->fax1 = $request->fax1;
    $clientPerson->fax2 = $request->fax2;
    $clientPerson->int_tel = $request->int_tel;
    $clientPerson->phone = $request->phone;
    $clientPerson->mail = $request->mail;

    $clientPerson->head_post_code = $request->head_post_code; // 変換後の郵便番号をセット
    $clientPerson->prefecture_id = $request->head_prefecture;
    $clientPerson->head_address1 = $request->head_addre1;
    $clientPerson->person_memo = $request->person_memo;

    $clientPerson->is_retired = $request->has('is_retired') ? 1 : 0;
    $clientPerson->is_billing_receiver = $request->has('is_billing_receiver') ? 1 : 0;
    $clientPerson->is_payment_receiver = $request->has('is_payment_receiver') ? 1 : 0;
    $clientPerson->is_support_info_receiver = $request->has('is_support_info_receiver') ? 1 : 0;
    $clientPerson->is_closing_info_receiver = $request->has('is_closing_info_receiver') ? 1 : 0;
    $clientPerson->is_exhibition_info_receiver = $request->has('is_exhibition_info_receiver') ? 1 : 0;
    $clientPerson->is_cloud_info_receiver = $request->has('is_cloud_info_receiver') ? 1 : 0;
    $clientPerson->save();

    return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ClientPerson $clientPerson)
    {
        $clientPerson->delete();
        return redirect()->route('client-person.index')->with('success', '正常に削除しました');
    }
}
