<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sectors = [
            'Accidents & Traffic Safety',
            'Agriculture Food & Nutrition',
            'Animals & Wildlife',
            'Arts & Culture',
            'Business & Industry',
            'Children',
            'Civil Society Development',
            'Community Development',
            'Democracy & Good Governance',
            'Disability',
            'Economic Development',
            'Education',
            'Employment & Labor',
            'Environment',
            'Family',
            'Health',
            'HIV/AIDS',
            'Housing & Shelter',
            'Human Rights',
            'Human Service',
            'Humanitarian Relief',
            'Immigration',
            'Indigenous Communities',
            'Information Technology',
            'International Affairs',
            'LGBTQ',
            'Livelihood',
            'Media',
            'Narcotics Drugs & Crime',
            'Old Age Care',
            'Other/General',
            'Peace & Conflict Resolution',
            'Poverty Alleviation',
            'Public Affairs',
            'Refugee & Asylum Seekers',
            'Religion',
            'Science',
            'Social Sciences',
            'Social Service',
            'Sports & Recreation',
            'Sustainable Development',
            'Tourism & Travel',
            'Volunteerism',
            'Water & Sanitation',
            'Women & Gender',
            'Youth & Adolescents',
        ];

        $timestamp = now();

        $data = array_map(fn ($sector) => [
            'primary_sector_name' => $sector,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ], $sectors);

        DB::table('primary_sectors')->insert($data);
    }

    public function down(): void
    {
        DB::table('primary_sectors')->truncate();
    }
};
