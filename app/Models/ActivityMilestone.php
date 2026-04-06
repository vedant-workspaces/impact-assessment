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
        'total_duration',
        'duration_taken',
        'created_at',
        'updated_at',
        'is_deleted',
    ];

    protected $casts = [
        'total_duration' => 'integer',
        'duration_taken' => 'integer',
        'is_deleted' => 'integer',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
