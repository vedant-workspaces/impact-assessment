<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('activities')) {
            return;
        }

        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'media_status')) {
                $table->tinyInteger('media_status')
                      ->default(2)
                      ->comment('0=not approved,1=approved,2=pending')
                      ->after('is_media_uploads');
            }

            if (!Schema::hasColumn('activities', 'media_link')) {
                $table->text('media_link')->nullable()->after('media_status');
            }

            if (!Schema::hasColumn('activities', 'media_status_index')) {
                // add an index for media_status for easier querying
                $table->index('media_status');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('activities')) {
            return;
        }

        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'media_link')) {
                $table->dropColumn('media_link');
            }

            if (Schema::hasColumn('activities', 'media_status')) {
                $table->dropColumn('media_status');
            }
        });
    }
};
