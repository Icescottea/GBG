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
        Schema::create('tokens', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('token_code', 100)->unique(); // Unique token string
            $table->foreignId('user_id')->constrained('userss')->onDelete('cascade'); // Foreign Key to userss table
            $table->enum('status', ['active', 'expired', 'used'])->default('active'); // Status of the token
            $table->dateTime('expires_at'); // Expiration date of the token
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP')); // Date created
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
