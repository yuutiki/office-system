<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class DashboardController extends Controller
{
    public function index()
    {

        $clientCount = 0; // 仮の初期値
        $client = Client::where('trade_status_id','=','1')->get();
        $clientCount = $client->count();

        return view('dashboard', [
            'clientCount' => $clientCount
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
