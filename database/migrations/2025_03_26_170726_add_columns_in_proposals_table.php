<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->text('custom_reject_reason')->nullable()->after('status');
            $table->integer('reject_reason')->default(0)->after('status');
            $table->integer('rejected_by')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('proposals', 'custom_reject_reason')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->dropColumn('custom_reject_reason');
            });
        }
        if (Schema::hasColumn('proposals', 'reject_reason')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->dropColumn('reject_reason');
            });
        }
        if (Schema::hasColumn('proposals', 'rejected_by')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->dropColumn('rejected_by');
            });
        }
    }
};