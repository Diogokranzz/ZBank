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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_number', 16)->unique();
            $table->string('card_holder');
            $table->string('cvv', 3);
            $table->date('expiry_date');
            $table->enum('type', ['platinum', 'gold', 'black']);
            $table->decimal('limit', 15, 2);
            $table->decimal('current_bill', 15, 2)->default(0.00);
            $table->boolean('is_blocked')->default(false);
            $table->timestamps();

            // Índices para otimizar buscas
            $table->index('user_id');
            $table->index('card_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
