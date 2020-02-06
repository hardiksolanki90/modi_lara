<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends IDB
{
    use SoftDeletes;
    
    protected $table = 'media';

}
