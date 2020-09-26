<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('itemName');
            $table->string('UOM');
            $table->integer('unitPrice');
            $table->integer('quantity');
            $table->integer('totalPrice');
            $table->integer('userId')->unsigned();
            $table->integer('jobId')->unsigned();
            $table->integer('quotationId')->unsigned();
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jobId')->references('id')->on('jobs')->onDelete('cascade');
            $table->foreign('quotationId')->references('id')->on('quotations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
