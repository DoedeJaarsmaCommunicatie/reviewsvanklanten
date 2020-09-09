<?php

namespace App\Http\Controllers\Web\Dashboard\Companies;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SingleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, string $id)
    {
        $company = Company::whereUuid($id)->firstOrFail();

        return \View::make('pages.dashboard.companies.single')
            ->with(
                [
                    'company' => $company,
                    'user' => \Auth::user(),
                ]
            );
    }
}
