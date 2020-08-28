<?php

namespace App\Http\Controllers\Api\V1\Companies;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;

class Fetch extends Controller
{
    public function __invoke(Request $request)
    {
        if ($this->hasRequestKey($request, $this->getUuidRequestKey())) {
            $company = Company::whereUuid($this->getRequestValueOnKey($request, $this->getUuidRequestKey()));

            if ($company->exists()) {
                return CompanyResource::collection($company->get());
            }

            return response()->json(['error' => '404', 'message' => 'Company with hash not found', 'data' => [
                'hash' => $this->getRequestValueOnKey($request, $this->getUuidRequestKey()),
            ]], 404);
        }

        if ($this->hasRequestKey($request, $this->getSearchRequestKey())) {
            $company = Company::where('name', 'LIKE', "%{$this->getRequestValueOnKey($request, $this->getSearchRequestKey())}%");

            if (!$company->exists()) {
                return response()->json(
                    [
                        'error' => '404',
                        'message' => 'No results for company found',
                        'data' => [
                            'query' => $this->getRequestValueOnKey($request, $this->getSearchRequestKey()),
                        ],
                    ],
                    404
                );
            }

            return CompanyResource::collection($company->get());
        }

        return CompanyResource::collection(Company::all());
    }

    protected function getRequestValueOnKey(Request $request, string $key)
    {
        if (!$this->hasRequestKey($request, $key)) {
            return null;
        }

        return $request->get($key);
    }

    protected function hasRequestKey(Request $request, string $key): bool
    {
        return $request->has($key);
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
