<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donations = Donation::latest()->with(['user', 'guestDonor'])->get();
        return view('admin.donations.index', compact('donations'));
    }

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
