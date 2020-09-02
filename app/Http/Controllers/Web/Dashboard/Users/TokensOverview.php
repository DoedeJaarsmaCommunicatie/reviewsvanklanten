<?php

namespace App\Http\Controllers\Web\Dashboard\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokensOverview extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return \View::make('pages.dashboard.user.tokens')
            ->with(
                [
                    'user' => \Auth::user(),
                ]
            );
    }
}
