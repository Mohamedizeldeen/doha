<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add employee and cashier roles to users enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'super_admin', 'sales', 'employee', 'cashier') DEFAULT 'admin'");

        // Add salon_id and staff_id to users (for employee/cashier accounts)
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('salon_id')->nullable()->after('role')
                ->constrained('salons')->nullOnDelete();
            $table->foreignId('staff_id')->nullable()->after('salon_id')
                ->constrained('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['salon_id']);
            $table->dropForeign(['staff_id']);
            $table->dropColumn(['salon_id', 'staff_id']);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'super_admin', 'sales') DEFAULT 'admin'");
    }
};
