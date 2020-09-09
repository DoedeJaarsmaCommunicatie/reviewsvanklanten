<?php

namespace App\Http\Controllers\Api\V1\Reviews\Property;

use App\Models\Review;
use App\Models\Property;
use Illuminate\Support\Str;
use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PropertyResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateReviewController extends Controller
{
    use requestFetchers;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $this->validateRequest($request);

        $review = new Review();
        $review->uuid = Str::uuid();
        if ($this->hasRequestKey($request, 'name')) {
            $review->name = $this->getRequestValueOnKey($request, 'name');
        }
        if ($this->hasRequestKey($request, 'remarks' )) {
            $review->remarks = $this->getRequestValueOnKey($request, 'remarks');
        }

        $review->email = $this->getRequestValueOnKey($request, 'email');
        $review->score = $this->getRequestValueOnKey($request, 'score');
        $review->reviewable_type = Property::class;
        try {
            $review->reviewable_id = Property::whereUuid($this->getRequestValueOnKey($request, 'property'))->firstOrFail()->id;
        } catch (ModelNotFoundException $exception) {
            return \Response::json(
                [
                    'error' => 404,
                    'message' => 'Company not found',
                    'data' => [
                        'property_hash' => $this->getRequestValueOnKey($request, 'company'),
                    ]
                ]
            );
        }

        if ($review->hasPassingGrade()) {
            $review->status = 'active';
        }

        $review->save();

        return PropertyResource::make(Property::whereUuid($this->getRequestValueOnKey($request, 'property'))->first());
    }

    private function validateRequest(Request $request)
    {
        $request->validate(
            [
                'property' => [
                    'uuid',
                    'exists:App\Models\Property,uuid',
                    'required'
                ],
                'score' => [
                    'numeric',
                    'required'
                ],
                'remarks' => [
                    'sometimes',
                    'nullable',
                ],
                'name' => [
                    'sometimes',
                    'nullable'
                ],
                'email' => [
                    'required',
                    'email',
                ]
            ]
        );
    }
}
