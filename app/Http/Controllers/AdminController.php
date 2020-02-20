<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
          'admin_user_permission' => app()->context->admin_user->getAdminUser()->permission->pluck('id_admin_menu')->toArray(),
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
        
        $this->addCSS(theme('css/OverlayScrollbars.css'));
        $this->addCSS(theme('css/app.css'));
        $this->addCSS(theme('css/selectize.css',true));
        $this->addCSS(theme('css/selectize.default.css',true));
        $this->addCSS(theme('css/selectize.legacy.css',true));
        $this->addCSS(theme('css/tagsinput.css',true));
        $this->addCSS(theme('css/media.css',true));
        $this->addCSS('//cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css');
        $this->addCSS('//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.min.css');
        $this->addCSS('//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css');
        $this->addCSS('//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css');
    }

    protected function getJS()
    {
        $this->addJS('//code.jquery.com/jquery-3.4.1.min.js');
        $this->addJS(theme('js/bootstrap.bundle.min.js'));
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.10.3/js/OverlayScrollbars.min.js');
        $this->addJS(theme('js/app.js'));
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js');
        $this->addJS('//cdn.jsdelivr.net/npm/sweetalert2');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js');
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

    protected function initProcessFilter()
    {
        $filters = request()->input();
        $search = [];
        $date_search = [];
        $skip_filters = ['page', 'generatePDF', 'report'];
        $search_date_available = false;
        $search_date_type = false;
        $search_date_start = false;
        $search_date_end = false;
        $filter_keys = array_keys($filters);
        $date = false;
        // pre($filter_keys);
        foreach ($filter_keys as $key) {
            if (strpos($key, '--start')) {
                $search_date_available = true;
                $search_date_start = true;
            }
            if (strpos($key, '--end')) {
                $search_date_available = true;
                $search_date_end = true;
            }
        }

        if (count($filters)) {
            foreach ($filters as $filter => $value) {
                if (!$value) {
                    continue;
                }
                if (!in_array($filter, $skip_filters)) {
                    if (strpos($filter, '--start')) {
                        $search_date_type = 'start';
                        $date = true;
                        $filter = str_before($filter, '--');
                    }

                    if (strpos($filter, '--end')) {
                        $search_date_type = 'end';
                        $date = true;
                        $filter = str_before($filter, '--');
                    }

                    $filter = str_replace('_', '.', $filter);
                    $filter = str_replace('-', '_', $filter);

                    if (in_array($filter, $skip_filters)) {
                        continue;
                    }

                    if ($search_date_type && $date) {
                        if ($search_date_end && $search_date_start) {
                            if ($search_date_end == 'start') {
                                $exp = '>=';
                            }

                            if ($search_date_type == 'end') {
                                $exp = '<=';
                            }
                            $row = DB::raw('DATE('.$filter.')');
                            $this->filter_search[] = [$row, $exp, date('Y-m-d', strtotime($value))];
                            $date = false;
                        } else {
                            $row = DB::raw('DATE('.$filter.')');
                            $this->filter_search[] = [$row, '=', date('Y-m-d', strtotime($value))];
                        }
                        $this->filter = true;
                    } else {
                        $this->filter = true;
                        $this->filter_search[] = [$filter, 'LIKE', '%' . $value . '%'];
                    }
                }
            }
        }
    }

    
}