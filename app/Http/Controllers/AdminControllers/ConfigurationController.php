<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Objects\Configuration;
use DB;

class ConfigurationController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->page['title'] = 'Configuration';
    }

    public function initContentCreate()
    {
        $this->page['action_links'][] = [
          'text' => 'Flush Cache',
          'slug' => AdminURL('flush/cache'),
          'icon' => '<i class="material-icons">&#xE92B;</i>'
        ];

        $this->page['action_links'][] = [
          'text' => 'Reset Assets',
          'slug' => route('reset.assets'),
          'icon' => '<i class="material-icons">&#xE8B3;</i>'
        ];

        $configuration = $this->context->configuration;

        $ADMIN_EMAIL = $configuration->where('name', '=', 'ADMIN_EMAIL')->pluck('value')->first();
        $SITE_URL = $configuration->where('name', '=', 'SITE_URL')->pluck('value')->first();
        $SSL = (array) $configuration->where('name', '=', 'SSL')->pluck('value')->first();
        $CACHE = (array) $configuration->where('name', '=', 'CACHE')->pluck('value')->first();
        $MAINTENANCE = (array) $configuration->where('name', '=', 'MAINTENANCE')->pluck('value')->first();
        $DEBUG_MODE = (array) $configuration->where('name', '=', 'DEBUG_MODE')->pluck('value')->first();
        $JS_MINIFICATION = (array) $configuration->where('name', '=', 'JS_MINIFICATION')->pluck('value')->first();
        $CSS_MINIFICATION = (array) $configuration->where('name', '=', 'CSS_MINIFICATION')->pluck('value')->first();

        $last_SSL = end($SSL);
        $last_CACHE = end($CACHE);
        $last_MAINTENANCE = end($MAINTENANCE);
        $last_DEBUG_MODE = end($DEBUG_MODE);
        $last_CSS_MINIFICATION = end($CSS_MINIFICATION);
        $last_JS_MINIFICATION = end($JS_MINIFICATION);

      $this->assign = [
        'ADMIN_EMAIL' => $ADMIN_EMAIL,
        'SITE_URL' => $SITE_URL,
        'SSL' => $last_SSL,
        'CACHE' => $last_CACHE,
        'MAINTENANCE' => $last_MAINTENANCE,
        'DEBUG_MODE' => $last_DEBUG_MODE,
        'CSS_MINIFICATION' => $last_CSS_MINIFICATION,
        'JS_MINIFICATION' => $last_JS_MINIFICATION,
      ];

      return $this->template('configuration.create');
    }

    public function initProcessCreate(Request $req)
    {
        $data = $req->all();
        foreach ($data as $key => $d) {
          $configuration = new \App\Objects\Configuration;
          $ch = $configuration->where('name', $key)->first();
          if ($ch) {
            $ch->value = $d;
          } else {
            $ch = $configuration;
            $ch->name = $key;
            $ch->value = $d;
          }
          $ch->save();
        }
        return json('success', 'Settings updated');
    }

    public function initClearCache()
    {
        pre('here');
        Cache::flush();
        // $this->flash('success', 'Cache Clear');
        // return json('redirect', AdminURL('configuration'));
        return jsonResponse('success', 'Cache Clear');
    }

    public function initProcessResetAssets()
    {
        unlink(base_path('/themes/front/' . config('adlara.front_theme') . '/assets/compiled/app.css'));
        unlink(base_path('/themes/front/' . config('adlara.front_theme') . '/assets/compiled/app.js'));
        $this->flash('success', 'Static files trashed');
        return redirect(route('configuration'));
    }
}
