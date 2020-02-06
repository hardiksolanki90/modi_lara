<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminMenuHeading extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menu_heading', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default()->nullable();
            $table->integer('id_website')->default()->nullable();
            $table->integer('id_lang')->default()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        $components[0] = [
          'name' => 'Dashboard',
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[1] = [
          'name' => 'Components',
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[2] = [
          'name' => 'Settings',
          'id_website' => 1,
          'id_lang' => 1,
        ];

        foreach ($components as $component) {
          $c = \Illuminate\Support\Facades\DB::table('admin_menu_heading')->insert($component);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menu_heading');
    }
}
