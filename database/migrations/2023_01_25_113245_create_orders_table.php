<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_code')->constanted()->onDelete('cascade')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_cost')->nullable();
            $table->string('total_price')->nullable();
            $table->integer('order_status')->nullable();
            $table->date('order_placed_on')->nullable();
            $table->date('order_delivered_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
