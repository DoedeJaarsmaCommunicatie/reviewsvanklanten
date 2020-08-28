<?php

namespace App\Http\Controllers\Api\V1\Companies;

use App\Models\Company;
use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Single extends Controller
{
    use requestFetchers;

    public function __invoke(Request $request, string $id)
    {
        $type = $this->getRequestValueOnKey($request, 'type');

        try {
            switch ($type) {
                case 'uuid':
                case 'hash':
                    return new CompanyResource(Company::whereUuid($id)->firstOrFail());
                case 'id':
                case '':
                default:
                    return new CompanyResource(Company::whereId($id)->firstOrFail());
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error'   => 404,
                    'message' => sprintf(
                        'No Company found with %s: %s',
                        $type === 'uuid' ? 'uuid' : 'id',
                        $id
                    ),
                ]
            );
        }
    }
}
