<?php

namespace App\Http\Controllers\Api\V1\Companies;

use App\User;
use Throwable;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Exceptions\Users\BusinessLimitExceeded;

class Create extends Controller
{
    /**
     * @param Request $request
     *
     * @return CompanyResource|JsonResponse
     * @throws BusinessLimitExceeded
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user->canCreateBusiness()) {
            throw new BusinessLimitExceeded();
        }

        $company = new Company();
        $company->name = $request->input('name');
        $company->description = $request->input('description');
        $company->uuid = Str::uuid();

        try {
            $company->saveOrFail();
        } catch (Throwable $e) {
            return response()->json(
                [
                    'error' => '400',
                    'message' => 'Creation failed.'
                ],
                400
            );
        }

        $company->users()->attach($user->id);

        return CompanyResource::make($company);
    }
}
