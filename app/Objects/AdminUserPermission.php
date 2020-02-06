<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUserPermission extends IDB
{
    use SoftDeletes;

    protected $table = 'admin_user_permission';

    public function menu_heading()
    {
        return $this->belongsTo('App\Objects\MenuHeading', 'id_head', 'id')->orderBy('position', 'asc');
    }

    public function child()
    {
        return $this->hasMany('App\Objects\AdminMenuChild', 'id_menu', 'id');
    }
}
