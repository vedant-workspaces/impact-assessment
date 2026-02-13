<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('question_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0)->comment('0 = not deleted, 1 = deleted');
        });

        // Seed default types
        DB::table('question_types')->insert([
            ['type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'textarea', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'radio', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'checkbox', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('question_types');
    }
};
