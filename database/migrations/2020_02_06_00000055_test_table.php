use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('test', function (Blueprint $table) {
          $table->increments('id');
                                                  $table->string('test')->default()->nullable();
                                                          $table->longText('textarea')->default()->nullable();
                                                          $table->string('meta_title')->default()->nullable();
                                                          $table->string('meta_description')->default()->nullable();
                                                          $table->string('meta_keywords')->default()->nullable();
                                                          $table->string('meta_title')->default()->nullable();
                                                          $table->string('meta_description')->default()->nullable();
                                                          $table->string('meta_keywords')->default()->nullable();
                                                          $table->string('meta_title')->default()->nullable();
                                                          $table->string('meta_description')->default()->nullable();
                                                          $table->string('meta_keywords')->default()->nullable();
                                                          $table->string('meta_title')->default()->nullable();
                                                          $table->string('meta_description')->default()->nullable();
                                                          $table->string('meta_keywords')->default()->nullable();
                                                          $table->string('meta_title')->default()->nullable();
                                                          $table->string('meta_description')->default()->nullable();
                                                          $table->string('meta_keywords')->default()->nullable();
                                                          $table->string('meta_title')->default()->nullable();
                                                          $table->string('meta_description')->default()->nullable();
                                                          $table->string('meta_keywords')->default()->nullable();
                                                          $table->string('meta_title')->default()->nullable();
                                                          $table->string('meta_description')->default()->nullable();
                                                          $table->string('meta_keywords')->default()->nullable();
                        $table->timestamps();
          $table->softDeletes();
          $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('test');
    }
}
