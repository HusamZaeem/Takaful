<?php

namespace App\Http\Controllers\Admin;

use App\Models\CaseForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cases = CaseForm::latest()->get();
        return view('admin.cases.index', compact('cases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        CaseForm::create($request->all());

        return redirect()->route('admin.cases.index')->with('success', 'Case created.');
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $case = CaseForm::findOrFail($id);
        return view('admin.cases.show', compact('case'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $case = CaseForm::findOrFail($id);
        return view('admin.cases.edit', compact('case'));
    }
    

    public function update(Request $request, $id)
    {
        $case = CaseForm::findOrFail($id);
        $case->update($request->all());
        return redirect()->route('admin.panel', ['section' => 'cases'])->with('success', 'Case updated.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $case = CaseForm::findOrFail($id);
        $case->delete();
        return redirect()->route('admin.panel', ['section' => 'cases'])->with('success', 'Case deleted.');
    }
}
