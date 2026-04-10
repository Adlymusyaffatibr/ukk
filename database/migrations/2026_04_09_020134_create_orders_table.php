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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_member')->default(false);
            $table->integer('total_price');
            $table->integer('paid');
            $table->integer('change');
            $table->integer('points_used')->default(0);
            $table->integer('points_earned')->default(0);
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
