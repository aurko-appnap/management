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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constanted()->nullable();
            $table->foreignId('entity_id')->constanted()->nullable();
            $table->string('entity_type')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('transaction_amount')->nullable();
            $table->string('transaction_message')->nullable();
            $table->string('transaction_method')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
