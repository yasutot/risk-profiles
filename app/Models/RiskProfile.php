<?php

namespace App\Models;

use App\Enums\InsurancePlanValue;

class RiskProfile
{
    protected UserInformation $userInformation;
    protected AutoInsurancePlan $autoInsurancePlan;
    protected DisabilityInsurancePlan $disabilityInsurancePlan;
    protected HomeInsurancePlan $homeInsurancePlan;
    protected LifeInsurancePlan $lifeInsurancePlan;

    public function __construct(UserInformation $userInformation)
    {
        $this->userInformation = $userInformation;
        $this->autoInsurancePlan = new AutoInsurancePlan($this->userInformation);
        $this->disabilityInsurancePlan = new DisabilityInsurancePlan($this->userInformation);
        $this->homeInsurancePlan = new HomeInsurancePlan($this->userInformation);
        $this->lifeInsurancePlan = new LifeInsurancePlan($this->userInformation);
    }

    public function getAutoInsurancePlan(): InsurancePlanValue
    {
        return $this->autoInsurancePlan->evaluate();
    }

    public function getDisabilityInsurancePlan(): InsurancePlanValue
    {
        return $this->disabilityInsurancePlan->evaluate();
    }

    public function getHomeInsurancePlan(): InsurancePlanValue
    {
        return $this->homeInsurancePlan->evaluate();
    }

    public function getLifeInsurancePlan(): InsurancePlanValue
    {
        return $this->lifeInsurancePlan->evaluate();
    }
}
