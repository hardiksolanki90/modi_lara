<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends IDB
{
    use SoftDeletes;

    protected $table = 'page';

    public function video()
    {
        return $this->belongsTo('App\Objects\Media', 'id_video');
    }

    public function image()
    {
        return $this->belongsTo('App\Objects\Media', 'id_image');
    }

    public function blocks()
    {
        return $this->hasMany('App\Objects\PageBlocks', 'id_page');
    }

    // public function preparedBlocks()
    // {

    //     if (!count($this->blocks)) {
    //       return array();
    //     }

    //     $blocks = $this->blocks()->orderBy('position', 'asc')->get();

    //     foreach ($blocks as $key => $block) {

    //       $blocks[$key]->image = getMedia($block->media);

    //     }

    //     return $blocks;

    // }

}
