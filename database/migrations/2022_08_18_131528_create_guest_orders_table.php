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
        Schema::create('guest_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id');
            $table->foreign('guest_id')->references('id')->on('guests');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->string('items');
            $table->string('quantity');
            $table->string('payment_id');
            $table->json('acquirer_data');
            $table->json('card')->nullable();
            $table->string('upi')->nullable();
            $table->string('wallet')->nullable();
            $table->string('method');
            $table->string('bank_name')->nullable();
            $table->string('status');
            $table->string('cost');
            $table->string('fee')->nullable();
            $table->string('tax')->nullable();
            $table->boolean('amount_refunded')->default(false);
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
        Schema::dropIfExists('guest_orders');
    }
};
