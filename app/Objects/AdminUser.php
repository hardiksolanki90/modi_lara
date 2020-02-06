<?php
namespace App\Objects;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Authenticatable
{
    use SoftDeletes;

    protected $hidden = [
      'password',
      'remember_token'
    ];

    protected $table = 'admin_users';
}
