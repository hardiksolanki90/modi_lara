<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends IDB
{
    use SoftDeletes;

    protected $table = 'customer';
}
