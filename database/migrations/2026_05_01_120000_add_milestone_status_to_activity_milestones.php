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
            if (!Schema::hasColumn('activity_milestones', 'milestone_status')) {
                $table->tinyInteger('milestone_status')
                      ->default(0)
                      ->comment('0=pending,1=in progress,2=completed')
                      ->after('is_deleted');
                $table->index('milestone_status');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('activity_milestones')) {
            return;
        }

        Schema::table('activity_milestones', function (Blueprint $table) {
            if (Schema::hasColumn('activity_milestones', 'milestone_status')) {
                $table->dropIndex(['milestone_status']);
                $table->dropColumn('milestone_status');
            }
        });
    }
};
