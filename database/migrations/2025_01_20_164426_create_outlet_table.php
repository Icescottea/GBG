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
        Schema::create('outlet', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Outlet Name
            $table->string('location'); // Outlet Address
            $table->string('phone')->nullable(); // Optional Contact Number
            $table->string('manager_name')->nullable(); // Name of the Outlet Manager
            $table->boolean('status')->default(1); // Status: 1 = Active, 0 = Inactive
            $table->timestamps(); // Created_at and Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet');
    }
};
