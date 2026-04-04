<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('members')) {
            return;
        }

        // NOTE: Changing column types may require doctrine/dbal dependency for the `change()` method.
        // If you don't have it installed, run: composer require doctrine/dbal
        Schema::table('members', function (Blueprint $table) {
            $table->tinyInteger('role_type')->default(3)->change();
            $table->tinyInteger('access_level')->default(1)->change();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('members')) {
            return;
        }

        Schema::table('members', function (Blueprint $table) {
            $table->string('role_type')->change();
            $table->string('access_level')->change();
        });
    }
};
