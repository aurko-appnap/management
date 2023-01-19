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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('slug')->nullable();
            $table->string('brand')->nullable();
            $table->text('product_description')->nullable();
            $table->string('price')->nullable();
            $table->string('display_picture')->nullable();
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
