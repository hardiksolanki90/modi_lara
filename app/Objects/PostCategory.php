<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends IDB
{
    use SoftDeletes;

    protected $table = 'post_category';
}
