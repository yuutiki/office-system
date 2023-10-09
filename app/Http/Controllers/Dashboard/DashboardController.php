<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Support;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $clientCount = 0; // 仮の初期値
        $client = Client::where('trade_status_id','=','1')
                    ->get();
        $clientCount = $client->count();

        $user = Auth::user();
        $receivedAtArray = [];
        if($user){
            $mySupports=Support::where('user_id', $user->id)
                        ->orderBy('received_at', 'desc')
                        ->take(5)
                        ->get();

            foreach($mySupports as $mySupport){
                $receivedAtArray[] = Carbon::parse($mySupport->received_at);
            }
        }

        return view('dashboard',compact('clientCount','mySupports','receivedAtArray'));
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
