<?php

namespace App\Objects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageBlocks extends Model
{
    use SoftDeletes;

    protected $table = 'page_blocks';

    public function media()
    {
        return $this->belongsTo('App\Objects\Media', 'id_image');
    }
}
