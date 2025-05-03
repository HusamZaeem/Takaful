<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    
    

    protected $primaryKey = 'donation_id';

    protected $fillable = [
        'user_id', 'amount', 'currency', 'notes',
        'payment_method', 'status', 'admin_note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    
}
