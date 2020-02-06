<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class EmailController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = app()->context->component
        ->where(['variable' => 'email'])
        ->first();
    }

    public function initListing(Request $request)
    {
        $this->page['title'] = 'Email';
        if ($this->component->is_admin_create) {
          $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
            $email = app()->context->email
                          ->leftJoin('component', 'component.id', '=', 'email.id_component')
                          ->select('email.*')
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
          } else {
          $email = app()->context->email
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($email->get());
        $this->obj = $email->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'email',
          'obj' => $this->obj,
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = view('email/_partials/list-only-email', $data);
          $html = prepareHTML($html);
          return json('success', $html, true, prepareHTML($email->paginate(25)->links()));
        }

        return $this->template('email.list');
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

        $this->obj = app()->context->email;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        if (!$id) {
          $this->page['title'] = 'Add Email';
        } else {
          $this->page['title'] = 'Email: ' . $this->obj->name;
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('email.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        
        $this->obj = app()->context->email;

        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $data = $this->obj;
        $data->subject = request()->input('subject');
        $data->content = request()->input('content');
        $data->sms = request()->input('sms');
        $data->identifier = request()->input('identifier');
        $data->id_component = request()->input('id_component');
        $data->save();

        if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = app()->context->email->find($id);
        if ($obj) {
          $obj->delete();
                              $this->flash('success', 'Email with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('email.list'));
    }
}
