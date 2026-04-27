<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Mission;
use App\Models\OfferRequest;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                'clients' => Client::count(),
                'offers' => OfferRequest::count(),
                'missions' => Mission::count(),
            ],
        ]);
    }
}
