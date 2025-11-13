<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ngos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('organisation_website')->nullable();
            $table->string('organisation_name');
            $table->string('contact_person_name');
            $table->string('contact_person_designation');
            $table->string('contact_person_number');
            $table->text('organisation_address');
            $table->string('organisation_city');
            $table->string('organisation_state');
            $table->string('organisation_pincode');
            $table->string('primary_sector_ids')->nullable()->comment('Comma-separated IDs');
            $table->string('sdg_ids')->nullable()->comment('Comma-separated IDs');
            $table->text('purpose')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ngos');
    }
};
