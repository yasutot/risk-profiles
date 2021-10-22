<?php

namespace App\Services;

use App\Factories\UserInformationFactory;
use App\Models\RiskProfile;

class RiskProfileService
{
    public static function create(array $userInformationData): RiskProfile
    {
        $userInformation = UserInformationFactory::createFromArray($userInformationData);

        $riskProfile = new RiskProfile($userInformation);

        $riskProfile->setInsurancePlanSuggestions();

        return $riskProfile;
    }
}
