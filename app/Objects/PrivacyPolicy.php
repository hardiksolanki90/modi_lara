<?php
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacyPolicy extends IDB
{
    use SoftDeletes;

    protected $table = 'privacy_policy';

    public function key()
    {
        return $this->belongsTo('App\Objects\AdminMenuChild', 'id_key');
    }
}
