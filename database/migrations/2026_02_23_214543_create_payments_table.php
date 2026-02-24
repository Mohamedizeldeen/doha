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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sales_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('subscription_type', ['monthly', 'yearly']);
            $table->decimal('amount', 10, 2); // 15 OMR monthly, 120 OMR yearly
            $table->decimal('commission_rate', 5, 2)->default(0); // snapshot of sales user's rate at time of payment
            $table->decimal('commission_amount', 10, 2)->default(0); // calculated commission
            $table->date('period_start');
            $table->date('period_end');
            $table->enum('status', ['paid', 'pending', 'cancelled'])->default('paid');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
