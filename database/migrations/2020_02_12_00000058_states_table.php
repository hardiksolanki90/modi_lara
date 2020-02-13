use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
          $table->increments('id');
                                                  $table->string('state_name')->default()->nullable();
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
        Schema::dropIfExists('states');
    }
}
