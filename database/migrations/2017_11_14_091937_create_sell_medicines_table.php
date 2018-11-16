<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_medicines', function (Blueprint $table) {
            $table->unsignedInteger('ono');
	    $table->foreign('ono')->references('ono')->on('order_forms');
            $table->char('mno',12);
	    $table->foreign('mno')->references('mno')->on('medicines');
            $table->primary(['ono','mno']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_medicines');
    }
}
