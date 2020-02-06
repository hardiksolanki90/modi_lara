<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use DB;
use View;

class AdminController extends Controller
{
    protected $page = [
      'action_links' => []
    ];

    protected $filter;

    protected $component;

    protected $obj;

    public function __construct()
    {
        $this->page['title'] = 'ModiLara Admin';
        // parent::__construct();
    }

    public function template($view)
    {
        $this->default_assigned_variables();
        $data = array_merge($this->assign, $this->assign_default);
        return view($view, $data);
    }

    private function default_assigned_variables()
    {
        $this->getCSS();
        $this->getJS();
        $this->assign_default = [
          'form' => app()->context->form,
          'css_files' => $this->css_files,
          'js_files' => $this->js_files,
          'page' => $this->page,
          'component' => $this->component,
          'obj' => $this->obj,
          'sidebar_menu' => $this->getAdminMenu()
        ];
    }

    protected function addCSS($css)
    {
        $this->css_files[] = $css;
    }

    protected function addJS($js)
    {
        $this->js_files[] = $js;
    }

    protected function getCSS()
    {
        $this->addCSS(theme('css/app.css'));
        $this->addCSS(theme('css/selectize.css',true));
        $this->addCSS(theme('css/selectize.default.css',true));
        $this->addCSS(theme('css/selectize.legacy.css',true));
        $this->addCSS(theme('css/tagsinput.css',true));
        $this->addCSS(theme('css/media.css',true));
        $this->addCSS('//fonts.googleapis.com/icon?family=Material+Icons');
        $this->addCSS('//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.min.css');
        $this->addCSS('//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css');
        $this->addCSS('//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css');
    }

    protected function getJS()
    {
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js');
        $this->addJS(theme('js/app.js'));
        $this->addJS('//cdn.jsdelivr.net/npm/sweetalert2');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js');
        $this->addJS(theme('js/selectize.js', true));
        $this->addJS(theme('js/tagsinput.min.js', true));
        $this->addJS(theme('js/rating.js', true));
        $this->addJS(theme('js/media-upload.js', true));
        $this->addJS(theme('js/media.js', true));
        $this->addJS(theme('js/custom.js'));
    }

    protected function setActionLink($text, $slug, $icon)
    {
        return $this->page['action_links'][] = [
          'text' => $text,
          'slug' => $slug,
          'icon' => $icon
        ];
    }

    protected function flash($status, $message)
    {
        $message = $this->modifyFlash($status, $message);
        $msg[] = [
          'status' => $status,
          'message' => $message
        ];
        if (session()->has('admin_flash')) {
            $msg = [];
            foreach (session('admin_flash') as $flash) {
                $msg[] = [
                  'status' => $flash['status'],
                  'message' => $flash['message'],
                ];
            }
            $msg[] = [
              'status' => $status,
              'message' => $message
            ];
        }
        session()->flash('admin_flash', $msg);
    }

    private function modifyFlash($status, $message)
    {
        if ($status == 'warning' || $status == 'danger') {
          $message = '<i class="ion-android-warning"></i> ' . $message;
        }
        if ($status == 'success') {
          $message = '<i class="ion-ios-checkmark"></i> ' . $message;
        }
        if ($status == 'info') {
          $message = '<i class="ion-ios-information"></i> ' . $message;
        }

        return $message;
    }

    protected function getAdminMenu()
    {
        $headings = app()->context->menu_heading
        ->orderBy('position', 'asc')
        ->get();
        
        return $headings;
    }

    
}