<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue', 250)->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedTinyInteger('reserved')->index();
            $table->unsignedInteger('reserved_at')->index();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
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
        Schema::dropIfExists('jobs');
    }
}
