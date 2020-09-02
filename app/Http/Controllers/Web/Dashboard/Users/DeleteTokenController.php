<?php

namespace App\Http\Controllers\Web\Dashboard\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->tokens()->where('id', $request->input('token_id'))->delete();

        return back()->with('status', 'Token ingetrokken');
    }
}
