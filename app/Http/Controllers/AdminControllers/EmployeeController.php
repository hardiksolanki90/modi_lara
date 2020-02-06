<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Hash;
use Auth;

class EmployeeController extends AdminController
{
    use RedirectsUsers;

    public function initListing(Request $request)
    {
        $this->page['title'] = 'Employee List';
        $this->page['action_links'][] = [
          'text' => t('Add Employee'),
          'slug' => route('employee.register'),
          'icon' => '<i class="material-icons">add_circle_outline</i>'
        ];

        $this->initProcessFilter();

        if ($this->filter) {
            $admin_user = app()->context->admin_user
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
          } else {
          $admin_user = app()->context->admin_user
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($admin_user->get());
        $this->obj = $admin_user->paginate(25);

        $this->assign = [
          'variable' => 'admin_user',
          'obj' => $this->obj,
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = view('employee/_partials/list-only', $data);
          $html = prepareHTML($html);
          return json('success', $html, true, prepareHTML($admin_user->paginate(25)->links()));
        }

        return $this->template('employee.list');
    }

    public function initContentRegister($id = null)
    {
        $admin_menu = app()->context->admin_menu
        ->select('id', 'name', 'id_head', 'position', 'slug')
        ->get();

        $this->page['action_links'][] = [
          'text' => t('Employee list'),
          'slug' => route('employee.list'),
          'icon' => '<i class="material-icons">reply</i>'
        ];

        $this->obj = app()->context->admin_user;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        if (!$id) {
          $this->page['title'] = 'Add Employee';
        } else {
          $this->page['title'] = 'Employee: ' . $this->obj->name;
        }

        $selected_admin_menu = $this->obj->permission->pluck('id_admin_menu')->toArray();
        
        $this->assign = [
          'admin_menu' => $admin_menu,
          'obj' => $this->obj,
          'selected_admin_menu' => $selected_admin_menu,
        ];

        return $this->template('employee.register');
    }

    public function initProcessRegister(Request $request, $id = null)
    {
        $data = $request->all();
        if ($data['password'] != $data['password_confirmation']) {
            return json('error', 'Password and Confirm Passwords are not matching');
        }

        if (strlen($data['password']) < 6 && !$id) {
            return json('error', 'Too short password');
        }

        $admin_user = app()->context->admin_user;
        $getUser = $admin_user->where('email', $data['email'])->first();

        if ($getUser) {
          $admin_user = $getUser;
        }

        if ($getUser && !$id) {
            return json('error', 'Employee already exists');
        }

        $admin_user->name = $data['name'];
        $admin_user->email = $data['email'];
        $admin_user->password = Hash::make($data['password']);
        $admin_user->save();

        if (isset($data['permission']) && $data['permission']) {
          $this->initProcessSaveUserPermission($admin_user, $data['permission']);
        }

        if (!$id) {
            return json('redirect', route('employee.edit', $admin_user->id));
        }

        return json('success', t('Admin user updated'));
    }

    private function initProcessSaveUserPermission($admin_user, $permission)
    {
        if (count($permission)) {
        \App\Objects\AdminUserPermission::where('id_admin_user', $admin_user->id)->forceDelete();
          foreach ($permission as $key => $p) {
            $ps = new \App\Objects\AdminUserPermission;
            $ps->id_admin_user = $admin_user->id;
            $ps->id_admin_menu = $p;
            $ps->save();
          }
        }
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function create($data)
    {
    }

    public function validator($data)
    {
    }

    public function initProcessLogout()
    {
        Auth::guard('admin')->logout();
        $this->flash('success', 'Securely logged out');
        return redirect(route('challenge'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = app()->context->admin_user->find($id);
        if ($obj) {
          $admin_user_permission = app()->context->admin_user_permission
          ->where('id_admin_user', $obj->id)
          ->delete();
          $obj->delete();
          $this->flash('success', 'Admin User with name <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('employee.list'));
    }
}
