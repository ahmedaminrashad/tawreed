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
        Schema::table('proposal_media', function (Blueprint $table) {
            $table->unsignedBigInteger('proposal_id')->nullable()->change();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tender_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_media', function (Blueprint $table) {
            //
        });
    }
};
