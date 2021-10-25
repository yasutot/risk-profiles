<?php

namespace App\Models;

use App\Processors\Operations\Add;
use App\Processors\Operations\Deny;
use App\Processors\Operations\Subtract;
use App\Processors\RiskRules\AgeBetween30And40;
use App\Processors\RiskRules\AgeHigherThan60;
use App\Processors\RiskRules\AgeLowerThan30;
use App\Processors\RiskRules\HasDependents;
use App\Processors\RiskRules\HouseIsMortgaged;
use App\Processors\RiskRules\IncomeHigherThan200K;
use App\Processors\RiskRules\IsMarried;
use App\Processors\RiskRules\NoHouse;
use App\Processors\RiskRules\NoIncome;
use App\Processors\RiskRules\NoVehicle;

class DisabilityInsurancePlan extends InsurancePlan
{
    public function riskRules(): array
    {
        return [
            new NoIncome($this->userInformation,             new Deny()),
            new NoVehicle($this->userInformation,            new Deny()),
            new NoHouse($this->userInformation,              new Deny()),
            new AgeHigherThan60($this->userInformation,      new Deny()),
            new AgeLowerThan30($this->userInformation,       new Subtract(2)),
            new AgeBetween30And40($this->userInformation,    new Subtract(1)),
            new IncomeHigherThan200K($this->userInformation, new Subtract(1)),
            new HouseIsMortgaged($this->userInformation,     new Add(1)),
            new HasDependents($this->userInformation,        new Add(1)),
            new IsMarried($this->userInformation,            new Subtract(1))
        ];
    }
}
