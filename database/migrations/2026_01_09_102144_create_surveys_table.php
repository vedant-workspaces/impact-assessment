<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            // FK to programs table (survey belongs to a program)
            $table->unsignedBigInteger('program_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // FK to members table
            $table->unsignedBigInteger('assigned_by');

            // soft delete flag
            $table->tinyInteger('is_deleted')
                  ->default(0)
                  ->comment('0 = not deleted, 1 = deleted');

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('assigned_by')
                  ->references('id')
                  ->on('members')
                  ->onDelete('restrict');

            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
