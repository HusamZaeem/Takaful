<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminPanelController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.panel', [
            'admin' => $admin,
            'canViewCases' => in_array($admin->role->type, ['Cases Manager', 'General Manager']),
            'canViewDonations' => in_array($admin->role->type, ['Donations Manager', 'General Manager']),
        ]);
    }
}
