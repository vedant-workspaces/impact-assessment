<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add indexes for common filters and joins used across repositories

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'ngo_id')) {
                    $table->index('ngo_id', 'users_ngo_id_idx');
                }
            });
        }

        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                if (Schema::hasColumn('members', 'ngo_id') && Schema::hasColumn('members', 'status')) {
                    $table->index(['ngo_id', 'status'], 'members_ngo_status_idx');
                } elseif (Schema::hasColumn('members', 'ngo_id')) {
                    $table->index('ngo_id', 'members_ngo_id_idx');
                }

                if (Schema::hasColumn('members', 'assigned_by')) {
                    $table->index('assigned_by', 'members_assigned_by_idx');
                }

                if (Schema::hasColumn('members', 'role_type')) {
                    $table->index('role_type', 'members_role_type_idx');
                }
            });
        }

        if (Schema::hasTable('programs')) {
            Schema::table('programs', function (Blueprint $table) {
                if (Schema::hasColumn('programs', 'ngo_id') && Schema::hasColumn('programs', 'is_deleted')) {
                    $table->index(['ngo_id', 'is_deleted'], 'programs_ngo_deleted_idx');
                }

                if (Schema::hasColumn('programs', 'assigned_by')) {
                    $table->index('assigned_by', 'programs_assigned_by_idx');
                }
            });
        }

        if (Schema::hasTable('program_members')) {
            Schema::table('program_members', function (Blueprint $table) {
                if (Schema::hasColumn('program_members', 'program_id') && Schema::hasColumn('program_members', 'is_deleted')) {
                    $table->index(['program_id', 'is_deleted'], 'program_members_program_deleted_idx');
                } elseif (Schema::hasColumn('program_members', 'program_id')) {
                    $table->index('program_id', 'program_members_program_id_idx');
                }

                if (Schema::hasColumn('program_members', 'member_id')) {
                    $table->index('member_id', 'program_members_member_id_idx');
                }
            });
        }

        if (Schema::hasTable('surveys')) {
            Schema::table('surveys', function (Blueprint $table) {
                if (Schema::hasColumn('surveys', 'ngo_id') && Schema::hasColumn('surveys', 'is_deleted')) {
                    $table->index(['ngo_id', 'is_deleted'], 'surveys_ngo_deleted_idx');
                }

                if (Schema::hasColumn('surveys', 'program_id')) {
                    $table->index('program_id', 'surveys_program_id_idx');
                }

                if (Schema::hasColumn('surveys', 'assigned_by')) {
                    $table->index('assigned_by', 'surveys_assigned_by_idx');
                }
            });
        }

        if (Schema::hasTable('survey_members')) {
            Schema::table('survey_members', function (Blueprint $table) {
                if (Schema::hasColumn('survey_members', 'survey_id') && Schema::hasColumn('survey_members', 'is_deleted')) {
                    $table->index(['survey_id', 'is_deleted'], 'survey_members_survey_deleted_idx');
                } elseif (Schema::hasColumn('survey_members', 'survey_id')) {
                    $table->index('survey_id', 'survey_members_survey_id_idx');
                }

                if (Schema::hasColumn('survey_members', 'member_id')) {
                    $table->index('member_id', 'survey_members_member_id_idx');
                }
            });
        }

        if (Schema::hasTable('survey_questions')) {
            Schema::table('survey_questions', function (Blueprint $table) {
                // index for queries that fetch questions by survey and order them (with is_deleted filter)
                $cols = [];
                if (Schema::hasColumn('survey_questions', 'survey_id')) $cols[] = 'survey_id';
                if (Schema::hasColumn('survey_questions', 'is_deleted')) $cols[] = 'is_deleted';
                if (Schema::hasColumn('survey_questions', 'order')) $cols[] = 'order';
                if (!empty($cols)) {
                    $table->index($cols, 'survey_questions_survey_order_idx');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex('users_ngo_id_idx');
            });
        }

        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex('members_ngo_status_idx');
                $table->dropIndex('members_ngo_id_idx');
                $table->dropIndex('members_assigned_by_idx');
                $table->dropIndex('members_role_type_idx');
            });
        }

        if (Schema::hasTable('programs')) {
            Schema::table('programs', function (Blueprint $table) {
                $table->dropIndex('programs_ngo_deleted_idx');
                $table->dropIndex('programs_assigned_by_idx');
            });
        }

        if (Schema::hasTable('program_members')) {
            Schema::table('program_members', function (Blueprint $table) {
                $table->dropIndex('program_members_program_deleted_idx');
                $table->dropIndex('program_members_program_id_idx');
                $table->dropIndex('program_members_member_id_idx');
            });
        }

        if (Schema::hasTable('surveys')) {
            Schema::table('surveys', function (Blueprint $table) {
                $table->dropIndex('surveys_ngo_deleted_idx');
                $table->dropIndex('surveys_program_id_idx');
                $table->dropIndex('surveys_assigned_by_idx');
            });
        }

        if (Schema::hasTable('survey_members')) {
            Schema::table('survey_members', function (Blueprint $table) {
                $table->dropIndex('survey_members_survey_deleted_idx');
                $table->dropIndex('survey_members_survey_id_idx');
                $table->dropIndex('survey_members_member_id_idx');
            });
        }

        if (Schema::hasTable('survey_questions')) {
            Schema::table('survey_questions', function (Blueprint $table) {
                $table->dropIndex('survey_questions_survey_order_idx');
            });
        }
    }
};
