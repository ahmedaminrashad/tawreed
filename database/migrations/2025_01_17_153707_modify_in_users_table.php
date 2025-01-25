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
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable()->after('email');
            $table->string('phone')->nullable()->after('email');
            $table->string('country_code')->nullable()->after('email');
            $table->string('longitude')->nullable()->after('country_id');
            $table->string('latitude')->nullable()->after('country_id');
            $table->string('address')->nullable()->after('country_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('phone');
            $table->dropColumn('country_code');
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
            $table->dropColumn('address');
        });
    }
};
