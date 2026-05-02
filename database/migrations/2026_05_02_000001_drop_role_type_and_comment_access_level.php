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

        $driver = Schema::getConnection()->getDriverName();

        // Drop index on role_type if exists
        if ($driver === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS members_role_type_idx');
        } elseif ($driver === 'mysql') {
            // MySQL: DROP INDEX via ALTER TABLE
            try {
                DB::statement('ALTER TABLE members DROP INDEX members_role_type_idx');
            } catch (\Exception $e) {
                // ignore if index doesn't exist
            }
        } else {
            try {
                DB::statement('DROP INDEX IF EXISTS members_role_type_idx');
            } catch (\Exception $e) {}
        }

        // Drop role_type column if present
        if (Schema::hasColumn('members', 'role_type')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('role_type');
            });
        }

        // Add comment to access_level to describe identity values
        $comment = "1=Super Admin,2=Project Manager,3=Supervisor,4=Field Executive";
        if ($driver === 'pgsql') {
            DB::statement("COMMENT ON COLUMN members.access_level IS '{$comment}'");
        } elseif ($driver === 'mysql') {
            // Modify column to attach comment (assumes tinyint type)
            try {
                DB::statement("ALTER TABLE members MODIFY access_level tinyint NOT NULL DEFAULT 1 COMMENT '{$comment}'");
            } catch (\Exception $e) {
                // ignore - if MODIFY fails, leave as-is
            }
        } else {
            try {
                DB::statement("COMMENT ON COLUMN members.access_level IS '{$comment}'");
            } catch (\Exception $e) {}
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('members')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        // Remove comment
        if ($driver === 'pgsql') {
            DB::statement("COMMENT ON COLUMN members.access_level IS NULL");
        } elseif ($driver === 'mysql') {
            try {
                DB::statement("ALTER TABLE members MODIFY access_level tinyint NOT NULL DEFAULT 1 COMMENT ''");
            } catch (\Exception $e) {}
        }

        // Re-create role_type as string to restore previous state
        if (! Schema::hasColumn('members', 'role_type')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('role_type')->nullable();
            });
        }
    }
};
