<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use App\Models\ProductType;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        $prefectures = Prefecture::all();
        $productTypes = ProductType::all();

        return view('masters.index', compact('prefectures','productTypes'));
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
