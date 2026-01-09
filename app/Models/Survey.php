<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'assigned_by',
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
}
