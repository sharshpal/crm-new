<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Utils\Inspiring;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display default admin home page
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('dashboard.index', [
            'inspiration' => Inspiring::quote(env("INSPIRE_QUOTE_SET",0))
        ]);
    }
}
