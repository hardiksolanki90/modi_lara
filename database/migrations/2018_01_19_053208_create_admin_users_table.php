<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Password is hardikera1
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('mobile')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        
        // Password is hardikera1
        $data = [
          'name' => 'Hardik Solanki',
          'email' => 'hardik@hardiksolanki.com',
          'password' => '$2y$10$sMIZfZ1YrRmvmgm0zgYicu1JEF8mr2Kxz.FevFkyI67h2whX5PkQi'
        ];
        \Illuminate\Support\Facades\DB::table('admin_users')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
