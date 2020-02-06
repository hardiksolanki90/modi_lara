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

    public function initContentRegister()
    {
        return $this->template('employee.register');
    }

    public function initProcessRegister(Request $request)
    {
        $data = $request->all();
        if ($data['password'] != $data['password_confirmation']) {
            $this->flash('error', 'Password and Confirm Passwords are not matching');
            return redirect(url()->previous());
        }

        if (strlen($data['password']) < 6) {
            $this->flash('error', 'Too short password');
            return redirect(url()->previous());
        }

        $admin_user = app()->context->admin_user;

        if (count($admin_user->where('email', $data['email'])->first())) {
            $this->flash('error', 'Employee already exists');
            return redirect(url()->previous());
        }

        $admin_user->name = $data['name'];
        $admin_user->email = $data['email'];
        $admin_user->password = Hash::make($data['password']);
        $admin_user->save();
        $this->flash('success', 'Admin user created successfully');
        return redirect(url()->previous());
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function initProcessLogout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('adminroute'))->with('success', 'Logout successfully!');
    }
}
