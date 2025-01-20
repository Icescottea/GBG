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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('outlet_id')->constrained('outlet')->onDelete('cascade'); // Foreign Key to outlet table
            $table->date('scheduled_date'); // Scheduled delivery date
            $table->date('delivered_date')->nullable(); // Actual delivery date
            $table->enum('status', ['pending', 'completed', 'delayed', 'cancelled'])->default('pending'); // Status of the delivery
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
