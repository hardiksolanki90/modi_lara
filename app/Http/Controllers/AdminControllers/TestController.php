<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Input;
use Illuminate\Http\Request;

class TestController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = app()->context->component
        ->where(['variable' => 'test'])
        ->first();
    }

    public function initListing(Request $request)
    {
        $this->page['title'] = 'Test';
        if ($this->component->is_admin_create) {
          $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
            $test = app()->context->test
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
          } else {
          $test = app()->context->test
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($test->get());
        $this->obj = $test->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'test',
          'obj' => $this->obj,
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = view('test/_partials/list-only-test', $data);
          $html = prepareHTML($html);
          return json('success', $html, true, prepareHTML($test->paginate(25)->links()));
        }

        return $this->template('test.list');
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

        $this->obj = app()->context->test;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        if (!$id) {
          $this->page['title'] = 'Add Test';
        } else {
          $this->page['title'] = 'Test: ' . $this->obj->name;
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('test.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = app()->context->test;

        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $data = $this->obj;
                    $data->test = Input::get('test');
              $data->textarea = Input::get('textarea');
              $data->meta_title = Input::get('meta_title');
              $data->meta_description = Input::get('meta_description');
              $data->meta_keywords = Input::get('meta_keywords');
              $data->meta_title = Input::get('meta_title');
              $data->meta_description = Input::get('meta_description');
              $data->meta_keywords = Input::get('meta_keywords');
              $data->meta_title = Input::get('meta_title');
              $data->meta_description = Input::get('meta_description');
              $data->meta_keywords = Input::get('meta_keywords');
              $data->meta_title = Input::get('meta_title');
              $data->meta_description = Input::get('meta_description');
              $data->meta_keywords = Input::get('meta_keywords');
              $data->meta_title = Input::get('meta_title');
              $data->meta_description = Input::get('meta_description');
              $data->meta_keywords = Input::get('meta_keywords');
              $data->meta_title = Input::get('meta_title');
              $data->meta_description = Input::get('meta_description');
              $data->meta_keywords = Input::get('meta_keywords');
              $data->meta_title = Input::get('meta_title');
              $data->meta_description = Input::get('meta_description');
              $data->meta_keywords = Input::get('meta_keywords');
              $data->meta_title = Input::get('meta_title');
              $data->meta_description = Input::get('meta_description');
              $data->meta_keywords = Input::get('meta_keywords');
              
              $data->save();


  
          if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = app()->context->test->find($id);
        if ($obj) {
          $obj->delete();
                              $this->flash('success', 'Test with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('test.list'));
    }
}
