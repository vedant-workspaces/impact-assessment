<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'email',
        'user_type',
        'ngo_id'
    ];

    // Required by JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Add any custom claims to the token
    public function getJWTCustomClaims()
    {
        return [
            'ngo_id' => $this->ngo_id ?? 0,
        ];
    }
}
