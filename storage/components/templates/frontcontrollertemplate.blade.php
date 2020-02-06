
namespace App\Http\Controllers\FrontControllers;

use App\Http\Controllers\FrontController;
use Input;
use Illuminate\Http\Request;

class {{ ucfirst($variable) }}Controller extends FrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = $this->context->component
        ->where(['variable' => '{{ $variable }}'])
        ->first();
    }

    public function initListing()
    {
        ${{ $variable }} = $this->context->{{ $variable }}
        ->orderBy('id', 'desc')
        ->paginate(25);

        $this->assign = [
          '{{ $variable }}' => ${{ $variable }}
        ];

        return $this->template('{{ $variable }}.list');
    }

    public function initContentCreate($id = null)
    {
        $this->obj = $this->context->{{ $variable }};
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('{{ $variable }}.create');
    }

    public function initContent($url = null)
    {
        ${{ $variable }} = $this->context->{{ $variable }}->findByURL($url);

        $this->obj = ${{ $variable }};

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('{{ $variable }}.view');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = $this->context->{{ $variable }};

        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $fillables = $this->component->fields
        ->where('is_fillable', 1);

        if (!count($fillables)) {
          return json('error', t('We could not find any fillable fields'));
        }

        $fill = [];
        foreach ($fillables as $field) {
          $fill[makeColumn($field->field_name)] = Input::get($field->field_name);
        }

        $data = $this->obj->fill($fill);
        $data->save();

        return json('success', t($this->component->name . ' updated'));
    }
}
