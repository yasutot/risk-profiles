<?php

namespace App\Models;

use App\Processors\RiskRules\AgeLowerThan30;
use App\Processors\RiskRules\HouseIsMortgaged;
use App\Processors\RiskRules\IncomeHigherThan200K;
use App\Processors\RiskRules\NoHouse;
use App\Processors\RiskRules\NoIncome;
use App\Processors\RiskRules\NoVehicle;

class HomeInsurancePlan extends AbstractInsurancePlan
{
    protected array $rules = [
        [NoIncome::class,             'deny',     0],
        [NoVehicle::class,            'deny',     0],
        [NoHouse::class,              'deny',     0],
        [AgeLowerThan30::class,       'subtract', 2],
        [IncomeHigherThan200K::class, 'subtract', 1],
        [HouseIsMortgaged::class,     'add',      1],
    ];
}
