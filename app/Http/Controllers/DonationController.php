<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\GuestDonor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('donation');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|in:USD,EUR,ILS,GBP,SAR,AED,KWD',
            'payment_method' => 'required|in:paypal,credit_card,bank_transfer,apple_pay,google_pay',
            'notes' => 'nullable|string',
            'payment_reference' => 'nullable|string',
        ];
    
        // If the user is not logged in, require guest info
        if (!Auth::check()) {
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'required|email|max:255';
        }
    
        $validated = $request->validate($rules);
    
        $guestDonorId = null;
        if (!Auth::check()) {
            $guest = GuestDonor::create([
                'name' => $request->guest_name,
                'email' => $request->guest_email,
            ]);
            $guestDonorId = $guest->id;
        }
    
        $donation = Donation::create([
            'user_id' => Auth::id(),
            'guest_donor_id' => $guestDonorId,
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'notes' => $validated['notes'] ?? null,
            'payment_reference' => $validated['payment_reference'] ?? null,
        ]);
    
        
        return redirect()->route('donations.success');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
