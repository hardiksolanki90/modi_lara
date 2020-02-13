<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class States extends IDB
{
    use SoftDeletes;

    protected $table = 'states';
}
