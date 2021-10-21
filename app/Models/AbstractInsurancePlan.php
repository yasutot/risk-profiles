<?php

namespace App\Models;

use App\Enums\Operation;
use App\Enums\InsurancePlanValue;
use App\Exceptions\IneligibleInsurancePlanException;
use App\Models\UserInformation;

abstract class AbstractInsurancePlan
{
    protected UserInformation $userInformation;

    /**
     * @var array
     * Array of arrays, where the nested one should contain the rules used to calculate the insurance risk.
     * The first element is the risk rule class.
     * The second element is the calculation operation.
     * The third is the value used in the calculation.
     * Example:
     * [
     *     [NoHouse::class, 'deny', 0],
     *     [AgeLowerThan30::class, 'add', 4],
     *     [IncomeHigherThan200K, 'subtract', 3]
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
        $rulesChain = $this->buildChain();

        $baseValue = $this->baseValue();

        return $rulesChain->handle($baseValue);
    }

    protected function buildChain()
    {
        $instantiatedRules = $this->instantiateRules();

        $firstRule = array_shift($instantiatedRules);

        return array_reduce($instantiatedRules, function($chain, $rule) {
            $chain->setNext($rule);
            return $chain;
        }, $firstRule);
    }

    protected function instantiateRules()
    {
        return array_map(function ($rule) {
            $ruleClass = $rule[0];
            $operation = Operation::from($rule[1]);
            $score = $rule[2];

            return new $ruleClass($this->userInformation, $operation, $score);
        }, $this->rules);
    }
}
