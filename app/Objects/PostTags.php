<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTags extends IDB
{
    use SoftDeletes;

    protected $table = 'post_tags';
}
