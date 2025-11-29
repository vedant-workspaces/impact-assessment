<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();

            $table->string('full_name');
            $table->string('gender');
            $table->string('designation');
            $table->string('department');
            $table->string('contact_number');
            $table->string('official_email')->unique();

            $table->string('role_type');
            $table->string('access_level');

            $table->tinyInteger('status')
                  ->default(1)
                  ->comment('1 = active, 0 = inactive');

            $table->unsignedBigInteger('assigned_by');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
