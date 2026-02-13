<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $table = 'question_types';

    protected $fillable = [
        'type',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_deleted' => 'integer',
    ];
}
