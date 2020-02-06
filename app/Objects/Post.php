<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends IDB
{
    use SoftDeletes;

    protected $table = 'post';

    public function post_category()
    {
        return $this->belongsToMany('App\Objects\PostCategory', 'post_category_assigned', 'id_category', 'id_post');
    }

    public function media()
    {
        return $this->belongsTo('App\Objects\Media', 'id_media');
    }

    public function post_tags()
    {
        return $this->belongsToMany('App\Objects\PostTags', 'post_tags_assigned', 'id_tag', 'id_post');
    }
}
