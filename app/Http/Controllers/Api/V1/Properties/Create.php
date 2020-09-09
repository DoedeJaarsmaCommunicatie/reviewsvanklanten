<?php

namespace App\Http\Controllers\Api\V1\Properties;

use App\User;
use App\Models\Company;
use App\Models\Property;
use Illuminate\Support\Str;
use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PropertyResource;

class Create extends Controller
{
    use requestFetchers;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @param Request $request
     *
     * @return PropertyResource
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $property = new Property();
        $property->uuid = Str::uuid();
        $property->name = $this->getRequestValueOnKey($request, 'name');
        $property->description = $this->getRequestValueOnKey($request, 'description');
        if ($this->hasRequestKey($request, ['parent_id', 'parent_type'])) {
            $property->parent_type = $this->getParentTypeFromRequest($request);
            $property->parent_id = $this->getRequestValueOnKey($request, 'parent_id');
        }

        $property->save();

        return PropertyResource::make($property);
    }

    private function getParentTypeFromRequest(Request $request): string
    {
        switch($this->getRequestValueOnKey($request, 'parent_type')) {
            case 'PROPERTY':
            case 'property':
            case Property::class:
                return Property::class;
            case 'COMPANY':
            case 'Company':
            case 'company':
            case Company::class:
            default:
                return Company::class;
        }


    }
}
