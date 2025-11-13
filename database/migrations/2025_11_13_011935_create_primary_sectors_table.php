<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('primary_sectors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('primary_sector_name');
            $table->timestamps();
            $table->integer('is_deleted')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('primary_sectors');
    }
};
