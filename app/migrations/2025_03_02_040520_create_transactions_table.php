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
            $table->bigInteger('mechanic_id')->unsigned();
            $table->string('mechanic_name');
            $table->bigInteger('vehicle_id')->unsigned();
            $table->string('vehicle_name');
            $table->bigInteger('chasier_id')->unsigned();
            $table->string('chasier_name');
            $table->bigInteger('customer_id')->unsigned();
            $table->string('customer_name');
            $table->integer('quantity');
            $table->datetime('date');
            $table->bigInteger('grand_total');
            $table->text('description');
            $table->bigInteger('spare_part_id')->unsigned();
            $table->string('spare_part_name');
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
