<?php

use App\Enums\UserType;
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
            $table->string('full_name')->nullable()->after('id');
            $table->enum('type', [UserType::values()])->default(UserType::INDIVIDUAL->value)->after('id');
            $table->string('company_name')->nullable()->after('name');
            $table->integer('country_id')->nullable()->after('email');
            $table->string('commercial_registration_number')->nullable()->after('email');
            $table->dateTime('otp_expires_at')->nullable()->after('password');
            $table->string('otp')->nullable()->after('password');
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('company_name');
            $table->dropColumn('country_id');
            $table->dropColumn('commercial_registration_number');
            $table->dropColumn('otp_expires_at');
            $table->dropColumn('otp');
            $table->dropColumn('full_name');
        });
    }
};
