<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $assign = array();

    protected $assign_default = array();

    protected $context;

    protected $css_files = [];

    protected $js_files = [];

    protected function validateFields(array $datas = array())
    {
        $fields = [];
        if (!count($datas) && request()->input('required')) {
          if (!is_array(request()->input('required'))) {
            $required = explode(',', request()->input('required'));
            $required_label = explode(',', request()->input('required_label'));
          } else {
            $required = request()->input('required');
            $required_label = request()->input('required');
          }

          foreach ($required as $key => $req) {
            $datas[$req] = $required_label[$key];
          }
        }

        foreach ($datas as $d => $data) {
            if (!request()->input($d) && !isset($_FILES[$d])) {
                return json('error', 'Please supply ' . $data, true, request()->input('element'));
            } else {
                $da = str_replace('-', '_', $d);
                $fields[$da] = request()->input($d);
            }
        }

        return (object) $fields;
    }
    
}
