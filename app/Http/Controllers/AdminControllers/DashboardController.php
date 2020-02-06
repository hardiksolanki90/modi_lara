<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
// use Analytics;
// use Spatie\Analytics\Period;

class DashboardController extends EmployeeController
{
    public function __construct()
    {
        parent::__construct();
        $this->page['title'] = 'Dashboard';
    }

    public function initContent()
    {
        $this->page = [
          'title' => 'Dashboard',
          'action_links' => []
        ];

        if (config('adlara.dashboard_analytics')) {
            $most_visited = Analytics::fetchMostVisitedPages(Period::days(30), 10);
            $top_browsers = Analytics::fetchTopBrowsers(Period::months(6), 5);
            $top_referrers = Analytics::fetchTopReferrers(Period::months(2), 5);
        } else {
            $most_visited = [];
            $top_browsers = [];
            $top_referrers = [];
        }

        // $this->page['panel'] = false;
        // $this->page['title'] = 'Dashboard';

        $this->assign = [
          'most_visited' => $most_visited,
          'top_browsers' => $top_browsers,
          'top_referrers' => $top_referrers
        ];

        return $this->template('dashboard.view');
    }
}