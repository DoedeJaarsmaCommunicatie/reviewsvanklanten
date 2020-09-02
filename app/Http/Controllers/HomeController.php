<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @var User $user Authentication forced via middleware.
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\Response
     */
    public function index()
    {
        $this->user = Auth::user();

        return \Response::view(
            'home',
        [
            'user' => $this->user,
            'subscription_type' => $this->user->subscription(),
            'companies' => $this->user->companies
        ]);
    }
}
