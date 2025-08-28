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
        Schema::table('employees', function (Blueprint $table) {
            $table->index('last_name', 'idx_employees_last_name');
            $table->index('employee_number', 'idx_employees_employee_number');
            $table->index('email', 'idx_employees_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex('idx_employees_last_name');
            $table->dropIndex('idx_employees_employee_number');
            $table->dropIndex('idx_employees_email');
        });
    }
};
