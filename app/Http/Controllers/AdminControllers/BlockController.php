<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Input;
use Illuminate\Http\Request;

class BlockController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = app()->context->component
        ->where(['variable' => 'block'])
        ->first();
    }

    public function initListing(Request $request)
    {
        if ($this->component->is_admin_create) {
          $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>',
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
          $block = app()->context->block
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
        } else {
          $block = app()->context->block
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($block->get());
        $this->obj = $block->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'block'
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = getAdminTemplate('block/_partials/list-only-block', $data, true);
          return json('success', $html, true, prepareHTML($block->paginate(25)->links()));
        }

        return $this->template('block.list');
    }

    public function initContentCreate($id = null)
    {
        $this->addJS(theme('js/slider.js', true));
        $this->addCSS(theme('js/front.js', true));
        $this->addCSS(theme('css/slider.css', true));
        $this->addCSS(theme('css/front.css', true));
        if ($this->component->is_admin_list) {
          $this->page['action_links'][] = [
            'text' => t($this->component->name),
            'slug' => route($this->component->variable . '.list'),
            'icon' => '<i class="material-icons">list</i>',
          ];
        }

        if ($this->component->is_admin_create && $id) {
          $this->page['action_links'][] = [
            'text' => t('Add'),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>',
          ];
        }

        $this->obj = app()->context->block;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('block.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = app()->context->block;

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

        if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = app()->context->block->find($id);
        if ($obj) {
          $obj->delete();
          $this->flash('success', 'Client Success with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('block.list'));
    }
}
