<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class StatesController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = app()->context->component
        ->where(['variable' => 'states'])
        ->first();
    }

    public function initListing(Request $request)
    {
        $this->page['title'] = 'States';
        if ($this->component->is_admin_create) {
          $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
            $states = app()->context->states
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
          } else {
          $states = app()->context->states
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($states->get());
        $this->obj = $states->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'states',
          'obj' => $this->obj,
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = view('states/_partials/list-only-states', $data);
          $html = prepareHTML($html);
          return json('success', $html, true, prepareHTML($states->paginate(25)->links()));
        }

        return $this->template('states.list');
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

        $this->obj = app()->context->states;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        if (!$id) {
          $this->page['title'] = 'Add States';
        } else {
          $this->page['title'] = 'States: ' . $this->obj->name;
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('states.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = app()->context->states;

        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $data = $this->obj;
                    $data->state_name = input('state_name');
              
              $data->save();


  
          if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = app()->context->states->find($id);
        if ($obj) {
          $obj->delete();
                              $this->flash('success', 'States with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('states.list'));
    }
}
