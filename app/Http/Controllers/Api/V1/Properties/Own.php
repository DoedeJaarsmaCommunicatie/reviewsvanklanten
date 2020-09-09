<?php

namespace App\Http\Controllers\Api\V1\Properties;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PropertyResource;

class Own extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index() {
        if (!\Auth::user()) {
            return redirect(route('api.v1.properties.fetch'));
        }

        /** @var User $user */
        $user = \Auth::user();

        return PropertyResource::collection($user->properties()->get());
    }
}
