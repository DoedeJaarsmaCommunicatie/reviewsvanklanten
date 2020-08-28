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
            'reviews' => $this->reviews,
            'review_count' => $this->reviews()->count(),
            'average_score' => $this->averageReview(),
            'items' => PropertyResource::collection($this->property),
        ];
    }
}
