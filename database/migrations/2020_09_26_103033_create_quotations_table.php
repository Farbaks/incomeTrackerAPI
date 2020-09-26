<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('salesPerson')->nullable();
            $table->integer('quotationValidity');
            $table->string('paymentTerms')->nullable();
            $table->string('refNumber')->nullable();
            $table->date('deliveryDate')->nullable();
            $table->string('currency');
            $table->integer('subTotalJobCost');
            $table->integer('totalJobCost');
            $table->integer('profit');
            $table->text('comment');
            $table->integer('userId')->unsigned();
            $table->integer('jobId')->unsigned();
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jobId')->references('id')->on('jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
