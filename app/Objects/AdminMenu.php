<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminMenu extends IDB
{
    use SoftDeletes;

    protected $table = 'admin_menu';

    public function menu_heading()
    {
        return $this->belongsTo('App\Objects\MenuHeading', 'id_head');
    }

    public function child()
    {
        return $this->hasMany('App\Objects\AdminMenuChild', 'id_menu');
    }
}
