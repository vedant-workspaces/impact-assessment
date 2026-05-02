<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasNgo;

class Member extends Model
{
    use HasNgo;
    protected $table = "members";

    protected $fillable = [
        'user_id',
        'ngo_id',
        'full_name',
        'gender',
        'designation',
        'department',
        'contact_number',
        'official_email',
        'access_level',
        'status',
        'assigned_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'access_level' => 'integer',
        'ngo_id' => 'integer',
        'status' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
