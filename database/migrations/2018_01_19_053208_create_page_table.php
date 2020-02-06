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

class CreatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('content')->nullable();
            $table->string('url')->nullable();
            $table->integer('status')->unsigned()->default(0);
            $table->integer('id_website')->unsigned()->nullable();
            $table->integer('id_featured_image')->unsigned()->nullable();
            $table->integer('id_lang')->unsigned()->default(1);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        $res = curl_request('https://v56.adlara.com/api/pages');
        $pages = json_decode($res, true);

        if (is_array($pages)) {
          foreach ($pages as $page) {
            \Illuminate\Support\Facades\DB::table('page')->insertGetId($page);
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
        Schema::dropIfExists('page');
    }
}
