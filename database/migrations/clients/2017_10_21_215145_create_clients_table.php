<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('cno');
            //$table->unsignedTinyInteger('cage');
            $table->date('cbirthday');
            //$table->string('caddress',50);
            $table->char('province',8);
            $table->char('city',8);
            $table->char('area',8);
            $table->string('street',32);
            $table->string('csymptom',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
