<?php

namespace App\Http\Controllers\Api\V1\Companies;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Create extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();


    }
}
