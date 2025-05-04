<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestDonor extends Model
{
    protected $fillable = ['name', 'email'];


    public function donations()
{
    return $this->hasMany(Donation::class);
}


}
