<?php

namespace App\Models;

use App\Processors\Operations\Add;
use App\Processors\Operations\Deny;
use App\Processors\Operations\Subtract;
use App\Processors\RiskRules\AgeLowerThan30;
use App\Processors\RiskRules\HouseIsMortgaged;
use App\Processors\RiskRules\IncomeHigherThan200K;
use App\Processors\RiskRules\NoHouse;
use App\Processors\RiskRules\NoIncome;
use App\Processors\RiskRules\NoVehicle;

class HomeInsurancePlan extends InsurancePlan
{
    public function riskRules(): array
    {
        return [
            new NoIncome($this->userInformation,             new Deny(),     0),
            new NoVehicle($this->userInformation,            new Deny(),     0),
            new NoHouse($this->userInformation,              new Deny(),     0),
            new AgeLowerThan30($this->userInformation,       new Subtract(), 2),
            new IncomeHigherThan200K($this->userInformation, new Subtract(), 1),
            new HouseIsMortgaged($this->userInformation,     new Add(),      1)
        ];
    }
}
