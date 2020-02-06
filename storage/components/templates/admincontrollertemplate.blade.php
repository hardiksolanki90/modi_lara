namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class {{ $object }}Controller extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = app()->context->component
        ->where(['variable' => '{{ $variable }}'])
        ->first();
    }

    public function initListing(Request $request)
    {
        $this->page['title'] = '{{ ucfirst($comp_obj->name) }}';
        if ($this->component->is_admin_create) {
          $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
  <?php if (count($rels = $comp_obj->fields()->where('column_type', 'relationship')->get())) : ?>
          ${{ $variable }} = app()->context->{{ $variable }}
    <?php foreach ($rels as $rel) : ?>
      <?php if ($rel->relationship_type == 'belongsToMany') : ?>
          ->leftJoin('<?php echo $rel->mediator_table ?>', '<?php echo $rel->mediator_table ?>.<?php echo $rel->mediator_table_key ?>', '=', '<?php echo $rel->core_component->table ?>.id')
          ->leftJoin('<?php echo $rel->component->variable ?>', '<?php echo $rel->component->variable ?>.id', '=', '<?php echo $rel->mediator_table ?>.<?php echo $rel->local_key ?>')
      <?php endif; ?>
      <?php if ($rel->relationship_type == 'belongsTo') : ?>
          ->leftJoin('<?php echo $rel->component->table ?>', '<?php echo $rel->component->table ?>.<?php echo $rel->foreign_key ?>', '=', '<?php echo $rel->core_component->table ?>.<?php echo $rel->local_key ?>')
      <?php endif; ?>
      <?php if ($rel->relationship_type == 'hasMany') : ?>
          ->leftJoin('<?php echo $rel->component->table ?>', '<?php echo $rel->component->table ?>.id_<?php echo $rel->core_component->variable ?>', '=', '<?php echo $rel->core_component->table ?>.id')
      <?php endif; ?>
    <?php endforeach; ?>
          ->select('<?php echo $comp_obj->variable ?>.*')
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
  <?php else : ?>
          ${{ $variable }} = app()->context->{{ $variable }}
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
  <?php endif; ?>
        } else {
          ${{ $variable }} = app()->context->{{ $variable }}
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count(${{ $variable }}->get());
        $this->obj = ${{ $variable }}->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => '{{ $variable }}',
          'obj' => $this->obj,
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = view('{{ $variable }}/_partials/list-only-{{ $variable }}', $data);
          $html = prepareHTML($html);
          return json('success', $html, true, prepareHTML(${{ $variable }}->paginate(25)->links()));
        }

        return $this->template('{{ $variable }}.list');
    }

    public function initContentCreate($id = null)
    {
        if ($this->component->is_admin_list) {
          $this->page['action_links'][] = [
            'text' => t($this->component->name),
            'slug' => route($this->component->variable . '.list'),
            'icon' => '<i class="material-icons">reply</i>'
          ];
        }

        if ($this->component->is_admin_create && $id) {
          $this->page['action_links'][] = [
            'text' => t('Add'),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->obj = app()->context->{{ $variable }};
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        if (!$id) {
          $this->page['title'] = 'Add {{ ucfirst($comp_obj->name) }}';
        } else {
          $this->page['title'] = '{{ ucfirst($comp_obj->name) }}: ' . $this->obj->name;
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('{{ $variable }}.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = app()->context->{{ $variable }};

        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $data = $this->obj;
  <?php $no_relationship = $comp_obj
  ->fields()
  ->where('column_type', '!=', 'relationship')
  ->where('column_type', '!=', 'file')
  ->where('is_fillable', 1)
  ->get(); ?>
    <?php if (count($no_relationship)) : ?>
      <?php foreach ($no_relationship as $field) : ?>
        $data->{{ $field->field_name }} = input('{{ $field->field_name }}');
      <?php endforeach; ?>
    <?php endif; ?>
  <?php $file = $comp_obj->fields()
  ->where('column_type', 'file')
  ->where('is_fillable', 1)
  ->get(); ?>
  <?php if (count($file)) : ?>
    <?php foreach ($file as $field) : ?>
      $path = config('adlara.request')->file('file')->store('files');
      $data->{{ $field->field_name }} = $path;
    <?php endforeach; ?>
  <?php endif; ?>

  <?php $relationships2 = $comp_obj->fields()
  ->where('column_type', 'relationship')
  ->where('relationship_type', '!=', 'belongsToMany')
  ->where('relationship_type', '!=', 'hasMany')
  ->where('is_fillable', 1)
  ->get(); ?>
    <?php if (count($relationships2)) : ?>
      <?php foreach ($relationships2 as $field) : ?>
        $data->{{ $field->field_name }} = input('{{ $field->field_name }}');
      <?php endforeach; ?>
    <?php endif; ?>
        $data->save();


<?php $relationships = $comp_obj->fields()
->where('column_type', 'relationship')
->where('relationship_type', 'belongsToMany')
->where('is_fillable', 1)
->get(); ?>
  <?php if (count($relationships)) : ?>
    <?php foreach ($relationships as $field) : ?>
        if (count(input('{{ $field->field_name }}'))) {
          if ($id) {
            \App\Objects\{{ makeObject($field->mediator_table) }}::where('{{ $field->mediator_table_key }}', $data->id)->forceDelete();
          }
          foreach (input('{{ $field->field_name }}') as $input) {
            $re = new \App\Objects\{{ makeObject($field->mediator_table) }};
            $re->{{ $field->local_key }} = $input;
            $re->{{ $field->mediator_table_key }} = $data->id;
            $re->save();
          }
        }
    <?php endforeach; ?>
  <?php endif; ?>

<?php $relationships = $comp_obj->fields()
->where('column_type', 'relationship')
->where('relationship_type', 'hasMany')
->where('is_fillable', 1)
->get(); ?>
  <?php if (count($relationships)) : ?>
    <?php foreach ($relationships as $field) : ?>
        if (count($datas = explode(',', input('{{ $field->field_name }}')))) {
          if ($id) {
            \App\Objects\{{ makeObject($field->component->variable) }}::where('id_<?php echo $field->core_component->name ?>', $data->id)->forceDelete();
          }
          foreach ($datas as $input) {
            $re = new \App\Objects\{{ makeObject($field->component->variable) }};
            $re->{{ $field->field_name }} = $input;
            $re->id_<?php echo $field->core_component->name ?> = $data->id;
            $re->save();
          }
        }
    <?php endforeach; ?>
  <?php endif; ?>
        if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = app()->context-><?php echo $comp_obj->variable ?>->find($id);
        if ($obj) {
          $obj->delete();
          <?php $relationships = $comp_obj->fields()
          ->where('column_type', 'relationship')
          ->where('relationship_type', 'belongsToMany')
          ->where('is_fillable', 1)
          ->get(); ?>
          <?php if (count($relationships)) : ?>
            <?php foreach ($relationships as $field) : ?>
          \App\Objects\<?php echo makeObject($field->mediator_table) ?>::where('<?php echo $field->mediator_table_key ?>', $obj->id)->delete();
            <?php endforeach; ?>
          <?php endif; ?>
          $this->flash('success', '<?php echo ucwords($comp_obj->name) ?> with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('<?php echo $comp_obj->variable ?>.list'));
    }
}
