<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class CustomerController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = app()->context->component
        ->where(['variable' => 'customer'])
        ->first();
    }

    public function initListing(Request $request)
    {
        $this->page['title'] = 'Customer';
        if ($this->component->is_admin_create) {
          $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
            $customer = app()->context->customer
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
          } else {
          $customer = app()->context->customer
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($customer->get());
        $this->obj = $customer->paginate(25);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'customer',
          'obj' => $this->obj,
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = view('customer/_partials/list-only-customer', $data);
          $html = prepareHTML($html);
          return json('success', $html, true, prepareHTML($customer->paginate(25)->links()));
        }

        return $this->template('customer.list');
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

        $this->obj = app()->context->customer;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        if (!$id) {
          $this->page['title'] = 'Add Customer';
        } else {
          $this->page['title'] = 'Customer: ' . $this->obj->name;
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('customer.create');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = app()->context->customer;

        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $data = $this->obj;
                    $data->name = input('name');
              $data->email = input('email');
              $data->mobile = input('mobile');
              $data->password = input('password');
              
              $data->save();


  
          if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = app()->context->customer->find($id);
        if ($obj) {
          $obj->delete();
                              $this->flash('success', 'Customer with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('customer.list'));
    }
}
