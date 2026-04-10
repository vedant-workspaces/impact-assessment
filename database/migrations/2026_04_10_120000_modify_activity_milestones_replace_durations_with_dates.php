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
            // Add start/end date columns if missing
            if (!Schema::hasColumn('activity_milestones', 'start_date')) {
                $table->date('start_date')->nullable()->after('name');
            }

            if (!Schema::hasColumn('activity_milestones', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }

            // Drop old duration columns if they exist
            if (Schema::hasColumn('activity_milestones', 'total_duration')) {
                $table->dropColumn('total_duration');
            }

            if (Schema::hasColumn('activity_milestones', 'duration_taken')) {
                $table->dropColumn('duration_taken');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('activity_milestones')) {
            return;
        }

        Schema::table('activity_milestones', function (Blueprint $table) {
            if (!Schema::hasColumn('activity_milestones', 'total_duration')) {
                $table->unsignedInteger('total_duration')->default(0)->after('name');
            }

            if (!Schema::hasColumn('activity_milestones', 'duration_taken')) {
                $table->unsignedInteger('duration_taken')->default(0)->after('total_duration');
            }

            if (Schema::hasColumn('activity_milestones', 'start_date')) {
                $table->dropColumn('start_date');
            }

            if (Schema::hasColumn('activity_milestones', 'end_date')) {
                $table->dropColumn('end_date');
            }
        });
    }
};
