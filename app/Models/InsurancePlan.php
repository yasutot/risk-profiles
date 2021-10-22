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

    /**
     * @var rules
     * Array of arrays, where the nested one should contain the rules used to calculate the insurance risk.
     * The first element is the risk rule class.
     * The second element is the operation class executed if the risk rule is validated.
     * The third is the value used in the execution.
     * Example:
     * [
     *     ['rule' => NoHouse::class,        'operation' => Deny::class,     'score' => 0],
     *     ['rule' => AgeLowerThan30::class, 'operation' => Add::class,      'score' => 4],
     *     ['rule' => IncomeHigherThan200K,  'operation' => Subtract::class, 'score' => 3]
     * ]
     */
    protected array $rules = [];
    protected RiskRuleHandler $riskRuleChain;

    public function __construct(UserInformation $userInformation)
    {
        $this->userInformation = $userInformation;

        $factory = new RiskRuleHandlerFactory();
        $riskRuleObjects = $factory->createMultipleFromArray($this->userInformation, $this->rules);
        $this->riskRuleChain = $factory->createChain($riskRuleObjects);
    }

    public function evaluate()
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

    protected function createChain() {
        $riskRuleObjects = $this->riskRuleFactory->createMultipleFromArray($this->userInformation, $this->rules);

        return $this->riskRuleFactory->createChain($riskRuleObjects);
    }
}
