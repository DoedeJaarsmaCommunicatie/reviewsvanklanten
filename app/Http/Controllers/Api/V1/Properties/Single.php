<?php

namespace App\Http\Controllers\Api\V1\Properties;

use App\Models\Property;
use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PropertyResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Single extends Controller
{
    use requestFetchers;

    public function index(Request $request, string $id)
    {
        $type = $this->getRequestValueOnKey($request, 'type');

        try {
            switch ($type) {
                case 'uuid':
                case 'hash':
                    return PropertyResource::make(Property::whereUuid($id)->firstOrFail());
                case 'id':
                case '':
                default:
                    return PropertyResource::make(Property::whereId($id)->firstOrFail());
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 404,
                    'message' => sprintf(
                        'No Property found with %s: %s',
                        $type === 'uuid' ? 'uuid' : 'id',
                        $id
                    )
                ]
            );
        }
    }
}
