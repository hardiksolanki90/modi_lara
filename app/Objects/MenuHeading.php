<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuHeading extends IDB
{
    use SoftDeletes;

    protected $table = 'admin_menu_heading';

    public function menu()
    {
        return $this->hasMany('App\Objects\AdminMenu', 'id_head');
    }
}
