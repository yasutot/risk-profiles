<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiskProfileResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'auto' => $this->resource->getAutoInsurancePlan()->getValue(),
            'life' => $this->resource->getLifeInsurancePlan()->getValue(),
            'home' => $this->resource->getHomeInsurancePlan()->getValue(),
            'disability' => $this->resource->getDisabilityInsurancePlan()->getValue(),
        ];
    }
}
