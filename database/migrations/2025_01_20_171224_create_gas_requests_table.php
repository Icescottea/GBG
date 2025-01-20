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
        Schema::create('gas_requests', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->constrained('userss')->onDelete('cascade'); // Foreign Key to userss table
            $table->foreignId('outlet_id')->constrained('outlet')->onDelete('cascade'); // Foreign Key to outlet table
            $table->foreignId('token_id')->nullable()->constrained('tokens')->onDelete('set null'); // Foreign Key to tokens table
            $table->enum('status', ['pending', 'confirmed', 'collected', 'cancelled', 'reallocated'])->default('pending'); // Status
            $table->date('requested_date'); // Date when the request was made
            $table->date('scheduled_date')->nullable(); // Scheduled delivery date
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas_requests');
    }
};
