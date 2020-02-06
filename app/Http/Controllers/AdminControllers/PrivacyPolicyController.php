<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Input;
use Illuminate\Http\Request;

class PrivacyPolicyController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = app()->context->component
        ->where(['variable' => 'privacy_policy'])
        ->first();
    }

    public function initListing(Request $request)
    {
        $this->page['title'] = 'Privacy Policy';
        if ($this->component->is_admin_create) {
          $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
            $privacy_policy = app()->context->privacy_policy
                          ->leftJoin('admin_menu_child', 'admin_menu_child.id', '=', 'privacy_policy.id_key')
                          ->select('privacy_policy.*')
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
          } else {
          $privacy_policy = app()->context->privacy_policy
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($privacy_policy->get());
        $this->obj = $privacy_policy->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'privacy_policy',
          'obj' => $this->obj,
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = view('privacy_policy/_partials/list-only-privacy_policy', $data);
          $html = prepareHTML($html);
          return json('success', $html, true, prepareHTML($privacy_policy->paginate(25)->links()));
        }

        return $this->template('privacy_policy.list');
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

        $this->obj = app()->context->privacy_policy;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        if (!$id) {
          $this->page['title'] = 'Add Privacy Policy';
        } else {
          $this->page['title'] = 'Privacy Policy: ' . $this->obj->name;
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('privacy_policy.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = app()->context->privacy_policy;

        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $data = $this->obj;
                    $data->name = Input::get('name');
              $data->identifier = Input::get('identifier');
              $data->content = Input::get('content');
              $data->meta_title = Input::get('meta_title');
              $data->meta_description = Input::get('meta_description');
              $data->meta_keywords = Input::get('meta_keywords');
              
                    $data->id_key = Input::get('id_key');
                  $data->save();


  
          if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = app()->context->privacy_policy->find($id);
        if ($obj) {
          $obj->delete();
                              $this->flash('success', 'Privacy Policy with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('privacy_policy.list'));
    }
}
