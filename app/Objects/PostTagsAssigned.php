<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTagsAssigned extends IDB
{
    use SoftDeletes;

    protected $table = 'post_tags_assigned';

    public function post()
    {
        return $this->belongsTo('App\Objects\Post', 'id_post');
    }

    public function tag()
    {
        return $this->belongsTo('App\Objects\PostTags', 'id_tag');
    }
}
