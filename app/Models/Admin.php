<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    
    
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role_id'
    ];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


}
