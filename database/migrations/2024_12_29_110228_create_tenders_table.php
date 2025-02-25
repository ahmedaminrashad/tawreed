<?php

use App\Enums\TenderStatus;
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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('subject');
            $table->string('project')->nullable();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained('classifications')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('activity_id')->constrained('activity_classifications')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('desc')->nullable();
            $table->integer('contract_duration');
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->date('closing_date');
            $table->integer('proposal_evaluation_duration');
            $table->text('address');
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
            $table->enum('status', [TenderStatus::values()])->default(TenderStatus::DRAFT->value);
            $table->timestamps();
        });

        Schema::create('tender_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->integer('quantity');
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('specs')->nullable();
            $table->timestamps();
        });

        Schema::create('tender_item_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('tender_item_id')->constrained('tender_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_item_media');
        Schema::dropIfExists('tender_items');
        Schema::dropIfExists('tenders');
    }
};
