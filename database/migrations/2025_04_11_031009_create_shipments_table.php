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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('carrier_id');
            $table->string('origin');
            $table->string('destination');
            $table->dateTime('estimated_delivery');
            $table->timestamps();
        
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('carrier_id')->references('id')->on('carriers')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
