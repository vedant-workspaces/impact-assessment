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
        'user_type'
    ];

    // Required by JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Add any custom claims to the token
    public function getJWTCustomClaims()
    {
        return [];
    }
}
