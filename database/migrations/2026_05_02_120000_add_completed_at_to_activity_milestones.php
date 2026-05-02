<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('activity_milestones')) {
            return;
        }

        Schema::table('activity_milestones', function (Blueprint $table) {
            if (!Schema::hasColumn('activity_milestones', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('milestone_status');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('activity_milestones')) {
            return;
        }

        Schema::table('activity_milestones', function (Blueprint $table) {
            if (Schema::hasColumn('activity_milestones', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
        });
    }
};
