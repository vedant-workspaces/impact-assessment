<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $table = 'survey_questions';

    protected $fillable = [
        'survey_id',
        'question_title',
        'language',
        'options',
        'is_required',
        'order',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'integer',
        'is_deleted' => 'integer',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }
}
