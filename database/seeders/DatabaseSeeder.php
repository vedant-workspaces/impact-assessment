<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Users::create([
            'organisation_email' => 'test@example.com',
            'user_name' => 'Test User',
            'password' => bcrypt('password'),
            'user_type' => 1,
        ]);
    }
}
