<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends IDB
{
    use SoftDeletes;

    protected $table = 'email';

    public function component()
    {
        return $this->belongsTo('App\Objects\Component', 'id_component');
    }
}
