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

class AutoInsurancePlan extends InsurancePlan
{
    protected array $rules = [
        ['rule' => NoIncome::class,                    'operation' => Deny::class,     'score' => 0],
        ['rule' => NoVehicle::class,                   'operation' => Deny::class,     'score' => 0],
        ['rule' => NoHouse::class,                     'operation' => Deny::class,     'score' => 0],
        ['rule' => AgeLowerThan30::class,              'operation' => Subtract::class, 'score' => 2],
        ['rule' => AgeBetween30And40::class,           'operation' => Subtract::class, 'score' => 1],
        ['rule' => IncomeHigherThan200K::class,        'operation' => Subtract::class, 'score' => 1],
        ['rule' => VehicleProducedAtLast5Years::class, 'operation' => Add::class,      'score' => 1]
    ];
}
