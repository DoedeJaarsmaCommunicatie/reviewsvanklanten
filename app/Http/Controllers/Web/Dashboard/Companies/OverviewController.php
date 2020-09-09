<?php

namespace App\Http\Controllers\Web\Dashboard\Companies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return \View::make('pages.dashboard.companies.overview')
            ->with(
                [
                    'user' => $request->user(),
                ]
            );
    }
}
