<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('userss', function (Blueprint $table) {
            $table->enum('role', ['customer', 'outlet_manager', 'head_office_staff', 'admin', 'business'])->default('customer')->change();
            $table->string('certificate_path')->nullable()->after('password');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('userss', function (Blueprint $table) {
            $table->enum('role', ['customer', 'outlet_manager', 'head_office_staff', 'admin'])->default('customer')->change();
            $table->dropColumn('certificate_path');
        });
    }
};
