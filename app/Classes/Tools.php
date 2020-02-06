<?php

namespace App\Classes;

class Tools
{
    public $html;

    public function prepareHTML($html)
    {
        $this->html[] = $html;
    }

    public function buildHTML()
    {
        $html = '';
        foreach ($this->html as $h) {
          $html .= $h;
        }

        return $html;
    }
}
