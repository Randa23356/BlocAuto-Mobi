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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mechanic_id')->constrained('users')->onDelete('cascade');
            $table->bigInteger('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->bigInteger('chasier_id')->constrained('users')->onDelete('cascade');
            $table->bigInteger('customer_id')->constrained('customers')->onDelete('cascade'); // Tambahkan kolom ini
            $table->integer('quantity');
            $table->datetime('date');
            $table->bigInteger('grand_total');
            $table->text('description');
            $table->string('spare_parts')->constrained('spare_parts')->onDelete('cascade'); // Tambahkan kolom ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
