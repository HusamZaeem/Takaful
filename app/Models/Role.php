<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    
    protected $primaryKey = 'role_id';

    public $timestamps = false;

    protected $fillable = ['type'];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id');
    }
}
