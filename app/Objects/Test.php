<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends IDB
{
    use SoftDeletes;

    protected $table = 'test';
}
