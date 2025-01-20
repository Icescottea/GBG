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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->constrained('userss')->onDelete('cascade'); // Foreign Key to userss table
            $table->enum('type', ['sms', 'email']); // Notification type
            $table->text('content'); // Notification content
            $table->enum('status', ['sent', 'fail'])->default('sent'); // Notification status
            $table->dateTime('sent_at')->nullable(); // When the notification was sent
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
