<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;

class EstimateController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('estimate.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Estimate $estimate)
    {
        //
    }

    public function edit(Estimate $estimate)
    {
        //
    }

    public function update(Request $request, Estimate $estimate)
    {
        //
    }

    public function destroy(Estimate $estimate)
    {
        //
    }
}
