<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CompanyResource
 * @package App\Http\Resources
 * @mixin Company
 */
class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'uuid' => $this->uuid,
            'description' => $this->when((bool) $this->description, $this->description),
            $this->mergeWhen($this->reviews()->count() > 0, [
                'reviews' => $this->reviews,
                'review_count' => $this->reviews()->count(),
            ]),
        ];
    }

    public function with($request)
    {
        return [
            'related' => [
                'items' => PropertyResource::collection($this->property),
                'owners' => UserResource::collection($this->users),
            ],
            'links' => [
                'self' => route('api.v1.companies.single.id', $this->id),
                'overview' => route('api.v1.companies.fetch'),
                'create' => route('api.v1.companies.create'),
                'patch' => [

                ],
            ]
        ];
    }
}
