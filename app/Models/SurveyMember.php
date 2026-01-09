<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyMember extends Model
{
    protected $table = 'survey_members';

    protected $fillable = [
        'survey_id',
        'member_id',
        'role',
        'is_deleted',
    ];

    protected $casts = [
        'role'       => 'integer',
        'is_deleted' => 'integer',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
