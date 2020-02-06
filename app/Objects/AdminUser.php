<?php

namespace App\Objects;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany('App\Objects\Post', 'id_author');
    }

    public function getAdminUser($id = null)
    {
        if ($id) {
            return $this->find($id);
        }

        if (Auth::guard('admin')->check()) {
          return Auth::guard('admin')->user();
        }

        return $this;
    }

    public function permission()
    {
        return $this->hasMany('App\Objects\AdminUserPermission', 'id_admin_user');
    }
}
