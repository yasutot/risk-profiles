<?php

namespace App\Models;

use App\Processors\Operations\Add;
use App\Processors\Operations\Deny;
use App\Processors\Operations\Subtract;
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
        [NoIncome::class,                    Deny::class,     0],
        [NoVehicle::class,                   Deny::class,     0],
        [NoHouse::class,                     Deny::class,     0],
        [AgeLowerThan30::class,              Subtract::class, 2],
        [AgeBetween30And40::class,           Subtract::class, 1],
        [IncomeHigherThan200K::class,        Subtract::class, 1],
        [VehicleProducedAtLast5Years::class, Add::class,      1]
    ];
}
