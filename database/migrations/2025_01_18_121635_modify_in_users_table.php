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
            $table->text('company_desc')->nullable()->after('company_verified_at');
            $table->string('iban_file')->nullable()->after('password');
            $table->string('tax_card_file')->nullable()->after('password');
            $table->string('company_profile')->nullable()->after('password');
            $table->string('commercial_registration_file')->nullable()->after('password');
            $table->string('tax_card_number')->nullable()->after('password');
            $table->tinyInteger('push_notify')->default(0)->after('password');
            $table->tinyInteger('email_notify')->default(0)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
