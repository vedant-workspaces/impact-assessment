<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sdgs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sdg_name');
            $table->unsignedBigInteger('primary_sector_id')->nullable();
            $table->timestamps();
            $table->integer('is_deleted')->default(0);

            $table->foreign('primary_sector_id')
                ->references('id')
                ->on('primary_sectors')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sdgs');
    }
};
