<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ngos extends Model
{
    protected $table = 'ngos';

    protected $fillable = [
        'id',
        'user_id',
        'organisation_website',
        'organisation_name',
        'contact_person_name',
        'contact_person_designation',
        'contact_person_number',
        'organisation_address',
        'organisation_city',
        'organisation_state',
        'organisation_pincode',
        'primary_sector_ids',
        'sdg_ids',
        'purpose',
        'created_at',
        'updated_at',
    ];
}
