<?php

namespace App\Models;

use App\Enums\InsurancePlanValue;

class RiskProfile
{
    protected InsurancePlanValue $autoInsurancePlan;
    protected InsurancePlanValue $disabilityInsurancePlan;
    protected InsurancePlanValue $homeInsurancePlan;
    protected InsurancePlanValue $lifeInsurancePlan;
    protected UserInformation $userInformation;

    public function __construct(UserInformation $userInformation)
    {
        $this->userInformation = $userInformation;
    }

    public function setInsurancePlanSuggestions()
    {
        $this->autoInsurancePlan = (new AutoInsurancePlan($this->userInformation))->evaluate();
        $this->lifeInsurancePlan = (new LifeInsurancePlan($this->userInformation))->evaluate();
        $this->homeInsurancePlan = (new HomeInsurancePlan($this->userInformation))->evaluate();
        $this->disabilityInsurancePlan = (new DisabilityInsurancePlan($this->userInformation))->evaluate();
    }

    public function getAutoInsurancePlan(): InsurancePlanValue
    {
        return $this->autoInsurancePlan;
    }

    public function getDisabilityInsurancePlan(): InsurancePlanValue
    {
        return $this->disabilityInsurancePlan;
    }

    public function getHomeInsurancePlan(): InsurancePlanValue
    {
        return $this->homeInsurancePlan;
    }

    public function getLifeInsurancePlan(): InsurancePlanValue
    {
        return $this->lifeInsurancePlan;
    }
}
