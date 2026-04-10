<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ngo_id')->default(0);
            $table->unsignedBigInteger('program_id')->default(0)->comment('0 for standalone activity');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->decimal('total_budget', 15, 2)->default(0);
            $table->decimal('budget_used', 15, 2)->default(0);
            $table->unsignedInteger('total_beneficiaries')->default(0);
            $table->unsignedInteger('beneficiaries_reached')->default(0);
            $table->tinyInteger('is_media_uploads')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->integer('is_deleted')->default(0);

            $table->foreign('assigned_by')->references('id')->on('members')->onDelete('set null');

            // Indexes for faster lookups
            $table->index('ngo_id');
            $table->index('program_id');
            $table->index('assigned_by');
            $table->index('is_deleted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
