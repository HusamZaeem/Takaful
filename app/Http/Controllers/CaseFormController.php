<?php

namespace App\Http\Controllers;

use App\Models\CaseForm;
use App\Models\CaseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CaseFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }



        /**
         * Display the dashboard with user's cases.
         */
        public function dashboard()
        {
            $userId = Auth::user()->user_id;

            $cases = CaseForm::with('caseTypes')
                        ->where('user_id', $userId)
                        ->orderBy('created_at', 'desc')
                        ->get();

            return view('dashboard', compact('cases'));
        }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $caseTypes = CaseType::all();
        return view('case.registration', compact('caseTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'incident_date' => 'required|date',
            'short_description' => 'required|string|max:1000',
            'notes' => 'nullable|string',
            'case_types' => 'required|array|min:1',
            'case_types.*' => 'exists:case_types,case_type_id',
        ]);

        $user = Auth::user();

        $requiredFields = [
            'first_name', 'last_name', 'email', 'phone', 'gender',
            'date_of_birth', 'nationality', 'id_number', 'marital_status',
            'residence_place', 'street_name', 'building_number', 'city', 'ZIP'
        ];

        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (empty($user->$field)) {
                $missingFields[] = ucwords(str_replace('_', ' ', $field));
            }
        }

        if (!empty($missingFields)) {
            return back()->withErrors([
                'personal_info' => 'Please complete the following profile fields before submitting a case: ' . implode(', ', $missingFields)
            ])->withInput();
        }

        DB::transaction(function () use ($request, $user) {
            $case = CaseForm::create([
                'user_id' => $user->user_id,
                'incident_date' => $request->incident_date,
                'short_description' => $request->short_description,
                'notes' => $request->notes,
            ]);

            $case->caseTypes()->attach($request->case_types);
        });

        return redirect()->route('dashboard')->with('success', 'Your case has been successfully registered!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $case = CaseForm::where('user_id', Auth::id())->where('case_id', $id)->with('caseTypes')->firstOrFail();

        if ($case->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'Only pending cases can be edited.');
        }

        $caseTypes = CaseType::all();
        $selectedTypes = $case->caseTypes->pluck('case_type_id')->toArray();

        return view('case.registration', compact('case', 'caseTypes', 'selectedTypes'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'incident_date' => 'required|date',
            'short_description' => 'required|string|max:1000',
            'notes' => 'nullable|string',
            'case_types' => 'required|array|min:1',
            'case_types.*' => 'exists:case_types,case_type_id',
        ]);

        $case = CaseForm::where('user_id', Auth::id())->where('case_id', $id)->firstOrFail();

        if ($case->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'Only pending cases can be edited.');
        }

        DB::transaction(function () use ($request, $case) {
            $case->update([
                'incident_date' => $request->incident_date,
                'short_description' => $request->short_description,
                'notes' => $request->notes,
            ]);

            $case->caseTypes()->sync($request->case_types);
        });

        return redirect()->route('dashboard')->with('success', 'Case updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $case = CaseForm::where('user_id', Auth::id())
                        ->where('case_id', $id)
                        ->firstOrFail();

        if ($case->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'Only pending cases can be deleted.');
        }

        $case->caseTypes()->detach();
        $case->delete();

        return redirect()->route('dashboard')->with('success', 'Case deleted successfully!');
    }

}
