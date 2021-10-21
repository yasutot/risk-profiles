<?php

namespace App\Models;

use App\Enums\InsurancePlanValue;
use App\Exceptions\IneligibleInsurancePlanException;
use App\Factories\RiskRuleHandlerFactory;
use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;

abstract class AbstractInsurancePlan
{
    protected UserInformation $userInformation;

    /**
     * @var rules
     * Array of arrays, where the nested one should contain the rules used to calculate the insurance risk.
     * The first element is the risk rule class.
     * The second element is the operation class executed if the risk rule is validated.
     * The third is the value used in the execution.
     * Example:
     * [
     *     [NoHouse::class,        Deny::class,     0],
     *     [AgeLowerThan30::class, Add::class,      4],
     *     [IncomeHigherThan200K,  Subtract::class, 3]
     * ]
     */
    protected array $rules;

    public function __construct(UserInformation $userInformation)
    {
        $this->userInformation = $userInformation;
    }

    public function evaluate()
    {
        try {
            $score = $this->calculate();

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

    protected function calculate()
    {
        $ruleObjects = $this->instantiateRules();

        $rulesChain = $this->buildRiskRuleChain($ruleObjects);

        $baseValue = $this->baseValue();

        return $rulesChain->handle($baseValue);
    }

    /**
     * Builds the chain of responsibility used to calculate the risk score.
     * 
     * @return RiskRuleHandler
     */
    protected function buildRiskRuleChain(array $ruleObjects): RiskRuleHandler
    {
        $firstRule = array_shift($ruleObjects);

        return array_reduce($ruleObjects, function($chain, $rule) {
            $chain->setNext($rule);
            return $chain;
        }, $firstRule);
    }

    /**
     * Creates an array with the instantiated RiskRuleHandlers defined in the rule property.
     * 
     * @return array
     * 
     */
    protected function instantiateRules(): array
    {
        return array_map(function ($rule) {
            return RiskRuleHandlerFactory::create($this->userInformation, $rule[0], $rule[1], $rule[2]);
        }, $this->rules);
    }
}
