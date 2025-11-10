<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimarySectors extends Model
{
    protected $table = 'primary_sectors';

    protected $fillable = [
        'id',
        'primary_sector_name',
    ];
}