<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CaseForm;
use App\Models\Donation;

class AdminPanelController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Set the permissions based on the admin role
        $canViewUsers = in_array($admin->role->type, ['General Manager']);
        $canViewCases = in_array($admin->role->type, ['Cases Manager', 'General Manager']);
        $canViewDonations = in_array($admin->role->type, ['Donations Manager', 'General Manager']);

        // Get data if the admin has permissions
        $cases = $canViewCases ? CaseForm::with('user')->latest()->get() : collect();
        $donations = $canViewDonations ? Donation::with('user')->latest()->get() : collect();
        $users = User::latest()->get();

        // Set the default section based on permissions
        $defaultSection = null;

        if ($canViewUsers) {
            $defaultSection = 'users';
        } elseif ($canViewCases) {
            $defaultSection = 'cases';
        } elseif ($canViewDonations) {
            $defaultSection = 'donations';
        }

        // Get active section from URL query or default section
        $activeSection = $request->query('section', $defaultSection);

        return view('admin.panel', compact(
            'admin', 'cases', 'donations', 'users',
            'canViewCases', 'canViewDonations', 'canViewUsers', 'activeSection'
        ));
    }




    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.panel')->with('success', 'User deleted.');
    }




    public function deleteCase($id)
    {
        $case = CaseForm::findOrFail($id);
        $case->delete();

        return redirect()->route('admin.panel')->with('success', 'Case deleted.');
    }

    public function updateCase(Request $request, $id)
    {
        $case = CaseForm::findOrFail($id);
        $case->status = $request->input('status');
        $case->admin_note = $request->input('admin_note');
        $case->save();

        return redirect()->route('admin.panel')->with('success', 'Case updated.');
    }





    public function deleteDonation($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return redirect()->route('admin.panel')->with('success', 'Donation deleted.');
    }



    

    public function updateDonation(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        $donation->payment_status = $request->input('payment_status');
        $donation->notes = $request->input('notes');
        $donation->save();

        return redirect()->route('admin.panel')->with('success', 'Donation updated.');
    }




}
