<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name', 'father_name', 'grandfather_name', 'last_name',
        'email', 'password', 'phone', 'gender', 'date_of_birth',
        'nationality', 'id_number', 'marital_status',
        'residence_place', 'street_name', 'building_number', 'city', 'ZIP', 'profile_picture'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    public function cases()
    {
        return $this->hasMany(CaseForm::class, 'user_id', 'user_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'user_id', 'user_id');
    }



    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_picture
            ? asset('storage/' . $this->profile_picture)
            : asset('images/default-profile.png'); // fallback image
    }



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
