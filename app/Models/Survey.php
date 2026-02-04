<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasNgo;

class Survey extends Model
{
    use HasNgo;
    protected $table = 'surveys';

    protected $fillable = [
        'ngo_id',
        'title',
        'program_id',
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

    public function surveyMembers()
    {
        return $this->hasMany(SurveyMember::class, 'survey_id')
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
