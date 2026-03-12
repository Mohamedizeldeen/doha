<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Expand expense categories
        DB::statement("ALTER TABLE expenses MODIFY COLUMN category ENUM('supplier','rent','salary','utilities','marketing','maintenance','equipment','insurance','other') NOT NULL DEFAULT 'other'");

        // Add recurring and VAT tracking to expenses
        Schema::table('expenses', function (Blueprint $table) {
            $table->boolean('is_recurring')->default(false)->after('notes');
            $table->enum('recurring_period', ['monthly', 'quarterly', 'yearly'])->nullable()->after('is_recurring');
            $table->decimal('vat_amount', 10, 2)->default(0)->after('amount');
            $table->decimal('vat_rate', 5, 2)->default(0)->after('vat_amount');
        });

        // Staff salary payments tracking
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->constrained()->onDelete('cascade');
            $table->decimal('base_salary', 10, 2);
            $table->decimal('commission_amount', 10, 2)->default(0);
            $table->decimal('bonus', 10, 2)->default(0);
            $table->decimal('deductions', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('month'); // e.g., "2026-03"
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->date('paid_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_payments');

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['is_recurring', 'recurring_period', 'vat_amount', 'vat_rate']);
        });

        DB::statement("ALTER TABLE expenses MODIFY COLUMN category ENUM('supplier','rent','salary','utilities','marketing','other') NOT NULL DEFAULT 'other'");
    }
};
