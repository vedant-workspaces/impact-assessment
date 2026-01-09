<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

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
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
