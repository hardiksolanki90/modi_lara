use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
          $table->increments('id');
                                                  $table->string('name')->default()->nullable();
                                                          $table->string('email')->default()->nullable();
                                                          $table->string('mobile')->default()->nullable();
                                                          $table->string('password')->default()->nullable();
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
        Schema::dropIfExists('customer');
    }
}
