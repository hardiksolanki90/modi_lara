<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class AdminMenuController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = $this->context->component
        ->where(['variable' => 'admin_menu'])
        ->first();
    }

    public function initListing(Request $request)
    {
        $this->page['title'] = 'Admin Menu';
        if ($this->component->is_admin_create) {
            $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
            $admin_menu = $this->context->admin_menu
                          ->leftJoin('admin_menu_heading', 'admin_menu_heading.id', '=', 'admin_menu.id_head')
                          ->select('admin_menu.*')
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
        } else {
            $admin_menu = $this->context->admin_menu
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($admin_menu->get());
        $this->obj = $admin_menu->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'admin_menu',
          'obj' => $this->obj,
        ];

        if ($request->ajax()) {
            $data = $this->assign;
            $html = view('admin_menu/_partials/list-only-admin_menu', $data);
            $html = prepareHTML($html);
            return json('success', $html, true, prepareHTML($admin_menu->paginate(25)->links()));
        }

        return $this->template('admin_menu.list');
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
            $this->page['action_links'][] = [
            'text' => t('Add Child'),
            'slug' => route('admin_menu_child.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->obj = $this->context->admin_menu;
        if ($id) {
            $this->obj = $this->obj->find($id);
        }

        if (!$id) {
            $this->page['title'] = 'Add Admin Menu';
        } else {
            $this->page['title'] = 'Admin Menu: ' . $this->obj->name;
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('admin_menu.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = $this->context->admin_menu;

        if ($id) {
            $this->obj = $this->obj->find($id);
        }
        $data = $this->obj;
        $data->name = request()->input('name');
        $data->slug = request()->input('slug');
        $data->position = request()->input('position');
        $data->id_head = request()->input('id_head');
        $data->save();

        if (!$id) {
            return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = $this->context->admin_menu->find($id);
        if ($obj) {
            $obj->delete();
            $this->flash('success', 'Admin Menu with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('admin_menu.list'));
    }
}
