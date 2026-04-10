<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasNgo;

class Activity extends Model
{
    use HasNgo;

    protected $table = 'activities';

    protected $fillable = [
        'ngo_id',
        'program_id',
        'name',
        'description',
        'assigned_by',
        'total_budget',
        'budget_used',
        'total_beneficiaries',
        'beneficiaries_reached',
        'is_media_uploads',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'is_deleted',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_media_uploads' => 'integer',
        'is_deleted' => 'integer',
        'total_budget' => 'decimal:2',
        'budget_used' => 'decimal:2',
    ];

    public function members()
    {
        return $this->hasMany(ActivityMember::class, 'activity_id')
                    ->where('is_deleted', 0);
    }

    public function milestones()
    {
        return $this->hasMany(ActivityMilestone::class, 'activity_id')
                    ->where('is_deleted', 0);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Member::class, 'assigned_by');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
