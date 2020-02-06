<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\AdminLogin;

class AdminAuthController extends AdminController
{
    private $request;

    use AuthenticatesUsers;

    protected $redirectTo = '/welcome';

    public $maxAttempts = 3;

    protected $maxLoginAttempts = 5; // Amount of bad attempts user can make

    protected $lockoutTime = 300;

    public function __construct()
    {
        if (Auth::guard('admin')->check()) {
            return array (
                'status' => 'redirect',
                'message' => route('admin.dashboard')
            );
        }
        else {
            return array (
                'status' => 'redirect',
                'message' => route('adminroute')
            );
        }
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function initContent()
    {
        return $this->template('auth.login');
    }

    public function initProcessLogin(AdminLogin $request)
    {
        $validated = $request->validated();

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts(request())) {
            $this->fireLockoutEvent(request());

            return $this->sendLockoutResponse(request());
        }

        $credentials = array(
            'email' => input('email'),
            'password' => input('password')
        );

        $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );

        if ($this->guard()->attempt($credentials)) {
            return redirect(route('admin.dashboard'));
        }

        $this->incrementLoginAttempts(request());

        return $this->sendFailedLoginResponse(request());
    }


}
