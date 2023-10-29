<?php

namespace App\Http\Controllers;

use App\Models\ClientProduct;
use Illuminate\Http\Request;

class ClientProductController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0|max:99',
            'product_version_id' => 'required|exists:product_versions,id',
            'is_customized' => 'boolean',
            'is_contracted' => 'boolean',
            'install_memo' => 'string',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ]);
    
        $clientProduct = ClientProduct::create($data);
    
        return "データを中間テーブルに挿入しました。";
    }

    public function show(ClientProduct $clientProduct)
    {
        //
    }

    public function edit(ClientProduct $clientProduct)
    {
        //
    }

    public function update(Request $request, ClientProduct $clientProduct)
    {
        //
    }

    public function destroy(ClientProduct $clientProduct)
    {
        //
    }
}
