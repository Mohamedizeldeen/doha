<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Enhance clients table ────────────────────────────
        Schema::table('clients', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('email');
            $table->date('birthday')->nullable()->after('notes');
            $table->json('preferences')->nullable()->after('birthday');
            $table->integer('loyalty_points')->default(0)->after('preferences');
        });

        // ── Enhance staff table ──────────────────────────────
        Schema::table('staff', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->default(0)->after('position_ar');
            $table->decimal('salary', 10, 2)->default(0)->after('commission_rate');
            $table->string('specialization_en')->nullable()->after('salary');
            $table->string('specialization_ar')->nullable()->after('specialization_en');
            $table->boolean('is_active')->default(true)->after('specialization_ar');
        });

        // ── Enhance products table ───────────────────────────
        Schema::table('products', function (Blueprint $table) {
            $table->integer('min_stock_level')->default(5)->after('stock_quantity');
            $table->decimal('cost_price', 10, 2)->nullable()->after('min_stock_level');
            $table->string('sku')->nullable()->after('cost_price');
        });

        // ── Staff schedules ──────────────────────────────────
        Schema::create('staff_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->onDelete('cascade');
            $table->foreignId('salon_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('day_of_week'); // 0=Sunday, 6=Saturday
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_day_off')->default(false);
            $table->timestamps();
        });

        // ── Staff leaves ─────────────────────────────────────
        Schema::create('staff_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->onDelete('cascade');
            $table->foreignId('salon_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // ── Service packages / offers ────────────────────────
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained()->onDelete('cascade');
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->decimal('original_price', 10, 2);
            $table->decimal('package_price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamps();
        });

        // ── Package-Service pivot ────────────────────────────
        Schema::create('package_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
        });

        // ── Invoices ─────────────────────────────────────────
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('booking_id')->nullable()->constrained('books')->onDelete('set null');
            $table->string('invoice_number')->unique();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('payment_method', ['cash', 'card', 'wallet', 'partial'])->default('cash');
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2)->default(0);
            $table->enum('status', ['paid', 'partial', 'unpaid', 'refunded'])->default('unpaid');
            $table->string('coupon_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // ── Invoice items ────────────────────────────────────
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->enum('item_type', ['service', 'product', 'package']);
            $table->unsignedBigInteger('item_id');
            $table->string('item_name');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });

        // ── Coupons ──────────────────────────────────────────
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 10, 2);
            $table->decimal('min_order_amount', 10, 2)->default(0);
            $table->integer('max_uses')->nullable();
            $table->integer('used_count')->default(0);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── Expenses (supplier purchases, etc.) ──────────────
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained()->onDelete('cascade');
            $table->enum('category', ['supplier', 'rent', 'salary', 'utilities', 'marketing', 'other']);
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->string('supplier_name')->nullable();
            $table->date('expense_date');
            $table->string('receipt_image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('package_service');
        Schema::dropIfExists('service_packages');
        Schema::dropIfExists('staff_leaves');
        Schema::dropIfExists('staff_schedules');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['min_stock_level', 'cost_price', 'sku']);
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['commission_rate', 'salary', 'specialization_en', 'specialization_ar', 'is_active']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['notes', 'birthday', 'preferences', 'loyalty_points']);
        });
    }
};
