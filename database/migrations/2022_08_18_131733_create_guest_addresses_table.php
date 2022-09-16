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
        Schema::create('guest_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("guest_id");
            $table->foreign('guest_id')->references('id')->on('guests');
            $table->string('name');
            $table->string('phone');
            $table->boolean('selected')->default(1);
            $table->string('address');
            $table->string('landmark')->nullable();
            $table->integer('zipcode');
            $table->string('city');
            $table->string('state');
            $table->string('country');
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
        Schema::dropIfExists('guest_addresses');
    }
};
