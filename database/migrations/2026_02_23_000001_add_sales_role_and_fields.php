<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update users role enum to include 'sales'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'super_admin', 'sales') DEFAULT 'admin'");

        // Add sales-specific fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->default(0)->after('role'); // e.g. 10.00 = 10%
            $table->string('phone')->nullable()->after('commission_rate');
        });

        // Add sales_user_id to salons table (which sales person created this salon)
        Schema::table('salons', function (Blueprint $table) {
            $table->foreignId('sales_user_id')->nullable()->after('user_id')
                ->constrained('users')->nullOnDelete();
        });

        // Add WhatsApp reminder tracking to books
        Schema::table('books', function (Blueprint $table) {
            $table->boolean('whatsapp_reminded')->default(false)->after('notes');
            $table->timestamp('whatsapp_reminded_at')->nullable()->after('whatsapp_reminded');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_reminded', 'whatsapp_reminded_at']);
        });

        Schema::table('salons', function (Blueprint $table) {
            $table->dropForeign(['sales_user_id']);
            $table->dropColumn('sales_user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['commission_rate', 'phone']);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'super_admin') DEFAULT 'admin'");
    }
};
