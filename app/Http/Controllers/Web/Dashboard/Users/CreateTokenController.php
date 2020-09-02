<?php

namespace App\Http\Controllers\Web\Dashboard\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $token = $request->user()->createToken($request->input('name', 'review-token'),
        [
            'review:commit',
            'review:fetch',
            'property:create',
            'property:fetch',
            'company:fetch',
        ])->plainTextToken;

        return back()->with('status', 'Code aangemaakt: ' . $token);
    }
}
