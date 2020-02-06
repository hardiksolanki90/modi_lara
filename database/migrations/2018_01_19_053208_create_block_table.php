<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('content')->nullable();
            $table->string('identifier')->nullable();
            $table->integer('status')->unsigned();
            $table->integer('id_website')->unsigned()->nullable();
            $table->integer('id_lang')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block');
    }
}
