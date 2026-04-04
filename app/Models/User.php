<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\HasNgo;
use App\Constants\UserTypes;

class User extends Authenticatable implements JWTSubject
{
    use HasNgo;
    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'email',
        'user_type',
        'ngo_id'
    ];

    protected $casts = [
        'user_type' => 'integer',
        'ngo_id' => 'integer',
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
            'user_type' => (int) ($this->user_type ?? 0),
        ];
    }

    public function isSuperAdmin(): bool
    {
        return (int) $this->user_type === UserTypes::SUPER_ADMIN;
    }

    public function isProjectManager(): bool
    {
        return (int) $this->user_type === UserTypes::PROJECT_MANAGER;
    }

    public function isSupervisor(): bool
    {
        return (int) $this->user_type === UserTypes::SUPERVISOR;
    }

    public function isFieldExecutive(): bool
    {
        return (int) $this->user_type === UserTypes::FIELD_EXECUTIVE;
    }
}
