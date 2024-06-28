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
        Schema::create('dish_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('dish_id')->references('id')->on('dishes')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->string('dish_name');
            $table->integer('dish_quantity')->default(1);
            $table->decimal('dish_price', 6, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_order');
    }
};
