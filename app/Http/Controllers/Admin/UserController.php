<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $admin = Auth::guard('admin')->user(); // Retrieve the authenticated admin

        
        $users = User::latest()->get();

    
        return view('admin.panel', compact('users', 'admin'));
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
    public function show(string $id)
{
    $user = User::findOrFail($id);

    return response()->json([
        'first_name' => $user->first_name,
        'father_name' => $user->father_name,
        'grandfather_name' => $user->grandfather_name,
        'last_name' => $user->last_name,
        'email' => $user->email,
        'phone' => $user->phone,
        'gender' => $user->gender,
        'date_of_birth' => $user->date_of_birth,
        'nationality' => $user->nationality,
        'id_number' => $user->id_number,
        'marital_status' => $user->marital_status,
        'residence_place' => $user->residence_place,
        'street_name' => $user->street_name,
        'building_number' => $user->building_number,
        'city' => $user->city,
        'ZIP' => $user->ZIP,
        'profile_picture' => $user->profile_picture ? asset('storage/' . $user->profile_picture) : null,
        'created_at' => $user->created_at->format('F j, Y'),
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.panel', ['section' => 'users'])
                        ->with('success', 'User deleted.');
    }




}