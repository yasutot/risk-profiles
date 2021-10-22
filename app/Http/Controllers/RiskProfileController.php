<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRiskProfileRequest;
use App\Http\Resources\RiskProfileResource;
use App\Services\RiskProfileService;

class RiskProfileController extends Controller
{
    public function create(CreateRiskProfileRequest $request)
    {
        $validated = $request->validated();

        $riskProfile = RiskProfileService::create($validated);

        return (new RiskProfileResource($riskProfile))
                    ->response()
                    ->setStatusCode(201);
    }
}
