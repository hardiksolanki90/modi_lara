<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminMenuChild extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menu_child', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default()->nullable();
            $table->string('slug')->default()->nullable();
            $table->integer('id_menu')->default()->nullable();
            $table->integer('id_website')->default()->nullable();
            $table->integer('id_lang')->default()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        $components[0] = [
          'name' => 'Blocks',
          'slug' => 'block.list',
          'id_website' => 1,
          'id_lang' => 1,
          'id_menu' => 2,
        ];

        $components[1] = [
          'name' => 'Add new',
          'slug' => 'block.add',
          'id_menu' => 2,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[2] = [
          'name' => 'Headings',
          'slug' => 'menu_heading.list',
          'id_menu' => 3,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[3] = [
          'name' => 'Sub Headings',
          'slug' => 'admin_menu.list',
          'id_menu' => 3,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[4] = [
          'name' => 'Child Menu',
          'slug' => 'admin_menu_child.list',
          'id_menu' => 3,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[5] = [
          'name' => 'Pages',
          'slug' => 'page.list',
          'id_menu' => 1,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[6] = [
          'name' => 'Add new',
          'slug' => 'page.add',
          'id_menu' => 1,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[7] = [
          'name' => 'Components',
          'slug' => 'component.list',
          'id_menu' => 4,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[8] = [
          'name' => 'Add new',
          'slug' => 'component.add',
          'id_menu' => 4,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[9] = [
          'name' => 'Posts',
          'slug' => 'post.list',
          'id_menu' => 5,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[10] = [
          'name' => 'Categories',
          'slug' => 'post_category.list',
          'id_menu' => 5,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[11] = [
          'name' => 'Tags',
          'slug' => 'post_tags.list',
          'id_menu' => 5,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[12] = [
          'name' => 'Admin Users',
          'slug' => 'admin_user.list',
          'id_menu' => 7,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        $components[13] = [
          'name' => 'Add new',
          'slug' => 'admin_user.add',
          'id_menu' => 7,
          'id_website' => 1,
          'id_lang' => 1,
        ];

        foreach ($components as $component) {
          $c = \Illuminate\Support\Facades\DB::table('admin_menu_child')->insert($component);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menu_child');
    }
}
