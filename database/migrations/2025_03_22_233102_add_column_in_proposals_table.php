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
            $table->text('request_sample')->nullable()->after('allow_announcement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('proposals', 'request_sample')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->dropColumn('request_sample');
            });
        }
    }
};
