<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('ngo_id')->default(0);
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->integer('is_deleted')->default(0);

            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');

            // Indexes
            $table->index('activity_id');
            $table->index('ngo_id');
            $table->index('is_deleted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_milestones');
    }
};
