<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminMenuChild extends IDB
{
    use SoftDeletes;
    
    protected $table = 'admin_menu_child';

    public function admin_menu()
    {
        return $this->belongsTo('App\Objects\AdminMenu', 'id_menu');
    }


}
