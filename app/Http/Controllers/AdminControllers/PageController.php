<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Input;
use Illuminate\Http\Request;

class PageController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = app()->context->component
        ->where(['variable' => 'page'])
        ->first();
    }

    public function initListing(Request $request)
    {
        if ($this->component->is_admin_create) {
          $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
          $page = app()->context->page
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
        } else {
          $page = app()->context->page
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($page->get());
        $this->obj = $page->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'page'
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = getAdminTemplate('page/_partials/list-only-page', $data, true);
          return json('success', $html, true, prepareHTML($page->paginate(25)->links()));
        }

        return $this->template('page.list');
    }

    public function initContentCreate($id = null)
    {
        if ($this->component->is_admin_list) {
          $this->page['action_links'][] = [
            'text' => t($this->component->name),
            'slug' => AdminURL($this->component->slug),
            'icon' => '<i class="ion-ios-list-outline"></i>'
          ];
        }

        if ($this->component->is_admin_create && $id) {
          $this->page['action_links'][] = [
            'text' => t('Add'),
            'slug' => AdminURL($this->component->slug . '/add'),
            'icon' => '<i class="ion-ios-plus-outline"></i>'
          ];
        }

        $this->obj = app()->context->page;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('page.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = app()->context->page;

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
          $fill[makeColumn($field->field_name)] = input($field->field_name);
        }

        $data = $this->obj->fill($fill);
        $data->save();

        if ($this->component->is_meta_needed) {
          $data->meta_title = input('meta_title');
          $data->meta_description = input('meta_description');
          $data->meta_keywords = input('meta_keywords');
          $data->save();
        }

        if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessChangeStatus($component = null, $column = null, $id = null, $status = null)
    {
        $c = app()->context->$component->find($id);

        $c->$column = $status;
        $c->save();

        $component = str_replace('_', ' ', $component);

        return json('success', ucfirst($component) . ' updated');
    }
}
