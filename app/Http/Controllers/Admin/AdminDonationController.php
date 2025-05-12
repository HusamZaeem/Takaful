<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    
{

    $admin = Auth::guard('admin')->user();
    
    $query = Donation::with(['user', 'guestDonor'])->latest();

    $search = $request->input('search');
    $criteria = $request->input('criteria');

    if ($search) {
        $query->where(function ($q) use ($search, $criteria) {
            switch ($criteria) {
                case 'name':
                    $q->whereHas('user', fn($q) => $q->where('first_name', 'like', "%$search%")
                                                    ->orWhere('last_name', 'like', "%$search%"))
                      ->orWhereHas('guestDonor', fn($q) => $q->where('name', 'like', "%$search%"));
                    break;

                case 'email':
                    $q->whereHas('user', fn($q) => $q->where('email', 'like', "%$search%"))
                      ->orWhereHas('guestDonor', fn($q) => $q->where('email', 'like', "%$search%"));
                    break;

                case 'reference':
                    $q->where('payment_reference', 'like', "%$search%");
                    break;

                case 'status':
                    $q->where('payment_status', 'like', "%$search%");
                    break;

                case 'method':
                    $q->where('payment_method', 'like', "%$search%");
                    break;

                default:
                    // fallback: search all
                    $q->where('payment_reference', 'like', "%$search%")
                      ->orWhere('amount', 'like', "%$search%")
                      ->orWhere('currency', 'like', "%$search%")
                      ->orWhere('payment_method', 'like', "%$search%")
                      ->orWhere('payment_status', 'like', "%$search%")
                      ->orWhereHas('user', fn($q) => $q->where('first_name', 'like', "%$search%")
                                                       ->orWhere('last_name', 'like', "%$search%")
                                                       ->orWhere('email', 'like', "%$search%"))
                      ->orWhereHas('guestDonor', fn($q) => $q->where('name', 'like', "%$search%")
                                                            ->orWhere('email', 'like', "%$search%"));
                    break;
            }
        });
    }

    $donations = $query->paginate(20); // or ->get() if you don't want pagination

    return view('admin.panel', [
            'admin' => $admin,
            'donations' => $donations,
            'section' => 'donations',
            'canViewUsers' => false,
            'canViewCases' => false,
            'canViewDonations' => true,
            'activeSection' => 'donations',
        ]);}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.donations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        Donation::create($request->all());

        return redirect()->route('admin.donations.index')->with('success', 'Donation created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $donation = Donation::findOrFail($id);
        return view('admin.donations.show', compact('donation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $donation = Donation::findOrFail($id);
        return view('admin.donations.edit', compact('donation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'payment_status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        Donation::findOrFail($id)->update([
            'payment_status' => $request->payment_status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.panel', ['section' => 'donations'])->with('success', 'Donation updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Donation::findOrFail($id)->delete();
        return redirect()->route('admin.panel', ['section' => 'donations'])->with('success', 'Donation deleted.');
    }
}
