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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->dateTime('appointment_datetime');
            $table->enum('status', ['scheduled', 'completed', 'canceled'])->default('scheduled');
            $table->decimal('price', 8, 2)->nullable(); // Store price at time of booking
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Index for faster lookups
            $table->index(['salon_id', 'appointment_datetime']);
            $table->index(['client_id', 'salon_id']);
            $table->index(['staff_id', 'appointment_datetime']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
