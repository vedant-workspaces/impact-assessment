<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('program_members', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('member_id');

            // 1 = leader, 2 = member
            $table->tinyInteger('role')
                  ->comment('1 = leader, 2 = member');

            $table->tinyInteger('is_deleted')
                  ->default(0)
                  ->comment('0 = not deleted, 1 = deleted');

            $table->timestamps();

            // Foreign keys
            $table->foreign('program_id')
                  ->references('id')
                  ->on('programs')
                  ->onDelete('cascade');

            $table->foreign('member_id')
                  ->references('id')
                  ->on('members')
                  ->onDelete('cascade');

            // Prevent duplicate member assignment to same program
            $table->unique(['program_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_members');
    }
};
