<?php

namespace App\Http\Controllers\Api\V1\Companies;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;

class Own extends Controller
{
    public function __invoke()
    {
        if (!\Auth::user()) {
            return redirect(route('api.v1.companies.fetch'));
        }

        /** @var User $user */
        $user = \Auth::user();

        return CompanyResource::collection($user->companies);
    }
}
