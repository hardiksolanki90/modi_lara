<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostTagAssign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag_assign', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_post')->default()->nullable();
            $table->string('id_tag')->default()->nullable();
            $table->integer('id_website')->default()->nullable();
            $table->integer('id_lang')->default()->nullable();
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
        Schema::dropIfExists('post_tag_assign');
    }
}
