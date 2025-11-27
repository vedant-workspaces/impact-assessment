<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sdg extends Model
{
    protected $table = 'sdgs';

    protected $fillable = [
        'id',
        'sdg_name',
    ];
}