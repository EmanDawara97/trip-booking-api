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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
$table->foreignId('customer_id')->constrained();
    $table->foreignId('trip_id')->constrained();
    $table->foreignId('seat_id')->constrained();
    $table->string('status')->default('pending'); 
    $table->decimal('price', 10, 2);
    $table->timestamps();

    $table->index(['seat_id', 'status']);            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
