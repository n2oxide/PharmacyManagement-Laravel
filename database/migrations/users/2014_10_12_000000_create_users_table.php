<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',8);//
            $table->char('sex',1);//
            $table->char('phone',12)->unique();//
            //$table->string('email')->unique();
            $table->tinyInteger('permission_token')->default(2);//0 admin 1agency 2client
            $table->string('password');
            $table->unsignedInteger('ano')->nullable();
            $table->foreign('ano')->references('ano')->on('agencies')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('cno')->nullable();
            $table->foreign('cno')->references('cno')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->string('remark',50)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
