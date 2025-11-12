<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'id',
        'username',
        'password',
        'email',
        'user_type',
        'created_at',
        'updated_at'
    ];
}
