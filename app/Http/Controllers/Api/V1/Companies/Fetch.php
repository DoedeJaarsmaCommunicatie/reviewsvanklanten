<?php

namespace App\Http\Controllers\Api\V1\Companies;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;

class Fetch extends Controller
{
    public function __invoke()
    {
        return CompanyResource::collection(Company::all());
    }
}
