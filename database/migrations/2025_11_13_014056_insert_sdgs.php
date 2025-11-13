<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sdgs = [
            'No Poverty',
            'Zero Hunger',
            'Good Health and Well-being',
            'Quality Education',
            'Gender Equality',
            'Clean Water and Sanitation',
            'Affordable and Clean Energy',
            'Decent Work and Economic Growth',
            'Industry, Innovation and Infrastructure',
            'Reduced Inequalities',
            'Sustainable Cities and Communities',
            'Responsible Consumption and Production',
            'Climate Action',
            'Life Below Water',
            'Life on Land',
            'Peace, Justice and Strong Institutions',
            'Partnerships for the Goals',
        ];

        $timestamp = now();

        $data = array_map(fn ($sdg) => [
            'sdg_name' => $sdg,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ], $sdgs);

        DB::table('sdgs')->insert($data);
    }

    public function down(): void
    {
        DB::table('sdgs')->truncate();
    }
};
