<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Request;
use Illuminate\Support\Facades\Cache;
use App\Objects\Configuration;
use Input;
use Schema;
use Illuminate\Database\Schema\Blueprint;
use View;
use DB;

class ComponentController extends AdminController
{
    private $admin_controller;

    private $front_controller;

    private $object;

    private $data;

    private $field_type;

    private $required;

    private $listing;

    private $default;

    private $fillable;

    private $class;

    private $input_type;

    private $relationship_type;

    private $relational_component_name;

    private $foreign_key;

    private $local_key;

    private $mediator_table;

    private $mediator_table_key;

    private $reference_name;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->data = new \stdClass;
        view()->addLocation(base_path('storage/components/templates'));

        $this->page['title'] = 'Component';
    }

    public function initContentCreate($id = null)
    {
        $tables = DB::table('INFORMATION_SCHEMA.TABLES')
               ->select('*')
               ->get();
        $table_list = array();
        foreach ($tables as $key => $table) {
          if ($table->TABLE_TYPE != 'SYSTEM VIEW') {
            $table_list[$key]['name'] = $table->TABLE_NAME;
            $table_list[$key]['value'] = $table->TABLE_NAME;
          }
        }

        $component = $this->context->component;
        if ($id) {
          $component = $this->context->component->find($id);
        }

        $column_types = [
          'string' => 'Varchar',
          'integer' => 'Integer',
          'incremental' => 'Auto Incremental',
          'bigInteger' => 'Big Integer',
          'text' => 'Text',
          'longText' => 'Long Text',
          'datetime' => 'Date Time',
          'date' => 'Date',
          'time' => 'time',
          'decimal' => 'Decimal',
          'relationship' => 'Relationship'
        ];

        $this->page['action_links'][] = [
          'text' => 'Add fields',
          'slug' => route('component.add'),
          'icon' => '<i class="material-icons">add_circle_outline</i>',
          'class' => '_ac'
        ];

        $this->page['action_links'][] = [
          'text' => 'List',
          'slug' => route('component.list'),
          'icon' => '<i class="material-icons">list</i>'
        ];

        $optionValue = array('1' => 'Yes', '0' => 'No');

        $this->component = $component;

        $this->assign = [
          'optionValue' => $optionValue,
          'column_types' => $column_types,
          'table_list' => $table_list,
        ];

        return $this->template('component.add');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();

        $field_type = Input::get('column_type');
        $required = Input::get('required_field');
        $listing = Input::get('use_in_listing');
        $default = Input::get('default');
        $fillable = Input::get('fillable');
        $class = Input::get('class');
        $input_type = Input::get('input_type');
        $relationship_type = Input::get('relationship_type');
        $relational_component_name = Input::get('relational_component_name');
        $foreign_key = Input::get('foreign_key');
        $local_key = Input::get('local_key');
        $mediator_table = Input::get('mediator_table');
        $mediator_table_key = Input::get('mediator_table_key');
        $reference_name = Input::get('reference_name');

        $this->relationship_type = Input::get('relationship_type');
        $this->fields = makeColumn(Input::get('field'));
        $this->table_fields = makeColumn(Input::get('field'));
        $this->local_key = Input::geT('local_key');
        $this->variable = Input::get('variable');

        if (count(Input::get('column_type'))) {
          foreach (Input::get('column_type') as $key => $ct) {
            $key_number = $key + 1;
            if (!$ct) {
              return json('error', 'Please provide column type for column ' . $key_number);
            }

            $field_number = $key + 1;
            if ($ct == 'relationship') {
              if (!$relationship_type[$key]) {
                return json('error', t('Choose relationship type for field number ' . $field_number ));
              }

              if (!$relational_component_name[$key]) {
                return json('error', t('Choose Relational Component Name.'));
              }

              if ($relationship_type[$key] == 'hasOne' ||  $relationship_type[$key] == 'hasMany'||  $relationship_type[$key] == 'belongsTo') {
                if (!$foreign_key[$key]) {
                  return json('error', t('Please Supply Foreign Key.'));
                }
              }

              if ($relationship_type[$key] == 'belongsToMany' || $relationship_type[$key] == 'hasManyThrough') {
                if (!$mediator_table[$key]) {
                  return json('error', t('Please supply mediator table.'));
                }

                if (!$mediator_table_key[$key]) {
                  return json('error', t('Please supply mediator table key.'));
                }
              }

              if (!$local_key[$key]) {
                return json('error', t('Please supply local key.'));
              }

              if ($this->relationship_type[$key] == 'belongsTo') {
                $this->fields[$key] = $this->local_key[$key];
              }

            }
          }
        }

        if (!$id && Schema::hasTable(Input::get('table'))) {
          return json('error', t('Table already exists'));
        }

        $component = $this->context->component;

        $actual = new \stdClass;

        if (!$id && $component->check('variable', Input::get('variable'))) {
          return json('error', t('Variable is already in use, please choose another'));
        }

        if ($id) {
          $component = $this->context->component->find($id);
          $actual = $this->context->component->find($id);
          $this->component = $component;
        }

        $c = $this->context->component->where('variable', Input::get('variable'))->first();
        if (c($c)) {
          // $c->fields()->delete();
          // $c->delete();
          $component = $c;
        }

        $this->component = $component;

        $component->name = Input::get('name');
        $component->table = Input::get('table');
        $component->variable = Input::get('variable');
        $component->slug = Input::get('slug');
        $component->controller = Input::get('controller');
        $component->is_admin_create = Input::get('is_admin_create');
        $component->is_admin_list = Input::get('is_admin_list');
        $component->is_admin_delete = Input::get('is_admin_delete');
        $component->is_front_create = Input::get('is_front_create');
        $component->is_front_view = Input::get('is_front_view');
        $component->is_front_list = Input::get('is_front_list');
        $component->is_meta_needed = Input::get('is_meta_needed');
        $component->save();

        if ($id && count($component->fields)) {
          $component->fields()->delete();
        }

        if (count($this->fields)) {
          $field_type = Input::get('column_type');
          $required = Input::get('required_field');
          $listing = Input::get('use_in_listing');
          $default = Input::get('default');
          $fillable = Input::get('fillable');
          $class = Input::get('class');
          $input_type = Input::get('input_type');
          $relationship_type = Input::get('relationship_type');
          $relational_component_name = Input::get('relational_component_name');
          $foreign_key = Input::get('foreign_key');
          $local_key = Input::get('local_key');
          $mediator_table = Input::get('mediator_table');
          $mediator_table_key = Input::get('mediator_table_key');
          $reference_name = Input::get('ref_name');

          foreach ($this->fields as $key => $field) {
            if ($field_type[$key] == 'relationship' && $relationship_type[$key] == 'belongsToMany') {
              if ($input_type[$key] != 'select' && $input_type[$key] != 'checkbox' && $input_type[$key] != 'media_image' && $input_type[$key] != 'media_pdf' && $input_type[$key] != 'media_video') {
                $input_type[$key] = 'checkbox';
              }
            }

            if (!$field && $field_type[$key] != 'relationship') {
              continue;
            }

            $cf = \App\Objects\ComponentFields::where('id_component', $component->id)->where('field_name', makeColumn($field))->first();
            if (c($cf) && $field_type[$key] != 'relationship') {
              continue;
            }

            //save Component Fileds
            $cf = new \App\Objects\ComponentFields;
            $cf->id_component = $component->id;
            $cf->field_name = makeColumn($field);
            $cf->field_text = $field;
            $cf->column_type = $field_type[$key];
            $cf->input_type = $input_type[$key];
            $cf->required = $required[$key];
            $cf->use_in_listing = $listing[$key];
            $cf->is_fillable = $fillable[$key];
            $cf->default = $default[$key];
            $cf->class = $class[$key];
            $cf->relationship_type = $relationship_type[$key];
            $cf->reference_name = $reference_name[$key];
            $cf->relational_component_name = $relational_component_name[$key];
            $cf->foreign_key = $foreign_key[$key];
            $cf->local_key = $local_key[$key];
            $cf->mediator_table = $mediator_table[$key];
            $cf->mediator_table_key = $mediator_table_key[$key];
            $cf->save();
          }
        }

        $this->component_fields = $component->fields;
        if (Input::get('is_meta_needed')) {
          $cf = new \App\Objects\ComponentFields;
          $cf->id_component = $component->id;
          $cf->field_name = 'meta_title';
          $cf->field_text = 'Meta Title';
          $cf->column_type = 'string';
          $cf->input_type = 'text';
          $cf->required = 0;
          $cf->use_in_listing = 0;
          $cf->is_fillable = 1;
          $cf->default = null;
          $cf->class = '';
          $cf->save();

          $cf = new \App\Objects\ComponentFields;
          $cf->id_component = $component->id;
          $cf->field_name = 'meta_description';
          $cf->field_text = 'Meta Description';
          $cf->column_type = 'string';
          $cf->input_type = 'textarea';
          $cf->required = 0;
          $cf->use_in_listing = 0;
          $cf->is_fillable = 1;
          $cf->default = null;
          $cf->class = '';
          $cf->save();

          $cf = new \App\Objects\ComponentFields;
          $cf->id_component = $component->id;
          $cf->field_name = 'meta_keywords';
          $cf->field_text = 'Meta Keywords';
          $cf->column_type = 'string';
          $cf->input_type = 'text';
          $cf->required = 0;
          $cf->use_in_listing = 0;
          $cf->is_fillable = 1;
          $cf->default = null;
          $cf->class = 'my-input';
          $cf->save();
          $this->component_fields = \App\Objects\ComponentFields::where('id_component', $component->id)->get();
          $this->table_fields = $this->component_fields->pluck('field_name')->toArray();
        }

        $this->initProcessCreateTable($actual); //Check 1 Done
        $this->initProcessGenerateMigrations($actual); //Check 1 Done
        $this->initProcessContextFile($actual); //Check 1 Done
        $this->initProcessObjectFile($actual); //Check 1 Done
        $this->initProcessViewFile($actual);  //Check 1 Done
        $this->initProcessControllerFile($actual); //Check 1 Done
        if (!$id || Input::get('reset')) {
          $this->initProcessRouteFile($actual); //Check 1 Done
        }

        if ($id) {
          return json('success', 'Component Update');
        }

        return json('redirect', route('component.edit', ['id' => $component->id]));
    }

    public function initProcessCreateTable($actual)
    {
        //Is table require to rename?
        if (isset($actual->table) && $actual->table != Input::get('table')) {
          Schema::rename($actual->table, Input::get('table'));
        }

        if (Schema::hasTable(Input::get('table'))) {
          Schema::table(Input::get('table'), function($table) {
            $generic_keys = ['id', 'id_website', 'id_lang', 'created_at', 'updated_at', 'deleted_at'];
            $table_columns = Schema::getColumnListing(Input::get('table'));
            $added_table_columns = array_values(array_diff($table_columns, $generic_keys));
            $rename_columns = [];
            //Check if any column is renamed by comparing $this->fields & $added_table_columns
            // foreach ($this->fields as $key_fie => $fie) {
            //   if (isset($added_table_columns[$key_fie]) && $added_table_columns[$key_fie] != $fie && !Schema::hasColumn(Input::get('table'), $fie)) { // if this condition matched than rename require
            //     $rename_columns[] = $added_table_columns[$key_fie];
            //     $table->renameColumn($added_table_columns[$key_fie], $fie);
            //     $array_key = array_search($fie, $this->fields);
            //     unset($this->fields[$array_key]);
            //   }
            // }

            //Columns to be deleted
            $deletables_diff = array_diff($table_columns, $this->component_fields->pluck('field_name')->toArray());
            $deletables = array_diff($deletables_diff, $generic_keys);
            if (count($deletables)) {
              foreach ($deletables as $toBeDeleted) {
                $table->dropColumn(makeColumn($toBeDeleted));
              }
            }

            $fi = array_diff($this->table_fields, $table_columns);
            $field_filter = array();
            if (count($fi)) {
              $field_filter = array_diff($fi, $generic_keys);
            }

            if (count($field_filter)) {
              foreach ($field_filter as $f) {
                $field = $this->component_fields->where('field_name', $f)->first();
                if ($field && $field->relationship_type != 'belongstoMany' ) {
                  if (Schema::hasColumn(Input::get('table'), $f) && !in_array($f, $rename_columns)) {
                    $table->dropColumn(makeColumn($f));
                  }
                }
              }
            }

            $column_type = Input::get('column_type');
            $required = Input::get('required_field');
            $default = Input::get('default');
            $l = null;

            if (count($this->table_fields)) {
              $fields_list = $this->component_fields
              ->where('relationship_type', '!=', 'belongsToMany')
              ->where('relationship_type', '!=', 'hasMany');
              foreach ($fields_list as $key => $column) {
                $column_name = str_slug($column->field_name);
                $column_name = str_replace('-', '_', $column->field_name);
                if ($column->relationship_type == 'belongsToMany' || $column->relationship_type == 'hasMany') {
                  continue;
                }

                if ($column && !Schema::hasColumn(Input::get('table'), $column_name)) {
                  if (!$column->column_type) {
                    return json('error', 'Please provide column type for ' . $column_name);
                  }
                  if ($column->column_type == 'string') {
                    $l = 255;
                  }

                  if (isset($column->default)) {
                    $d = $column->default;
                  } else {
                    $d = null;
                  }

                  if ($column->relationship_type == 'belongsTo') {
                    $column->column_type = 'integer';
                  }

                  if ($column->column_type == 'integer') {
                    $table->{$column->column_type}($column_name)->after('id_website')->unsigned()->nullable();
                  } else {
                    $table->{$column->column_type}($column_name, $l)->after('id_website')->default($d)->nullable();
                  }
                }
              }
            }
            $table->engine = 'InnoDB';
          });
        } else {
          Schema::create(Input::get('table'), function (Blueprint $table) {
            $column_type = Input::get('column_type');
            $required = Input::get('required_field');
            $default = Input::get('default');
            $meta = Input::get('is_meta_needed');
            $local_key = Input::get('local_key');
            $l = NULL;

            $table->increments('id');

            if (count($this->fields)) {
              foreach ($this->fields as $key => $column) {
                if ($column && ($this->relationship_type[$key] != 'belongsToMany' && $this->relationship_type[$key] != 'hasMany')) {
                  $column = str_slug($column);
                  $column = str_replace('-', '_', $column);

                  if (!$column_type[$key]) {
                    return json('error', 'Please provide column type for ' . $column);
                  }
                  if ($column_type[$key] == 'string') {
                    $l = 255;
                  }

                  if (isset($default[$key]) && $default[$key]) {
                    $d = $default[$key];
                  } else {
                    $d = null;
                  }

                  if ($this->relationship_type[$key] == 'belongsTo') {
                    $column_type[$key] = 'integer';
                  }

                  if ($column_type[$key] == 'integer') {
                    $table->{$column_type[$key]}($column)->unsigned()->default($d)->nullable();
                  } else {
                    $table->{$column_type[$key]}($column, $l)->default($d)->nullable();
                  }
                } elseif (!$column && $column_type[$key] == 'relationship') {
                  $table->integer($local_key[$key])->unsigned()->nullable();
                }

              }
            }
            $table->integer('id_website')->unsigned()->default(1)->nullable();
            $table->integer('id_lang')->unsigned()->default(1)->nullable();
            $table->engine = 'InnoDB';
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            if ($meta) {
              $table->string('meta_title', 255)->nullable();
              $table->string('meta_description', 255)->nullable();
              $table->string('meta_keywords', 255)->nullable();
            }
            $table->timestamp('deleted_at')->nullable();

          });
        }
    }

    public function initProcessGenerateMigrations($data)
    {
        $data = $this->component;
        $t_date = date("Y-m-d");
        $date = str_replace('-', '_', $t_date);

        // $filename = $data->table . '_table.php';
        $filename = $date . '_000000' . $data->id . '_' . $data->table . '_table.php';
        if (Input::get('reset')) {
          $file = base_path('database/migrations/' . $filename);
          $rename_obj = $filename . '-' . date('Y-m-d H:i:s');
          if (file_exists($file)) {
            $backup = copy($file, base_path('storage/components/backups/migrations/' . $rename_obj));
            unlink($file);
          }
        }
        $columns = DB::select('describe ' . $data->table);
        $date = date('Y_m_d', strtotime($data->created_at));
        $dir = base_path('database/migrations/');
        $pass = [
          'columns' => $columns,
          'comp_obj' => $data,
        ];

        $html = writeHTML('migration', $pass);
        writeFile($dir, $filename, $html);
    }

    public function initProcessContextFile($data)
    {
        $replace = null;
        if (isset($data->variable) && $data->variable != Input::get('variable')) {
          $replace = 'protected $' . $data->variable . ';';
        }

        $property_found = false;
        $ref = new \ReflectionClass($this->context);
        $p = array_keys($ref->getDefaultProperties());
        $last_property = end($p);
        $add_property = 'protected $' . Input::get('variable') . ';';

        $file = fopen(base_path('app/Classes/Context.php'), 'r+');
        $lines = file(base_path('app/Classes/Context.php'), FILE_IGNORE_NEW_LINES);
        $added_property = false;

        foreach ($lines as $line => $text) {
          if (strpos($text, $replace) && $replace) {
            $added_property = true;
            $lines[$line] = formatLine3($add_property);
          }

          if (strpos($text, $add_property)) {
            $property_found = true;
          }

          if (strpos($text, 'protected $' . $last_property) && !$property_found && !$replace) {
            $added_property = true;
            $lines[$line + 1] = formatLine($add_property);
          }
        }

        if (!$added_property && !$property_found) { // If property wasn't added in last operation, do this operation again
          foreach ($lines as $line => $text) {
            if (strpos($text, 'protected $' . $last_property)) {
              $added_property = true;
              $lines[$line + 1] = formatLine($add_property);
            }
          }
        }

        foreach ($lines as $line => $text) {
          fwrite($file, $text.PHP_EOL);
        }

        fclose($file);
    }

    public function initProcessObjectFile($data)
    {
        $field_type = Input::get('column_type');
        $required = Input::get('required_field');
        $listing = Input::get('use_in_listing');
        $default = Input::get('default');
        $fillable = Input::get('fillable');
        $class = Input::get('class');
        $input_type = Input::get('input_type');
        $relationship_type = Input::get('relationship_type');
        $relational_component_name = Input::get('relational_component_name');
        $foreign_key = Input::get('foreign_key');
        $local_key = Input::get('local_key');
        $mediator_table = Input::get('mediator_table');
        $mediator_table_key = Input::get('mediator_table_key');
        $reference_name = Input::get('reference_name');

        $replace = false;
        if (isset($data->variable) && Input::get('variable') != $data->variable) {
          $replace = makeObject($data->variable);
        }

        $object = makeObject(Input::get('variable'));
        $this->object = $object;
        $replace_file = null;
        if ($replace) {
          $replace_file = base_path('app/Objects/' . $replace . '.php');
        }

        $pass = [
          'fields' => $this->component_fields->where('column_type', 'relationship'),
          'object' => $object,
          'table' => Input::get('table')
        ];

        if (!$replace) {
          if (!file_exists(base_path('app/Objects/' . $object . '.php'))) {
            $html = view('objecttemplate', $pass);
            $core = $this->context->tools;
            $core->prepareHTML($html);
            $html = $core->buildHTML();
            $file = fopen(base_path('app/Objects/' . $object . '.php'), 'w');
            fwrite($file, '<?php' . PHP_EOL . $html);
            fclose($file);
          } else {
            if (Input::get('reset')) {
              $file = base_path('app/Objects/' . $object . '.php');
              $rename_obj = $object . '-' . date('Y-m-d H:i:s');
              $backup = copy($file, base_path('storage/components/backups/objects/' . $rename_obj));

              unlink($file);

              $html = view('objecttemplate', $pass);
              $core = $this->context->tools;
              $core->prepareHTML($html);
              $html = $core->buildHTML();
              $file = fopen(base_path('app/Objects/' . $object . '.php'), 'w');
              fwrite($file, '<?php' . PHP_EOL . $html);
              fclose($file);
            }
          }
        } else {
          if (file_exists($replace_file)) {
            $content = file_get_contents($replace_file);
            $string = 'class ' . $replace;
            $string_new = 'class ' . $object;
            $content = str_replace($string, $string_new, $content);
            writeFile(base_path('app/Objects/'), $object . '.php', $content);

            if (file_exists(base_path('app/objects/' . $object . '.php'))) {
              unlink(base_path('app/Objects/' . $replace . '.php')); //Delete older file
            }
          } elseif (!file_exists(base_path('app/Objects/' . $object . '.php'))) {
            $html = view('objecttemplate', $pass);
            $core = $this->context->tools;
            $core->prepareHTML($html);
            $html = $core->buildHTML();
            $file = fopen(base_path('app/Objects/' . $object . '.php'), 'w');
            fwrite($file, '<?php' . PHP_EOL . $html);
            fclose($file);
          }
        }
    }

    public function initProcessControllerFile($data)
    {
        if (Input::get('is_controller_needed') == 'none') {
          return true;
        }

        $replace = null;

        $pass = [
          'variable' => Input::get('variable'),
          'fields' => Input::get('field'),
          'is_admin_list' => Input::get('is_admin_list'),
          'is_admin_create' => Input::get('is_admin_create'),
          'is_admin_delete' => Input::get('is_admin_delete'),
          'object' => $this->object, // return object name in string,
          'comp_obj' => $this->component,
        ];

        //AdminController process
        if (Input::get('controller') == 'both' || Input::get('controller') == 'admin') {
          $this->admin_controller = $this->object . 'Controller.php';
          if (!file_exists(base_path('app/Http/Controllers/AdminControllers/' . $this->admin_controller))) {
            $html = view('admincontrollertemplate', $pass);
            $core = $this->context->tools;
            $core->prepareHTML($html);
            $html = $core->buildHTML();
            $file = fopen(base_path('app/Http/Controllers/AdminControllers/' . $this->admin_controller), 'w');
            fwrite($file, '<?php' . PHP_EOL . $html);
            fclose($file);
          } else {
            if (Input::get('reset')) {
              $file = base_path('app/Http/Controllers/AdminControllers/' . $this->admin_controller);
              $rename_obj = $this->admin_controller . '-' . date('Y-m-d H:i:s');
              $backup = copy($file, base_path('storage/components/backups/controllers/admin/' . $rename_obj));
              unlink($file);

              $html = view('admincontrollertemplate', $pass);
              $core = $this->context->tools;
              $core->prepareHTML($html);
              $html = $core->buildHTML();
              $file = fopen(base_path('app/Http/Controllers/AdminControllers/' . $this->admin_controller), 'w');
              fwrite($file, '<?php' . PHP_EOL . $html);
              fclose($file);
            }
          }
        }

        //FrontController Process
        if (Input::get('controller') == 'both' || Input::get('controller') == 'front') {
          $this->front_controller = $this->object . 'Controller.php';
          if (!file_exists(base_path('app/Http/Controllers/FrontControllers/' . $this->front_controller))) {
            $html = view('frontcontrollertemplate', $pass);
            $core = $this->context->tools;
            $core->prepareHTML($html);
            $html = $core->buildHTML();
            $file = fopen(base_path('app/Http/Controllers/FrontControllers/' . $this->front_controller), 'w');
            fwrite($file, '<?php' . PHP_EOL . $html);
            fclose($file);
          }
        }
    }

    public function initProcessRouteFile()
    {
        if (!Input::get('slug')) {
          return true;
        }

        $this->initProcessRouteWeb();
        $this->initProcessRouteAdmin();
    }

    public function initProcessRouteAdmin()
    {
        if (Input::get('controller') != 'admin' && Input::get('controller') != 'both') {
          return true;
        }

        if (!file_exists(base_path('app/Http/Controllers/AdminControllers/' . $this->admin_controller))) {
          return json('error', 'Admin Controller file was not initiated');
        }

        $route = Input::get('slug');
        $add = [];
        $admin_controller = str_replace('.php', '', $this->admin_controller);
        $route_added = false;

        $route_file = file_get_contents(base_path('routes/admin.php'));
        if (strpos($route_file, "@$admin_controller routes@")) {
          return true;
        }

        $file = fopen(base_path('routes/admin.php'), 'r+'); //Open File
        $lines = file(base_path('routes/admin.php'), FILE_IGNORE_NEW_LINES); //Take line as array

        if (Input::get('is_admin_create')) {
          $add[] = "Route::get('$route/add', '$admin_controller@initContentCreate')->name('$this->variable.add');";
          $add[] = "Route::post('$route/add', '$admin_controller@initProcessCreate');";
          $add[] = "Route::get('$route/edit/{id}', '$admin_controller@initContentCreate')->name('$this->variable.edit');";
          $add[] = "Route::post('$route/edit/{id}', '$admin_controller@initProcessCreate');";
        }

        if (Input::get('is_admin_list')) {
          $add[] = "Route::get('$route', '$admin_controller@initListing')->name('$this->variable.list');";
        }

        if (Input::get('is_admin_delete')) {
          $add[] = "Route::get('$route/delete/{id}', '$admin_controller@initProcessDelete')->name('$this->variable.delete');";
        }

        $add_line = "\t\t\t\t// @$admin_controller routes@ Added from component controller\n";
        foreach ($add as $a) {
          $add_line .= formatLine2($a, 4);
        }

        if ($add_line && !$route_added) {
          foreach ($lines as $line => $text) {
            if (strpos($text, "middleware' => 'admin")) {
              $lines[$line + 1] = $add_line;
            }
          }
        }

        foreach ($lines as $line => $text) {
          fwrite($file, $text.PHP_EOL);
        }

        fclose($file);
    }

    public function initProcessRouteWeb()
    {
        if (Input::get('controller') != 'front' && Input::get('controller') != 'both') {
          return true;
        }

        if (!file_exists(base_path('app/Http/Controllers/FrontControllers/' . $this->front_controller))) {
          return json('error', 'Front Controller file was not initiated');
        }

        $route = Input::get('slug');
        $add = [];
        $front_controller = str_replace('.php', '', $this->front_controller);
        $route_file = file_get_contents(base_path('routes/web.php'));
        if (strpos($route_file, "@front $front_controller routes@")) {
          return true;
        }

        $file = fopen(base_path('routes/web.php'), 'r+'); //Open File
        $lines = file(base_path('routes/web.php'), FILE_IGNORE_NEW_LINES); //Take line as array

        if (Input::get('is_front_create')) {
          $add[] = "Route::get('$route/add', '$front_controller@initContentCreate');";
          $add[] = "Route::post('$route/add', '$front_controller@initProcessCreate');";
        }

        if (Input::get('is_front_list')) {
          $add[] = "Route::get('$route', '$front_controller@initListing');";
        }

        if (Input::get('is_front_view')) {
          $add[] = "Route::get('$route/{url}', '$front_controller@initContent');";
        }

        $add_line = "\t// @front $front_controller routes@ Added from component controller\n";
        foreach ($add as $a) {
          if (Input::get('is_login_needed')) {
            $add_line .= formatLine2($a, 1);
          } else {
            $add_line .= formatLine2($a, 0);
          }
        }

        if ($add_line) {
          foreach ($lines as $line => $text) {
            if (Input::get('is_login_needed') && strpos($text, "['middleware' => 'auth']")) {
              $lines[$line + 1] = $add_line;
            } elseif (!Input::get('is_login_needed') && strpos($text, 'Route Starts')) {
              $lines[$line + 2] = $add_line;
            }
          }
        }


        foreach ($lines as $line => $text) {
          fwrite($file, $text.PHP_EOL);
        }

        fclose($file);
    }

    public function initProcessViewFile()
    {
        $this->initProcessGenerateFrontViewFiles();
        $this->initProcessGenerateAdminViewFiles();
    }

    public function initProcessGenerateFrontViewFiles()
    {
        if (Input::get('controller') != 'front' && Input::get('controller') != 'both') {
          return true;
        }

        if (Input::get('is_front_create')) {
          $dir = base_path('resources/front/' . config('adlara.front_theme')) . '/templates/' . Input::get('variable');
          if (!file_exists($dir . '/create.blade.php')) {
            $html = file_get_contents(base_path('storage/components/templates/create-template-front.blade.php'));
            writeFile($dir, 'create.blade.php', $html);
          }
        }

        if (Input::get('is_front_list')) {
          $dir = base_path('resources/front/' . config('adlara.front_theme')) . '/templates/' . Input::get('variable');
          if (!file_exists($dir . '/list.blade.php')) {
            $html = file_get_contents(base_path('storage/components/templates/list-template-front.blade.php'));
            writeFile($dir, 'list.blade.php', $html);
          }
        }

        if (Input::get('is_front_view')) {
          $dir = base_path('resources/front/' . config('adlara.front_theme')) . '/templates/' . Input::get('variable');
          if (!file_exists($dir . '/view.blade.php')) {
            $html = file_get_contents(base_path('storage/components/templates/view-template-front.blade.php'));
            writeFile($dir, 'view.blade.php', $html);
          }
        }
    }

    public function initProcessGenerateAdminViewFiles()
    {
        if (Input::get('controller') != 'admin' && Input::get('controller') != 'both') {
          return true;
        }

        $c = $this->context->component->where('variable', Input::get('variable'))->first();

        $pass = [
          'fillable' => $c->fields
          ->where('is_fillable', 1)
          ->where('field_name', '!=', 'meta_title')
          ->where('field_name', '!=', 'meta_description')
          ->where('field_name', '!=', 'meta_keywords'),
          'component' => $c
        ];

        if (Input::get('is_admin_create')) {
          $dir = base_path('resources/admin/' . config('adlara.admin_theme')) . '/templates/' . Input::get('variable');
          $create_file = $dir . '/create.blade.php';
          if (Input::get('reset')) {
            $rename_obj = 'create.blade.php-' . date('Y-m-d H:i:s');
            $base_path = base_path('storage/components/backups/views/admin/' . Input::get('variable'));
            if (!file_exists($base_path)) {
              mkdir($base_path);
            }
            // if (file_exists($file)) {
            //   $backup = copy($file,  $base_path . '/' . $rename_obj);
            //   unlink($file);
            // }
          }

          $html = view('create-template-admin', $pass);
          $core = $this->context->tools;
          $core->prepareHTML($html);
          $html = $core->buildHTML();
          writeFile($dir, 'create.blade.php', $html);
        }


        if (Input::get('is_admin_list')) {
          $dir = base_path('resources/admin/' . config('adlara.admin_theme') . '/templates/' . Input::get('variable'));
          $list_file = $dir . '/' . 'list.blade.php';
          if (!file_exists($dir . '/list.blade.php') || Input::get('reset')) {
            if (Input::get('reset')) {
              $rename_obj = 'list.blade.php-' . date('Y-m-d H:i:s');
              $base_path = base_path('storage/components/backups/views/admin/' . Input::get('variable'));
              if (!file_exists($base_path)) {
                mkdir($base_path);
              }

              if (file_exists($list_file)) {
                $backup = copy($list_file,  $base_path . '/' . $rename_obj);
                unlink($list_file);
              }

              $file2 = $dir . '/_partials/' . 'list-only-' . Input::get('variable') . '.blade.php';
              $rename_obj2 = 'list-only-' . date('Y-m-d H:i:s');
              $base_path = base_path('storage/components/backups/views/admin/' . Input::get('variable'));
              if (!file_exists($base_path)) {
                mkdir($base_path);
              }
              if (file_exists($file2)) {
                $backup = copy($file2,  $base_path . '/' . $rename_obj2);
                unlink($file2);
              }
            }

            $pass = [
              'listable' => $c->fields->where('use_in_listing', 1),
              'variable' => Input::get('variable'),
              'component' => $c
            ];

            $html = writeHTML('list-template-admin', $pass);
            writeFile($dir, 'list.blade.php', $html);

            $html = writeHTML('list-only-template-admin', $pass);
            $dir = base_path('resources/admin/' . config('adlara.admin_theme') . '/templates/' . Input::get('variable') . '/_partials/');
            writeFile($dir, 'list-only-' . Input::get('variable') . '.blade.php', $html);
          }
        }
    }

    public function initListing()
    {
        $this->page['action_links'][] = [
          'text' => 'Add Component',
          'slug' => route('component.add'),
          'icon' => '<i class="material-icons">add_circle_outline</i>',
        ];

        $this->initProcessFilter();

        if ($this->filter) {
          $components = $this->context->component
          ->where($this->filter_search)
          ->orderBy('id', 'desc');
        } else {
          $components = $this->context->component
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($components->get());

        $this->assign = [
          'components' => $components->paginate(25)
        ];

        return $this->template('component.list');
    }

    public function initDeleting($id)
    {
        $this->context->component->find($id)->delete();
        $this->context->component_fields
        ->where('id_component', $id)
        ->delete();
    }

    /*
    * This Function is find the component field and get the data
    * and store in option and replace the data of component select
    */

    public function initProcessGetRealtionalComponentFields()
    {
        $html = [];
        $component = $this->context->component->find(Input::get('rel_comp_id'));
        $cp = Schema::getColumnListing($component->table);

        foreach ($cp as $key => $c) {
            $html[] = '<option value="'.$c.'">'.$c.' </option>';
        }

        return json('success', $html, [
          'component' => $component
        ]);
    }
}
