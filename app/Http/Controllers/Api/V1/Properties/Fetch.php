<?php

namespace App\Http\Controllers\Api\V1\Properties;

use App\Models\Property;
use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PropertyResource;

class Fetch extends Controller
{
    use requestFetchers;

    public function index(Request $request)
    {
        if ($this->hasRequestKey($request,$this->getUuidRequestKey())) {
            $property = Property::whereUuid($this->getRequestValueOnKey($request, $this->getUuidRequestKey()));

            if ($property->exists()) {
                return PropertyResource::collection($property->get());
            }

            return response()->json(
                [
                    'error' => 404,
                    'message' => 'Property with hash not found',
                    'data' => [
                        'hash' => $this->getRequestValueOnKey($request, $this->getUuidRequestKey()),
                    ]
                ],
                404
            );
        }

        if ($this->hasRequestKey($request, $this->getSearchRequestKey())) {
            $property = Property::where('name', 'LIKE', "%{$this->getRequestValueOnKey($request, $this->getSearchRequestKey())}%");

            if ($property->exists()) {
                return PropertyResource::collection($property->get());
            }

            return response()->json(
                [
                    'error' => 404,
                    'message' => 'No results for search query',
                    'data' => [
                        'query' => $this->getRequestValueOnKey($request, $this->getSearchRequestKey()),
                    ]
                ]
            );
        }

        return PropertyResource::collection(Property::all());
    }

    private function getUuidRequestKey(): string
    {
        return 'hash';
    }

    private function getSearchRequestKey(): string
    {
        return 'search';
    }
}
