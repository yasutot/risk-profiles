<?php

namespace App\Models;

use App\Processors\Operations\Add;
use App\Processors\Operations\Deny;
use App\Processors\Operations\Subtract;
use App\Processors\RiskRules\AgeHigherThan60;
use App\Processors\RiskRules\AgeLowerThan30;
use App\Processors\RiskRules\HasDependents;
use App\Processors\RiskRules\HouseIsMortgaged;
use App\Processors\RiskRules\IncomeHigherThan200K;
use App\Processors\RiskRules\IsMarried;
use App\Processors\RiskRules\NoHouse;
use App\Processors\RiskRules\NoIncome;
use App\Processors\RiskRules\NoVehicle;
use App\Processors\RiskRules\RiskRuleHandler;

class DisabilityInsurancePlan extends InsurancePlan
{
    public function riskRuleHandlerChain(): RiskRuleHandler
    {
        return       (new NoIncome($this->userInformation,             new Deny(),     0))
            ->setNext(new NoVehicle($this->userInformation,            new Deny(),     0))
            ->setNext(new NoHouse($this->userInformation,              new Deny(),     0))
            ->setNext(new AgeHigherThan60($this->userInformation,      new Deny(),     0))
            ->setNext(new AgeLowerThan30($this->userInformation,       new Subtract(), 2))
            ->setNext(new IncomeHigherThan200K($this->userInformation, new Subtract(), 1))
            ->setNext(new HouseIsMortgaged($this->userInformation,     new Add(),      1))
            ->setNext(new HasDependents($this->userInformation,        new Add(),      1))
            ->setNext(new IsMarried($this->userInformation,            new Subtract(), 1));
    }
}
