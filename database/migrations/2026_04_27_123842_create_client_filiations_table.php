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
        Schema::create('client_filiations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_client_id')->constrained('clients')->cascadeOnDelete();
            $table->enum('relation_type', ['professionnel', 'famille'])->index();
            $table->string('label')->nullable();
            $table->timestamps();

            $table->unique(['client_id', 'related_client_id', 'relation_type'], 'client_filiation_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_filiations');
    }
};
