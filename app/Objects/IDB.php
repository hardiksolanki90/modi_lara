<?php

namespace App\Objects;

use Illuminate\Database\Eloquent\Model;

class IDB extends Model
{
    protected $guarded = [''];

    public function check($key, $val)
    {
        $data = $this->where($key, $val);
        if (isset($data->id) && $data->id) {
          return true;
        }

        return false;
    }

    public function findByURL($url)
    {
        $this->primaryKey = 'url';
        return $this->find($url);
    }
}
