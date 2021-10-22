<?php

namespace App\Factories;

use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;

class RiskRuleHandlerFactory
{
    public function create(
        UserInformation $userInformation, $riskRuleHandlerClass, $operationClass, int $value): RiskRuleHandler
    {
        $operation = new $operationClass();

        return new $riskRuleHandlerClass($userInformation, $operation, $value);
    }

    /**
     * Creates an array of RiskRuleHandlers.
     * @param UserInformation $userInformation
     * @param array $riskRuleData An array of arrays where the inner one has three keys:
     *      'rule': the risk rule class
     *      'operation': the operation class
     *      'score': the score that is going to be used in the calculation if this rule applies
     * @return array
     */
    public function createMultipleFromArray(UserInformation $userInformation, array $riskRuleData): array
    {
        return array_map(function ($data) use ($userInformation) {
            return $this->create($userInformation, $data['rule'], $data['operation'], $data['score']);
        }, $riskRuleData);
    }

    /**
     * Builds the chain of responsibility used to calculate the risk score.
     * @param array $riskRuleHandlers An array of RiskRuleHandler objects in the chain's order
     * @return RiskRuleHandler
     */
    public function createChain(array $riskRuleHandlers): RiskRuleHandler
    {
        $firstRule = array_shift($riskRuleHandlers);

        return array_reduce($riskRuleHandlers, function($chain, $rule) {
            $chain->setNext($rule);
            return $chain;
        }, $firstRule);
    }
}
