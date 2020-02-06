use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class {{ makeObject($comp_obj->table) }}Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ $comp_obj->table }}', function (Blueprint $table) {
          $table->increments('id');
      @foreach ($comp_obj->fields as $column)
        @if ($column->default)
          <?php $default = "$column->default" ?>
        @else
          <?php $default = null ?>
        @endif
        @if ($column->column_type == 'integer' || ($column->column_type == 'relationship' && $column->relationship_type != 'belongsToMany'))
          $table->integer('{{ $column->field_name }}')->unsigned()->default({{ $default }}){!! (!$default ? '->nullable()' : '') !!};
        @elseif ($column->column_type != 'relationship')
          $table->{{ $column->column_type }}('{{ $column->field_name }}')->default({{ $default }}){!! (!$default ? '->nullable()' : '') !!};
        @endif
      @endforeach
          $table->timestamps();
          $table->softDeletes();
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
        Schema::dropIfExists('{{ $comp_obj->table }}');
    }
}
