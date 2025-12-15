<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = "members";

    protected $fillable = [
        'user_id',
        'full_name',
        'gender',
        'designation',
        'department',
        'contact_number',
        'official_email',
        'role_type',
        'access_level',
        'status',
        'assigned_by',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
