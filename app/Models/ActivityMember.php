<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityMember extends Model
{
    protected $table = 'activity_members';

    protected $fillable = [
        'activity_id',
        'member_id',
        'role',
        'created_at',
        'updated_at',
        'is_deleted',
    ];

    protected $casts = [
        'role' => 'integer',
        'is_deleted' => 'integer',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
