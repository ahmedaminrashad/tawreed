<?php

use App\Enums\ProposalStatus;
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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('total', 10, 2)->nullable();
            $table->date('proposal_end_date')->nullable();
            $table->integer('contract_duration')->nullable();
            $table->text('payment_terms')->nullable();
            $table->text('proposal_desc')->nullable();
            $table->tinyInteger('allow_announcement')->default(0);
            $table->string('status')->default(ProposalStatus::DRAFT->value);
            $table->timestamps();
        });

        Schema::create('proposal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('item_id')->constrained('tender_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->integer('quantity');
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('item_specs')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->text('seller_item_specs')->nullable();
            $table->timestamps();
        });

        Schema::create('proposal_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_media');
        Schema::dropIfExists('proposal_items');
        Schema::dropIfExists('proposals');
    }
};
