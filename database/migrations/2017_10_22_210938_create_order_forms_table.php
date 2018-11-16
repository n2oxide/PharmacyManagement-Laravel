<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_forms', function (Blueprint $table) {
            $table->increments('ono');
            $table->unsignedInteger('ano');
            $table->foreign('ano')->references('ano')->on('agencies')->onDelete('restrict');
            $table->unsignedInteger('cno');
            $table->foreign('cno')->references('cno')->on('clients');
            $table->dateTime('created_at');
            //$table->enable('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_forms');
    }
}
