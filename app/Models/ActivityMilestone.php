<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityMilestone extends Model
{
    protected $table = 'activity_milestones';

    protected $fillable = [
        'name',
        'activity_id',
        'ngo_id',
        'start_date',
        'end_date',
        'milestone_status',
        'created_at',
        'updated_at',
        'is_deleted',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_deleted' => 'integer',
        'milestone_status' => 'integer',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
