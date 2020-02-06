<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class AdminMenuChildController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = $this->context->component
        ->where(['variable' => 'admin_menu_child'])
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
          $admin_menu_child = $this->context->admin_menu_child
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
        } else {
          $admin_menu_child = $this->context->admin_menu_child
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($admin_menu_child->get());
        $this->obj = $admin_menu_child->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'admin_menu_child'
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = getAdminTemplate('admin_menu_child/_partials/list-only-admin_menu_child', $data, true);
          return json('success', $html, true, prepareHTML($admin_menu_child->paginate(25)->links()));
        }

        return $this->template('admin_menu_child.list');
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

        $this->obj = $this->context->admin_menu_child;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('admin_menu_child.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = $this->context->admin_menu_child;

        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $data = $this->obj;
                    $data->name = request()->input('name');
              $data->slug = request()->input('slug');
                $data->id_menu = request()->input('id_menu');
                  $data->save();


          if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = $this->context->admin_menu_child->find($id);
        if ($obj) {
          $obj->delete();
                              $this->flash('success', 'Admin Child Menu with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('admin_menu_child.list'));
    }
}
