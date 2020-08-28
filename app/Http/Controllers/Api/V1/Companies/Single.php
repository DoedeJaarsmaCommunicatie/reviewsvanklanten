<?php

namespace App\Http\Controllers\Api\V1\Companies;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Single extends Controller
{
    public function __invoke(Request $request, string $id)
    {
        try {
            return new CompanyResource(Company::findOrFail($id));
        } catch (ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 404,
                    'message' => 'No Company found with ID: ' . $id,
                ]
            );
        }
    }
}
