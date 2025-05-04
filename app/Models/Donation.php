<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    
    

    protected $primaryKey = 'donation_id';

    protected $fillable = [
        'user_id', 'guest_donor_id', 'amount', 'currency', 'notes',
        'payment_method', 'payment_status', 'payment_reference',
        'paypal_transaction_id', 'card_brand', 'card_last_four'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    
    public function guestDonor()
    {
        return $this->belongsTo(GuestDonor::class);
    }

    
}
