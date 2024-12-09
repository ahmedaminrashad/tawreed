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
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('classification_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classification_id')->constrained('classifications')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('locale', 2)->index();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classification_translations');
        Schema::dropIfExists('classifications');
    }
};
