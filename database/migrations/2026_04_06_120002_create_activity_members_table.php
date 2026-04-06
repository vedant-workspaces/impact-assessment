<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('member_id');
            $table->tinyInteger('role')->default(0);
            $table->timestamps();
            $table->integer('is_deleted')->default(0);

            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members');

            // Indexes
            $table->index('activity_id');
            $table->index('member_id');
            $table->index('role');
            $table->index('is_deleted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_members');
    }
};
