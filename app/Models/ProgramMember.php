<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramMember extends Model
{
    protected $table = 'program_members';

    protected $fillable = [
        'program_id',
        'member_id',
        'role',
        'is_deleted',
    ];

    protected $casts = [
        'role'       => 'integer',
        'is_deleted' => 'integer',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
