<?php

namespace App\Models;

use App\Enums\InsurancePlanValue;
use App\Exceptions\IneligibleInsurancePlanException;
use App\Factories\RiskRuleHandlerFactory;
use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;

abstract class InsurancePlan
{
    protected UserInformation $userInformation;
    protected RiskRuleHandler $riskRuleChain;

    public function __construct(UserInformation $userInformation)
    {
        $this->userInformation = $userInformation;
        $this->riskRuleChain = RiskRuleHandlerFactory::createChain($this->riskRules());
    }

    public function evaluate(): InsurancePlanValue
    {
        try {
            $baseValue = $this->baseValue();

            $score = $this->riskRuleChain->handle($baseValue);

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
     * Returns an array of RiskRules sorted by the order the risk score should be calculated.
     * @return array
     */
    public abstract function riskRules(): array;
}
