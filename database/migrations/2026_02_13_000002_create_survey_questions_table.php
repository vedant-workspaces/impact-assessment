<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->string('question_title');
            $table->string('language')->default('english');
            $table->json('options')->nullable();
            $table->tinyInteger('is_required')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0)->comment('0 = not deleted, 1 = deleted');

            $table->foreign('survey_id')
                  ->references('id')
                  ->on('surveys')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
