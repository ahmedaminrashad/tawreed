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
        Schema::create('cancellation_reasons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('cancellation_reason_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cancellation_id')->constrained('cancellation_reasons')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('locale', 2)->index();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancellation_reason_translations');
        Schema::dropIfExists('cancellation_reasons');
    }
};
