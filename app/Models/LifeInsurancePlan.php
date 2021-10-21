<?php

namespace App\Models;

use App\Processors\RiskRules\AgeHigherThan60;
use App\Processors\RiskRules\AgeLowerThan30;
use App\Processors\RiskRules\HasDependents;
use App\Processors\RiskRules\HouseIsMortgaged;
use App\Processors\RiskRules\IncomeHigherThan200K;
use App\Processors\RiskRules\IsMarried;
use App\Processors\RiskRules\NoHouse;
use App\Processors\RiskRules\NoIncome;
use App\Processors\RiskRules\NoVehicle;

class LifeInsurancePlan extends AbstractInsurancePlan
{
    protected array $rules = [
        [AgeHigherThan60::class,      'deny',     0],
        [AgeLowerThan30::class,       'subtract', 2],
        [IncomeHigherThan200K::class, 'subtract', 1],
        [HasDependents::class,        'add',      1],
        [IsMarried::class,            'add',      1]
    ];
}
