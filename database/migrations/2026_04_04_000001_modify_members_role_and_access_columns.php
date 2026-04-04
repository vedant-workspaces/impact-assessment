<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('members')) {
            return;
        }
        // Use DB-level ALTER statements for Postgres to provide an explicit USING cast
        if (Schema::getConnection()->getDriverName() === 'pgsql') {
            // Cast `role_type` safely: if numeric, cast; otherwise set default 3
            DB::statement("ALTER TABLE members ALTER COLUMN role_type TYPE smallint USING (CASE WHEN role_type ~ '^[0-9]+$' THEN role_type::smallint ELSE 3 END)");
            DB::statement("ALTER TABLE members ALTER COLUMN role_type SET DEFAULT 3");
            DB::statement("ALTER TABLE members ALTER COLUMN role_type SET NOT NULL");

            // Cast `access_level` safely: if numeric, cast; otherwise set default 1
            DB::statement("ALTER TABLE members ALTER COLUMN access_level TYPE smallint USING (CASE WHEN access_level ~ '^[0-9]+$' THEN access_level::smallint ELSE 1 END)");
            DB::statement("ALTER TABLE members ALTER COLUMN access_level SET DEFAULT 1");
            DB::statement("ALTER TABLE members ALTER COLUMN access_level SET NOT NULL");
        } else {
            // For other DBs, fall back to the schema change (may require doctrine/dbal)
            Schema::table('members', function (Blueprint $table) {
                $table->tinyInteger('role_type')->default(3)->change();
                $table->tinyInteger('access_level')->default(1)->change();
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('members')) {
            return;
        }
        if (Schema::getConnection()->getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE members ALTER COLUMN role_type TYPE varchar USING role_type::text");
            DB::statement("ALTER TABLE members ALTER COLUMN role_type DROP DEFAULT");

            DB::statement("ALTER TABLE members ALTER COLUMN access_level TYPE varchar USING access_level::text");
            DB::statement("ALTER TABLE members ALTER COLUMN access_level DROP DEFAULT");
        } else {
            Schema::table('members', function (Blueprint $table) {
                $table->string('role_type')->change();
                $table->string('access_level')->change();
            });
        }
    }
};
