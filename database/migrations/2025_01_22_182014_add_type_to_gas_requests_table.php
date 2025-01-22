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
        Schema::table('gas_requests', function (Blueprint $table) {
            $table->string('type')->after('quantity'); // Cylinder type (e.g., 2.5kg, 10kg)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gas_requests', function (Blueprint $table) {
            //
        });
    }
};
