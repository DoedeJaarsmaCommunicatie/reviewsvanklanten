<?php

namespace App\Http\Resources;

use App\Models\Property;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PropertyResource
 * @package App\Http\Resources
 * @mixin Property
 */
class PropertyResource extends JsonResource
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
            'uuid' => $this->uuid,
            'name' => $this->name,
            'description' => $this->description,
            'reviews' => $this->reviews()->orderBy('created_at', 'desc')->get(),
            'review_count' => $this->reviews()->count(),
            'positive_average' => $this->averageActiveScore(),
            'average' => $this->averageScore(),
        ];
    }

    public function with($request): array
    {
        return [
            'related' => [
                'items' => PropertyResource::collection($this->property),
            ],
            'links' => [
                'self' => route('api.v1.properties.single.id', $this->id),
                'overview' => route('api.v1.properties.fetch'),
                'create' => route('api.v1.properties.create'),
                'reviews' => [
                    'create' => route('api.v1.properties.review.create'),
                    'fetch' => '',
                ],
            ]
        ];
    }
}
