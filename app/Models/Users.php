<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'organisation_email',
        'user_name',
        'password',
        'user_type',
    ];

    protected $hidden = [
        'password',
    ];
}
