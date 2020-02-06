<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

if (!function_exists('curl_request')) {  
  function curl_request($url)
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);

    if($errno = curl_errno($curl)) {
      $error_message = curl_strerror($errno);
      return $error_message;
    }

    // Close request to clear up some resources
    curl_close($curl);

    return $resp;
  }
}

class CreateComponentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('table');
            $table->string('variable');
            $table->string('slug');
            $table->string('controller');
            $table->integer('is_front_create')->unsigned();
            $table->integer('is_front_view')->unsigned();
            $table->integer('is_front_list')->unsigned();
            $table->integer('is_admin_create')->unsigned();
            $table->integer('is_admin_list')->unsigned();
            $table->integer('is_admin_delete')->unsigned();
            $table->integer('is_login_needed')->unsigned()->nullable();
            $table->integer('is_meta_needed')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('component_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_component')->unsigned();
            $table->string('field_name');
            $table->string('field_text');
            $table->string('column_type');
            $table->string('input_type');
            $table->integer('use_in_listing')->unsigned();
            $table->integer('is_fillable')->unsigned();
            $table->integer('required')->unsigned();
            $table->integer('default')->nullable();
            $table->string('class')->nullable();
            $table->string('relationship_type')->nullable();
            $table->string('reference_name')->nullable();
            $table->string('relational_component_name')->nullable();
            $table->string('foreign_key')->nullable();
            $table->string('local_key')->nullable();
            $table->string('mediator_table')->nullable();
            $table->string('mediator_table_key')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        $res = curl_request('https://v56.adlara.com/api/components');
        $components = json_decode($res, true);

        if (is_array($components)) {
          foreach ($components as $component) {
            $component_fields = $component['fields'];
            unset($component['fields']);
            $c = \Illuminate\Support\Facades\DB::table('component')->insertGetId($component);
            foreach ($component_fields as $field) {
              $field['id_component'] = $c;
              \Illuminate\Support\Facades\DB::table('component_fields')->insert($field);
            }
          }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component');
        Schema::dropIfExists('component_fields');
    }
}
