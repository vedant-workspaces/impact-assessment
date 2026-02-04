<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('ngo_id')->default(0)->after('user_type');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->unsignedBigInteger('ngo_id')->default(0)->after('user_id');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->unsignedBigInteger('ngo_id')->default(0)->after('id');
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->unsignedBigInteger('ngo_id')->default(0)->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ngo_id');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('ngo_id');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('ngo_id');
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('ngo_id');
        });
    }
};
