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
        Schema::table('tender_item_media', function (Blueprint $table) {
            $table->integer('tender_item_id')->nullable()->change();
            $table->integer('index_item')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tender_item_media', function (Blueprint $table) {
            //
        });
    }
};
