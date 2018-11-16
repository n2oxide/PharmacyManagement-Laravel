<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->char('mno',12);
	          $table->primary('mno');
	          $table->string('mname',50);
            $table->char('mmode',2);
            $table->string('mefficacy',50);
	          $table->unsignedMediumInteger('mnum');
            $table->date('mouttime');
            $table->unsignedInteger('ano');
            $table->foreign('ano')->references('ano')->on('agencies')->onDelete('restrict');
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
        Schema::dropIfExists('medicines');
    }
}
