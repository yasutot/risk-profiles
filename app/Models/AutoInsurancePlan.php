<?php

namespace App\Models;

use App\Processors\RiskRules\AgeBetween30And40;
use App\Processors\RiskRules\AgeLowerThan30;
use App\Processors\RiskRules\IncomeHigherThan200K;
use App\Processors\RiskRules\NoHouse;
use App\Processors\RiskRules\NoIncome;
use App\Processors\RiskRules\NoVehicle;
use App\Processors\RiskRules\VehicleProducedAtLast5Years;

class AutoInsurancePlan extends AbstractInsurancePlan
{
    protected array $rules = [
        [NoIncome::class,                    'deny',     0],
        [NoVehicle::class,                   'deny',     0],
        [NoHouse::class,                     'deny',     0],
        [AgeLowerThan30::class,              'subtract', 2],
        [AgeBetween30And40::class,           'subtract', 1],
        [IncomeHigherThan200K::class,        'subtract', 1],
        [VehicleProducedAtLast5Years::class, 'add',      1]
    ];
}
