<?php

namespace App\Http\Controllers;

use App\Models\ProjectExpense;
use Illuminate\Http\Request;

class ProjectExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projectExpenses = ProjectExpense::with('project','user')->paginate();
        
        return view('project-expenses.index', compact('projectExpenses',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectExpense $projectExpense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectExpense $projectExpense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectExpense $projectExpense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectExpense $projectExpense)
    {
        //
    }
}
