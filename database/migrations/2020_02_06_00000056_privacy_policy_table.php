use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrivacyPolicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('privacy_policy', function (Blueprint $table) {
          $table->increments('id');
                                                  $table->string('name')->default()->nullable();
                                                          $table->string('identifier')->default()->nullable();
                                                          $table->text('content')->default()->nullable();
                                                          $table->integer('id_key')->unsigned()->default()->nullable();
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
        Schema::dropIfExists('privacy_policy');
    }
}
