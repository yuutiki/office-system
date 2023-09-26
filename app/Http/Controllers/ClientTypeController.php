<?php

namespace App\Http\Controllers;

use App\Models\ClientType;
use Illuminate\Http\Request;

class ClientTypeController extends Controller
{
    public function index()
    {
        return view('masters.client_type_index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ClientType $clientType)
    {
        //
    }

    public function edit(ClientType $clientType)
    {
        //
    }

    public function update(Request $request, ClientType $clientType)
    {
        //
    }

    public function destroy(ClientType $clientType)
    {
        //
    }
}
