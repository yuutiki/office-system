<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;
use PDF;

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

    public function generatePdf()
    {
        $data = [
            'atesaki' => '田中学園'
        ];
        //ここでviewに$dataを送っているけど、
        //今回$dataはviewで使わない
        $pdf = PDF::loadView('pdf.document', $data);

        return $pdf->stream('document.pdf'); //生成されるファイル名
    }
}
