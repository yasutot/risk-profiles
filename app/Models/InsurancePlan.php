<?php

namespace App\Models;

use App\Enums\InsurancePlanValue;
use App\Exceptions\IneligibleInsurancePlanException;
use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;

abstract class InsurancePlan
{
    protected UserInformation $userInformation;

    public function __construct(UserInformation $userInformation)
    {
        $this->userInformation = $userInformation;
    }

    public function evaluate(): InsurancePlanValue
    {
        try {
            $baseValue = $this->baseValue();

            $score = $this->riskRuleHandlerChain()->handle($baseValue);

            if ($score <= 0) {
                return InsurancePlanValue::ECONOMIC();
            } else if ($score <= 2) {
                return InsurancePlanValue::REGULAR();
            }

            return InsurancePlanValue::RESPONSIBLE();

        } catch (IneligibleInsurancePlanException $e) {
            return InsurancePlanValue::INELIGIBLE();
        }
    }

    protected function baseValue()
    {
        return array_sum($this->userInformation->getRiskQuestions());
    }

    /**
     * Returns a RiskRuleHandler instance.
     * @return RiskRuleHandler
     */
    public abstract function riskRuleHandlerChain(): RiskRuleHandler;
}
