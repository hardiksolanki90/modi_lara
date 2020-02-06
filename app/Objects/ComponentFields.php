<?php

namespace App\Objects;

use App\Objects\IDB;

class ComponentFields extends IDB
{
    protected $table = 'component_fields';

    public function component()
    {
        return $this->belongsTo('App\Objects\Component', 'relational_component_name');
    }

    public function core_component()
    {
        return $this->belongsTo('App\Objects\Component', 'id_component');
    }
}
