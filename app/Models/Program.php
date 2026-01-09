<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'assigned_by',
        'created_at',
        'updated_at',
        'is_deleted',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_deleted' => 'integer',
    ];

    public function programMembers()
    {
        return $this->hasMany(ProgramMember::class, 'program_id')
                    ->where('is_deleted', 0);
    }
}
