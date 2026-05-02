<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        $comment = "1=Super Admin,2=Project Manager,3=Supervisor,4=Field Executive";

        if ($driver === 'pgsql') {
            DB::statement("COMMENT ON COLUMN users.user_type IS '{$comment}'");
        } elseif ($driver === 'mysql') {
            try {
                DB::statement("ALTER TABLE users MODIFY user_type tinyint NOT NULL DEFAULT 1 COMMENT '{$comment}'");
            } catch (\Exception $e) {
                // ignore if it fails
            }
        } else {
            try {
                DB::statement("COMMENT ON COLUMN users.user_type IS '{$comment}'");
            } catch (\Exception $e) {
                // ignore
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        $old = "1=NGO, 2=Donor, 3=Admin";

        if ($driver === 'pgsql') {
            DB::statement("COMMENT ON COLUMN users.user_type IS '{$old}'");
        } elseif ($driver === 'mysql') {
            try {
                DB::statement("ALTER TABLE users MODIFY user_type tinyint NOT NULL DEFAULT 1 COMMENT '{$old}'");
            } catch (\Exception $e) {
                // ignore
            }
        } else {
            try {
                DB::statement("COMMENT ON COLUMN users.user_type IS '{$old}'");
            } catch (\Exception $e) {}
        }
    }
};
