<?php

namespace App\Objects;

use App\Objects\IDB;

class Component extends IDB
{
    protected $table = 'component';

    public function fields()
    {
        return $this->hasMany('App\Objects\ComponentFields', 'id_component');
    }
    
}
