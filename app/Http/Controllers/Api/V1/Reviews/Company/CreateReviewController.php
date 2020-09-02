<?php

namespace App\Http\Controllers\Api\V1\Reviews\Company;

use App\Models\Review;
use App\Models\Company;
use Illuminate\Support\Str;
use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
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
        $this->validateRequest($request); # Now we can assume the fields we need are there.

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
        $review->reviewable_type = Company::class;
        try {
            $review->reviewable_id = Company::whereUuid($this->getRequestValueOnKey($request, 'company'))->firstOrFail()->id;
        } catch (ModelNotFoundException $exception) {
            return \Response::json(
                [
                    'error' => 404,
                    'message' => 'Company not found',
                    'data' => [
                        'company_hash' => $this->getRequestValueOnKey($request, 'company'),
                    ]
                ]
            );
        }

        if ($review->hasPassingGrade()) {
            $review->status = 'active';
        }

        $review->save();

        return CompanyResource::make(Company::whereUuid($this->getRequestValueOnKey($request, 'company'))->first());
    }

    private function validateRequest(Request $request): void
    {
        $request->validate(
            [
                'company' => [
                    'uuid',
                    'exists:App\Models\Company,uuid',
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
