<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('admin_menu', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name')->default()->nullable();
          $table->string('slug')->default()->nullable();
          $table->integer('id_head')->default()->nullable();
          $table->integer('id_website')->default()->nullable();
          $table->integer('id_lang')->default()->nullable();
          $table->timestamps();
          $table->softDeletes();
          $table->engine = 'InnoDB';
      });

        $components[0] = [
          'name' => 'Pages',
          'slug' => '',
          'id_head' => 2,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[1] = [
          'name' => 'Block',
          'slug' => '',
          'id_head' => 2,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[2] = [
          'name' => 'Admin Menus',
          'slug' => '',
          'id_head' => 3,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[3] = [
          'name' => 'Components',
          'slug' => '',
          'id_head' => 3,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[4] = [
          'name' => 'Post',
          'slug' => '',
          'id_head' => 2,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[5] = [
          'name' => 'Dashboard',
          'slug' => 'dashboard',
          'id_head' => 1,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[6] = [
          'name' => 'Admin Users',
          'slug' => 'admin_user.list',
          'id_head' => 3,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        foreach ($components as $component) {
          $c = \Illuminate\Support\Facades\DB::table('admin_menu')->insert($component);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menu');
    }
}
